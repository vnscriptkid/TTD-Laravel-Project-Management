<?php

namespace Tests\Feature;

use App\Project;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class InvitationTest extends TestCase
{
    use RefreshDatabase;

    /* i'm an user, i have a project
        no one can see my project now
        one day, i want my friend to join me so we can share our work
        after i send a invitation to him, he now can have access to it
     */

     public function test_user_can_invite_other_person_to_project() 
     {
        $this->withoutExceptionHandling();
         
        $user = factory(User::class)->create();

        $project = factory(Project::class)->create([ 'owner_id' => $user->id ]);
        
        $otherUser = factory(User::class)->create();

        $project->invite($otherUser);

        $this->signIn($otherUser);

        $this->get($project->path())->assertOk();
     }
}
