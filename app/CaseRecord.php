<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CaseRecord extends Model
{
    protected $table = 'cases';

    protected $perPage = 10;

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
        return $this->case_features->mapWithKeys(function($case_feature) {
            return [$case_feature['feature_id'] => $case_feature['value']];
        });
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
                ($value === $case_features_b[$feature_id] ? 1 : 0) * 
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

    private function determineWeight($a, $b)
    {
        if ($a === 0 && $b === 0) {
            return 0;
        }
        else if ($a === 0 && $b === 1) {
            return 0;
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
