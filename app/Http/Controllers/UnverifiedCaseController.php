<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\CaseRecord;
use App\CaseFeature;
use App\Feature;
use App\Solution;
use App\Rules\AtLeastOneIsChecked;

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
            'features' => ['array', new AtLeastOneIsChecked],
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
        $closest_base_case = $case->getClosestBaseCase();

        $case->update([
            "stage" => $closest_base_case->stage,
            "solution_id" => $closest_base_case->solution_id,
        ]);

        $case->load([
            'case_features:feature_id,case_id,value',
            'solution:id,content'
        ]);

        $features = Feature::select("id")->get();
        return view('unverified_case.guest_retrieve', compact('case', 'closest_base_case', 'features'));
    }

    public function store()
    {
        $data = $this->validate(request(), [
            'features' => ['array', new AtLeastOneIsChecked],
            'features.*.id' => 'required|exists:features,id',
            'features.*.value' => 'nullable'
        ]);

        $case = new CaseRecord(['verified' => 0]);

        DB::transaction(function() use($data, $case) {
            $case->save();

            foreach ($data['features'] as $feature) {
                CaseFeature::create([
                    'case_id' => $case->id,
                    'feature_id' => $feature['id'],
                    'value' => $feature['value'] ?? 0
                ]);
            }
        });

        $closest_base_case = $case->getClosestBaseCase();
        $case->update([
            "stage" => $closest_base_case->stage,
            "solution_id" => $closest_base_case->solution_id,
        ]);

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
        $closes_base_cases = $case->getClosestBaseCases()
            ->take(CaseRecord::MAX_NEIGHBOR_COUNT);

        return view('unverified_case.retrieve', compact('case', 'closes_base_cases'));
    }

    public function update(CaseRecord $case)
    {
        $data = $this->validate(request(), [
            'solution_id' => 'nullable|exists:solutions,id'
        ]);

        $case->update($data);

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
