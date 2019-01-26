<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CaseRecord extends Model
{
    protected $table = 'cases';

    public $fillable = [
        'stage', 'solution', 'recommendation', 'verified'
    ];

    const STAGES = [
        'Ringan', 'Sedang', 'Berat'
    ];

    public function case_features() {
        return $this->hasMany(CaseFeature::class, 'case_id');
    }
}
