<?php

namespace App\Http\Controllers;

use App\Project;
use App\User;
use Illuminate\Http\Request;

class ProjectInvitationsController extends Controller
{
    public function store(Project $project) 
    {
        // email must be of registered user
        request()->validate([
            'email' => 'required|exists:users,email'
        ], [
            'email.exists' => 'Email must be of a system user'
        ]);

        // invitor must be owner of project
        $this->authorize('manage', $project);

        $userToInvite = User::where(['email' => request('email')])->firstOrFail();

        $project->invite($userToInvite);

        return redirect($project->path());
    }
}
