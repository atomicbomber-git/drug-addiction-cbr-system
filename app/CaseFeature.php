<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CaseFeature extends Model
{
    public $fillable = [
        'case_id',
        'feature_id',
        'value',
    ];

    public function feature()
    {
        return $this->belongsTo(Feature::class);
    }
}
