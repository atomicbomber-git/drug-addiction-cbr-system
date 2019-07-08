<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\CaseRecord;
use App\CaseFeature;
use App\Feature;
use App\Solution;

class UnverifiedCaseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')
            ->except(['guestCreate', 'guestStore', 'guestRetrieve']);
    }

    public function index()
    {
        $cases = CaseRecord::query()
            ->select('id', 'stage', 'solution_id')
            ->unverified()
            ->with([
                'solution:id,content',
                'case_features:feature_id,case_id,value',
                'case_features.feature:id,description,weight',
            ])
            ->orderByDesc('updated_at')
            ->paginate();

        return view('unverified_case.index', compact('cases'));
    }
    
    public function create()
    {
        $features = Feature::select('description', 'id')->get();
        return view('unverified_case.create', compact('features'));
    }

    public function guestCreate()
    {
        $features = Feature::select('description', 'id')->get();
        return view('unverified_case.guest_create', compact('features'));
    }

    public function guestStore()
    {
        $data = $this->validate(request(), [
            'features' => 'array',
            'features.*.id' => 'required|exists:features',
            'features.*.value' => 'nullable'
        ]);

        DB::transaction(function() use($data) {
            $case = CaseRecord::create(['verified' => 0]);

            foreach ($data['features'] as $feature) {
                CaseFeature::create([
                    'case_id' => $case->id,
                    'feature_id' => $feature['id'],
                    'value' => $feature['value'] ?? 0
                ]);
            }

            session(['new_case' => $case]);
        });

        return redirect()
            ->route('unverified_case.guest_retrieve');
    }

    public function guestRetrieve()
    {
        $case = session('new_case');

        // Get all the base cases
        $base_cases = CaseRecord::select('id', 'stage', 'solution_id')
            ->with([
                'case_features:case_id,feature_id,value',
                'solution:id,content'
            ])
            ->verified()
            ->get()
            ->keyBy('id');

        $case->load([
            'case_features:feature_id,case_id,value',
            'solution:id,content'
        ]);

        foreach ($base_cases as $base_case) {
            $base_case->similarity = $base_case->calculateSimilarity($case);
            $base_case->distance = $base_case->calculateDistance($case);
        }

        $closest_base_cases = $base_cases
            ->sortBy('distance')
            ->values()
            ->take(3);

        $stage = $closest_base_cases->mode("stage")[0];
        
        $closest_base_case = $closest_base_cases->sort(function ($a, $b) {
            if ($a->distance == $b->distance) {
                return $a->similarity > $b->similarity ? 1 : -1;
            }
            else {
                return $a->distance < $b->distance ? 1 : -1;
            }
        })
        ->first();

        $case = CaseRecord::find($case->id);

        $case->update([
            "stage" => $stage,
            "solution_id" => $closest_base_case->solution_id,
        ]);

        $case->load([
            'case_features:feature_id,case_id,value',
            'solution:id,content'
        ]);

        return view('unverified_case.guest_retrieve', compact('case', 'closest_base_case'));
    }
    
    public function store()
    {
        $data = $this->validate(request(), [
            'features' => 'array',
            'features.*.id' => 'required|exists:features,id',
            'features.*.value' => 'nullable'
        ]);

        DB::transaction(function() use($data) {
            $case = CaseRecord::create(['verified' => 0]);

            foreach ($data['features'] as $feature) {
                CaseFeature::create([
                    'case_id' => $case->id,
                    'feature_id' => $feature['id'],
                    'value' => $feature['value'] ?? 0
                ]);
            }
        });

        return redirect()
            ->route('unverified_case.index')
            ->with('message-success', __('messages.create.success'));
    }
    
    public function edit(CaseRecord $case)
    {
        $case->load([
            'case_features:feature_id,case_id,value',
            'case_features.feature:id,description,weight',
        ]);

        $solutions = Solution::select('id', 'content')->get();

        return view('unverified_case.edit', compact('case', 'solutions'));
    }

    public function verify(CaseRecord $case)
    {
        $case->verified = 1;
        $case->update();

        return redirect()
            ->route('base_case.index')
            ->with('message-success', __('messages.update.success'));
    }

    public function retrieve(CaseRecord $case)
    {
        // Get all the base cases
        $base_cases = CaseRecord::select('id', 'stage', 'solution_id')
            ->with([
                'case_features:case_id,feature_id,value',
                'solution:id,content'
            ])
            ->verified()
            ->get()
            ->keyBy('id');

        $case->load([
            'case_features:feature_id,case_id,value',
            'solution:id,content'
        ]);

        foreach ($base_cases as $base_case) {
            $base_case->similarity = $base_case->calculateSimilarity($case);
            $base_case->distance = $base_case->calculateDistance($case);
        }

        $most_similar_cases = $base_cases
            ->sortBy('distance')
            ->values()
            ->take(3);

        return view('unverified_case.retrieve', compact('case', 'most_similar_cases'));
    }
    
    public function update(CaseRecord $case)
    {
        $data = $this->validate(request(), [
            'features' => 'array',
            'features.*.feature_id' => 'required|exists:features,id',
            'features.*.value' => 'nullable',
            'stage' => 'nullable|string',
            'solution_id' => 'nullable|exists:solutions,id'
        ]);

        $features = collect($data["features"])
            ->keyBy('feature_id')
            ->map(function ($record, $key) {
                if (empty($record['value'])) {
                    $record['value'] = 0;
                }
                return $record;
            });

        DB::transaction(function() use($data, $case, $features) {
            foreach ($features as $feature) {
                CaseFeature::where('case_id', $case->id)
                    ->where('feature_id', $feature['feature_id'])
                    ->update(['value' => $feature['value']]);

                $case->update([
                    'stage' => $data['stage'],
                    'solution_id' => $data['solution_id']
                ]);
            }
        });

        return redirect()
            ->route('unverified_case.index')
            ->with('message-success', __('messages.update.success'));
    }
    
    public function delete(CaseRecord $case) {
        DB::transaction(function() use($case) {
            $case->case_features()->delete();
            $case->delete();
        });

        return back()
            ->with('message-success', __('messages.delete.success'));
    }
}
