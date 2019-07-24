<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CaseRecord extends Model
{
    protected $table = 'cases';

    protected $perPage = 10;

    const MAX_NEIGHBOR_COUNT = 3;

    public $fillable = [
        'stage', 'solution_id', 'verified'
    ];

    const STAGES = [
        'Ringan', 'Sedang', 'Berat'
    ];

    public function scopeVerified($query)
    {
        return $query->where('verified', 1);
    }

    public function scopeUnverified($query)
    {
        return $query->where('verified', 0);
    }

    public function case_features()
    {
        return $this->hasMany(CaseFeature::class, 'case_id');
    }

    public function solution()
    {
        return $this->belongsTo(Solution::class)
            ->withDefault(['content' => '']);
    }

    public function getKeyedCaseFeaturesAttribute()
    {
        $this->loadMissing("case_features:case_id,feature_id,value");
        return $this->case_features->mapWithKeys(function($case_feature) {
            return [$case_feature['feature_id'] => $case_feature['value']];
        });
    }

    public function getClosestBaseCases()
    {
        $base_cases = CaseRecord::select('id', 'stage', 'solution_id')
            ->with(['case_features:case_id,feature_id,value', 'solution:id,content'])
            ->verified()
            ->get();

        foreach ($base_cases as $base_case) {
            $base_case->similarity = $base_case->calculateSimilarity($this);
            $base_case->distance = $base_case->calculateDistance($this);
        }

        return $base_cases->sortBy("distance")->values();
    }

    public function getClosestBaseCase($max_neighbor_count = self::MAX_NEIGHBOR_COUNT)
    {
        $closest_base_cases = $this->getClosestBaseCases()
            ->values()
            ->take($max_neighbor_count);

        $stage = $closest_base_cases->mode("stage")[0];

        $closest_base_cases = $closest_base_cases
            ->where("stage", $stage)
            ->sort(
                function ($a, $b) {
                    if ($a->distance == $b->distance) {
                        return $a->similarity < $b->similarity ? 1 : -1;
                    }
                    else {
                        return $a->distance > $b->distance ? 1 : -1;
                    }
                }
            );

        return $closest_base_cases->first();
    }

    public function calculateDistance(CaseRecord $case_record)
    {
        $sum = 0;
        foreach ($this->keyed_case_features as $feature_id => $value) {
            $sum += pow($value - $case_record->keyed_case_features[$feature_id], 2);
        }
        return sqrt($sum);
    }

    public function calculateSimilarity(CaseRecord $case_record)
    {
        $case_features_a = $this->keyed_case_features;
        $case_features_b = $case_record->keyed_case_features;

        $nominator = 0;

        foreach ($case_features_a as $feature_id => $value) {
            $nominator += (
                $this->determineSimilarity($value, $case_features_b[$feature_id]) *
                $this->determineWeight($value, $case_features_b[$feature_id])
            );
        }

        $denominator = 0;
        foreach ($case_features_a as $feature_id => $value) {
            $denominator += (
                $this->determineWeight($value, $case_features_b[$feature_id])
            );
        }

        return $nominator / $denominator;
    }

    private function determineSimilarity($a, $b)
    {
        if ($a === 0 && $b === 0) {
            return 0;
        }
        else if ($a === 0 && $b === 1) {
            return 0;
        }
        else if ($a === 1 && $b === 0) {
            return 0;
        }
        else if ($a === 1 && $b === 1) {
            return 1;
        }
        else {
            throw new \Exception("Value error.");
        }
    }

    private function determineWeight($a, $b)
    {
        if ($a === 0 && $b === 0) {
            return 0;
        }
        else if ($a === 0 && $b === 1) {
            return 1;
        }
        else if ($a === 1 && $b === 0) {
            return 1;
        }
        else if ($a === 1 && $b === 1) {
            return 1;
        }
        else {
            throw new \Exception("Value error.");
        }
    }
}
