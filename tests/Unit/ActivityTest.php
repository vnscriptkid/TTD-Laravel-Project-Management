<?php

namespace Tests\Unit;

use App\Activity;
use App\Project;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ActivityTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_has_a_user() 
    {
        $this->withoutExceptionHandling();
        
        $user = $this->signIn();

        $project = factory(Project::class)->create([ 'owner_id' => $user->id ]);

        $this->assertInstanceOf(User::class, $project->activities->first()->user);

        $this->assertEquals($user->id, $project->activities->first()->user->id);
    }
}
