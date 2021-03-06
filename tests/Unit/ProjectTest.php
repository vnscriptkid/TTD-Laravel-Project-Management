<?php

namespace Tests\Unit;

use App\Activity;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Project;
use App\User;
use Illuminate\Database\Eloquent\Collection;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_has_path_method() 
    {
        $project = factory(Project::class)->create();

        $this->assertEquals($project->path(), '/projects/' . $project->id);
    }

    public function test_it_belongs_to_a_user() 
    {
        $project = factory(Project::class)->create();

        $this->assertInstanceOf(User::class, $project->owner);
    }

    public function test_it_has_activities() 
    {
        $project = factory(Project::class)->create();

        $this->assertInstanceOf(Collection::class, $project->activities);
    }

    public function test_it_can_add_a_task() 
    {
        $project = factory(Project::class)->create();

        $task = $project->addTask([ 'body' => 'task body' ]);

        $this->assertCount(1, $project->tasks);

        $this->assertTrue($project->tasks->contains($task));
    }

    public function test_it_can_invite_a_user()
    {
        $project = factory(Project::class)->create();

        $project->invite($otherUser = factory(User::class)->create());

        $this->assertTrue($project->members->contains($otherUser));
    }
}
