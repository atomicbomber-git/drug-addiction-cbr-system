<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    public $fillable = [
        'description', 'weight'
    ];
}
