<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CaseRecord extends Model
{
    protected $table = 'cases';

    protected $perPage = 10;

    public $fillable = [
        'stage', 'solution_id', 'recommendation', 'verified'
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
}
