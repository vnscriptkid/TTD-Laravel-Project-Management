<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;

class ProjectTasksController extends Controller
{
    public function store(Project $project) {
        // check if logged user owns the project
        if (auth()->user()->isNot($project->owner)) {
            abort(403);
        }
        // validate task
        $attributes = request()->validate([
            'body' => 'required'
        ]);
        // persist to db
        $project->addTask($attributes);
        // return project show view
        return view('projects.show', compact('project'));
    }
}
