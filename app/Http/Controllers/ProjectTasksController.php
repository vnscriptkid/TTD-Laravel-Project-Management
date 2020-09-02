<?php

namespace App\Http\Controllers;

use App\Project;
use App\Task;
use Illuminate\Http\Request;

class ProjectTasksController extends Controller
{
    public function store(Project $project) {
        // check if logged user owns the project
        $this->authorize('update', $project);
        // validate task
        $attributes = request()->validate([
            'body' => 'required'
        ]);
        // persist to db
        $project->addTask($attributes);
        // return project show view
        return view('projects.show', compact('project'));
    }

    public function update(Project $project, Task $task) {
        // check if logged user owns the project
        $this->authorize('update', $task->project);

        request()->validate([
            'body' => 'required',
            'completed' => 'nullable' // optional
        ]);

        $task->update([
            'body' => request('body'),
            'completed' => request()->has('completed')
        ]);

        return redirect($project->path());
    }
}
