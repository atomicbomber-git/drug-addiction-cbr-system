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
    }
    
    public function edit(CaseRecord $case)
    {
        $case->load([
            'case_features:feature_id,case_id,value',
            'case_features.feature:id,description,weight',
        ]);

        return view('unverified_case.edit', compact('case'));
    }
    
    public function update(CaseRecord $case)
    {
        $data = $this->validate(request(), [
            'value' => 'array',
            'features.*.feature_id' => 'required|exists:features,id',
            'features.*.value' => 'nullable',
            'stage' => 'required|string',
            'solution' => 'required|string'
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
