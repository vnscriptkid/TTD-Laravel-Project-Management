<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Project;
use App\User;

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

    public function test_it_can_add_a_task() {
        $project = factory(Project::class)->create();

        $task = $project->addTask([ 'body' => 'task body' ]);

        $this->assertCount(1, $project->tasks);

        $this->assertTrue($project->tasks->contains($task));
    }
}
