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
            ->select('id', 'stage', 'solution_id', 'recommendation')
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

        // Get all features
        $feature_weights = Feature::select('id', 'weight')
            ->get()
            ->mapWithKeys(function ($feature) {
                return [$feature->id => $feature->weight];
            });

        // Get all the base cases
        $base_cases = CaseRecord::select('id', 'stage', 'solution_id')
            ->with([
                'case_features:case_id,feature_id,value',
                'solution:id,content'
            ])
            ->verified()
            ->get()
            ->keyBy('id');

        $base_cases->transform(function ($base_case) {
            $base_case->keyed_case_features = 
                $base_case->case_features->mapWithKeys(function($case_feature) {
                    return [$case_feature['feature_id'] => $case_feature['value']];
                });
            return $base_case;
        });

        $case->load([
            'case_features:feature_id,case_id,value',
            'solution:id,content'
        ]);

        $case->keyed_case_features = $case->case_features->mapWithKeys(function($case_feature) {
            return [$case_feature['feature_id'] => $case_feature['value']];
        });

        foreach ($base_cases as $base_case) {
            // Calculate similarity
            $nom = 0;
            foreach ($base_case->keyed_case_features as $feature_id => $value) {
                $nom += ((($value ^ $case->keyed_case_features[$feature_id]) ? 0 : 1) * $feature_weights[$feature_id]);
            }
            $base_case->similarity = $nom / $feature_weights->sum();
        }

        $most_similar_case = $base_cases
            ->sortByDesc('similarity')
            ->values()
            ->first();

        $stage = $base_cases
            ->sortByDesc('similarity')
            ->values()
            ->take(3)
            ->mode("stage")[0];

        $case = CaseRecord::find($case->id);

        $case->update([
            "stage" => $stage,
            "solution_id" => $most_similar_case->solution_id,
            "recommendation" => $most_similar_case->recommendation,
        ]);

        $case->load([
            'case_features:feature_id,case_id,value',
            'solution:id,content'
        ]);

        return view('unverified_case.guest_retrieve', compact('case', 'most_similar_case'));
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
        // Get all features
        $feature_weights = Feature::select('id', 'weight')
            ->get()
            ->mapWithKeys(function ($feature) {
                return [$feature->id => $feature->weight];
            });

        // Get all the base cases
        $base_cases = CaseRecord::select('id', 'stage', 'solution_id')
            ->with([
                'case_features:case_id,feature_id,value',
                'solution:id,content'
            ])
            ->verified()
            ->get()
            ->keyBy('id');

        $base_cases->transform(function ($base_case) {
            $base_case->keyed_case_features = 
                $base_case->case_features->mapWithKeys(function($case_feature) {
                    return [$case_feature['feature_id'] => $case_feature['value']];
                });
            return $base_case;
        });

        $case->load([
            'case_features:feature_id,case_id,value',
            'solution:id,content'
        ]);

        foreach ($base_cases as $base_case) {
            $base_case->similarity = $base_case->calculateSimilarity($case);
            
            // Calculates euclidean distance
            $sum = 0;
            foreach ($base_case->keyed_case_features as $feature_id => $value) {
                $sum += pow($value - $case->keyed_case_features[$feature_id], 2);
            }
            $base_case->distance = sqrt($sum);
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
