<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\CaseRecord;
use App\CaseFeature;

class BaseCaseController extends Controller
{
    public function index()
    {
        $base_cases = CaseRecord::query()
            ->select('id', 'stage', 'solution', 'recommendation')
            ->with([
                'case_features:feature_id,case_id,value',
                'case_features.feature:id,description,weight',
            ])
            ->get();

        return view('base_case.index', compact('base_cases'));
    }
    
    public function create()
    {
    }
    
    public function store()
    {   
    }
    
    public function edit(CaseRecord $base_case)
    {
        $base_case->load([
            'case_features:feature_id,case_id,value',
            'case_features.feature:id,description,weight',
        ]);

        return view('base_case.edit', compact('base_case'));
    }
    
    public function update(CaseRecord $base_case)
    {
        $data = $this->validate(request(), [
            'value' => 'array',
            'value.*.feature_id' => 'required|exists:features,id',
            'stage' => 'required|string',
            'solution' => 'required|string'
        ]);

        $features = collect(request('features'))
            ->keyBy('feature_id')
            ->map(function ($record, $key) {
                if (empty($record['value'])) {
                    $record['value'] = 0;
                }
                return $record;
            });

        DB::transaction(function() use($data, $base_case, $features) {
            foreach ($features as $feature) {
                CaseFeature::where('case_id', $base_case->id)
                    ->where('feature_id', $feature['feature_id'])
                    ->update(['value' => $feature['value']]);

                $base_case->update([
                    'stage' => $data['stage'],
                    'solution' => $data['solution']
                ]);
            }
        });

        return back()
            ->with('message-success', __('messages.update.success'));
    }
    
    public function delete(CaseRecord $base_case) {

        DB::transaction(function() use($base_case) {
            CaseFeature::where('case_id', $base_case->id)
                ->delete();
            $base_case->delete();
        });

        return back()
            ->with('message-success', __('messages.delete.success'));
    }
}
