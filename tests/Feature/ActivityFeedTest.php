<?php

namespace Tests\Feature;

use App\Project;
use App\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ActivityFeedTest extends TestCase
{
    use RefreshDatabase;

    public function test_creating_project_generates_created_activity() 
    {
        $project = factory(Project::class)->create();

        $this->assertDatabaseCount('activities', 1);

        $this->assertDatabaseHas('activities', [ 'description' => 'created', 'project_id' => $project->id ]);
    }

    public function test_updating_project_generates_updated_activity() 
    {
        $project = factory(Project::class)->create();

        $project->update([ 'title' => 'title updated' ]);

        $this->assertDatabaseCount('activities', 2);

        $this->assertDatabaseHas('activities', [ 'description' => 'updated', 'project_id' => $project->id ]);
    }

    public function test_creating_task_generates_an_activity() 
    {
        $task = factory(Task::class)->create();

        $this->assertDatabaseCount('activities', 2);

        $this->assertDatabaseHas('activities', [ 'description' => 'task_created', 'project_id' => $task->project->id ]);
    }

    public function test_completing_task_generates_an_activity() 
    {
        $task = factory(Task::class)->create();
        
        $task->update([ 'completed' => true ]);

        $this->assertDatabaseCount('activities', 3);

        $this->assertDatabaseHas('activities', [ 'description' => 'task_completed', 'project_id' => $task->project->id ]);
    }

    public function test_just_updating_task_does_not_generates_an_activity() 
    {
        $task = factory(Task::class)->create();
        
        $task->update([ 'body' => 'updated' ]);

        $this->assertDatabaseCount('activities', 2);
    }
}
