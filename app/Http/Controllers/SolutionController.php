<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Solution;

class SolutionController extends Controller
{
    public function index()
    {
        $solutions = Solution::query()
            ->select('id', 'content')
            ->withCount('cases')
            ->get();

        return view('solution.index', compact('solutions'));
    }
    
    public function create()
    {
        return view('solution.create');
    }
    
    public function store()
    {
        $data = $this->validate(request(), [
            'content' => 'required|string'
        ]);

        Solution::create($data);

        return redirect()
            ->route('solution.index')
            ->with('message-success', __('messages.create.success'));
    }
    
    public function edit(Solution $solution)
    {
        return view('solution.edit', compact('solution'));
    }
    
    public function update(Solution $solution)
    {
        $data = $this->validate(request(), [
            'content' => 'required|string'
        ]);

        $solution->update($data);

        return back()
            ->with('message-success', __('messages.update.success'));
    }
    
    public function delete(Solution $solution) {
        $solution->delete();
        return back()
            ->with('message-success', __('messages.delete.success'));
    }
}
