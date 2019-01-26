<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\CaseRecord;
use App\CaseFeature;
use App\Feature;

class UnverifiedCaseController extends Controller
{
    public function index()
    {
        $cases = CaseRecord::query()
            ->select('id', 'stage', 'solution', 'recommendation')
            ->unverified()
            ->with([
                'case_features:feature_id,case_id,value',
                'case_features.feature:id,description,weight',
            ])
            ->orderByDesc('updated_at')
            ->get();

        return view('unverified_case.index', compact('cases'));
    }
    
    public function create()
    {
        $features = Feature::select('description', 'id')->get();
        return view('unverified_case.create', compact('features'));
    }
    
    public function store()
    {
        $data = $this->validate(request(), [
            'features' => 'array',
            'features.*.id' => 'required|exists:features,id',
            'features.*.value' => 'nullable'
        ]);

        DB::transaction(function() use($data) {
            $case = CaseRecord::create([
                'verified' => 0
            ]);

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

        return view('unverified_case.edit', compact('case'));
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
        $base_cases = CaseRecord::select('id', 'stage', 'solution')
            ->with('case_features:case_id,feature_id,value')
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

        $case->load(['case_features:feature_id,case_id,value']);
        $case->keyed_case_features = $case->case_features->mapWithKeys(function($case_feature) {
            return [$case_feature['feature_id'] => $case_feature['value']];
        });

        // Calculate similarity
        foreach ($base_cases as $base_case) {
            $nom = 0;

            foreach ($base_case->keyed_case_features as $feature_id => $value) {
                $nom += ((($value ^ $case->keyed_case_features[$feature_id]) ? 0 : 1) * $feature_weights[$feature_id])  ;
            }

            $base_case->similarity = $nom / $feature_weights->sum();
        }

        $most_similar_cases = $base_cases
            ->sortByDesc('similarity')
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
            'solution' => 'nullable|string'
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
                    'solution' => $data['solution']
                ]);
            }
        });

        return back()
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
