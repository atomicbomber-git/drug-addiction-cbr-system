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

    public function edit(Feature $feature)
    {
        return view('feature.edit', compact('feature'));
    }
    
    public function update(Feature $feature)
    {
        $data = $this->validate(request(), [
            'description' => 'required|string'
        ]);

        $feature->update($data);

        return back()
            ->with('message-success', __('messages.update.success'));
    }
}
