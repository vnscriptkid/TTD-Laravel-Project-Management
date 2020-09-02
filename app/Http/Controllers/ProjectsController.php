<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;

class ProjectsController extends Controller
{
    public function index() 
    {
        $projects = auth()->user()->projects;
    
        return view('projects.index', compact('projects'));
    }

    public function show(Project $project) 
    {
        if (auth()->user()->isNot($project->owner)) {
            abort(403);
        }

        return view('projects.show', compact('project'));
    }

    public function store(Request $request) 
    {
        // validate
        $attributes = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'notes' => 'min:3'
        ]);

        $project = auth()->user()->projects()->create($attributes);

        // redirect
        return redirect($project->path());
    }

    public function create() 
    {
        return view('projects.create');
    }

    public function update(Request $request, Project $project) 
    {
        if (auth()->user()->isNot($project->owner)) {
            abort(403);
        }

        
        $attributes = $request->validate([
            'title' => 'nullable',
            'description' => 'nullable',
            'notes' => 'nullable|min:3' 
        ]);
        // dd($attributes);
            
        $project->update($attributes);

        return redirect($project->path());
    }
}
