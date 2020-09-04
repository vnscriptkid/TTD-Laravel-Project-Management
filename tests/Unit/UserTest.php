<?php

namespace Tests\Unit;

use App\Project;
use App\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_user_has_projects_method() 
    {
        $user = factory(User::class)->create();

        $this->assertInstanceOf(Collection::class, $user->projects);
    }

    public function test_user_have_accessible_projects() 
    {
        $project = factory(Project::class)->create();

        $project->invite($otherUser = factory(User::class)->create());

        $this->assertInstanceOf(Project::class, $otherUser->accessibleProjects()->first());
    }
}
