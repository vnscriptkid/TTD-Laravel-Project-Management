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

    public function show() 
    {
        $project = Project::find(request('project'));

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
            'description' => 'required'
        ]);

        auth()->user()->projects()->create($attributes);

        // redirect
        return redirect('/projects');
    }
}
