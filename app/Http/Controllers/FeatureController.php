<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Feature;

class FeatureController extends Controller
{
    public function index()
    {
        $features = Feature::select('id', 'description')
            ->get();

        return view('feature.index', compact('features'));
    }
}
