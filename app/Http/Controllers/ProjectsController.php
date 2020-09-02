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
        $this->authorize('update', $project);

        return view('projects.show', compact('project'));
    }

    public function store(Request $request) 
    {
        // validate
        $attributes = $request->validate([
            'title' => 'required|min:3',
            'description' => 'required|min:3',
            'notes' => 'nullable'
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
        $this->authorize('update', $project);
        
        $attributes = $request->validate([
            'title' => 'min:3',
            'description' => 'min:3',
            'notes' => 'nullable'
        ]);
            
        $project->update($attributes);

        return redirect($project->path());
    }

    public function edit(Request $request, Project $project) 
    {
        $this->authorize('update', $project);

        return view('projects.edit', compact('project'));
    }
}
