<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Solution extends Model
{
    public $fillable = [
        'content'
    ];

    public function cases()
    {
        return $this->hasMany(CaseRecord::class);
    }
}
