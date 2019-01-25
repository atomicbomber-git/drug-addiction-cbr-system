<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CaseRecord extends Model
{
    protected $table = 'cases';

    public $fillable = [
        'stage', 'solution', 'recommendation'
    ];
}
