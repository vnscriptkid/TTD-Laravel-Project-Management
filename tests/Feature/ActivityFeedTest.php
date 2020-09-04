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

    // project-related activities
    public function test_creating_project_generates_created_activity() 
    {
        $project = factory(Project::class)->create();

        $this->assertDatabaseCount('activities', 1);

        $this->assertDatabaseHas('activities', [ 'description' => 'created', 'project_id' => $project->id ]);
    }

    public function test_updating_project_generates_updated_activity() 
    {
        $project = factory(Project::class)->create();

        $oldTitle = $project->title;

        $project->update([ 'title' => 'title updated' ]);

        $this->assertDatabaseCount('activities', 2);

        $this->assertDatabaseHas('activities', [ 'description' => 'updated', 'project_id' => $project->id ]);

        tap($project->activities->last(), function ($activity) use ($oldTitle, $project) {
            $this->assertEquals($activity->changes, [
                'before' => [ 'title' => $oldTitle ],
                'after' => [ 'title' => $project->fresh()->title ]
            ]);
        });
    }

    // task-related activities
    public function test_creating_task_generates_an_activity() 
    {
        $task = factory(Task::class)->create();

        $this->assertDatabaseCount('activities', 2);

        $this->assertDatabaseHas('activities', [ 'description' => 'task_created', 'project_id' => $task->project->id ]);

        tap($task->project->activities->last(), function($lastActivity) use ($task) {
            $this->assertEquals($lastActivity->description, 'task_created');
            $this->assertInstanceOf(Task::class, $lastActivity->subject);
            $this->assertEquals($task->body, $lastActivity->subject->body);
        });
    }

    public function test_completing_task_generates_an_activity() 
    {
        $task = factory(Task::class)->create();
        
        $task->update([ 'completed' => true ]);

        $this->assertDatabaseCount('activities', 3);

        $this->assertDatabaseHas('activities', [ 'description' => 'task_updated', 'project_id' => $task->project->id ]);

        tap($task->project->activities->last(), function($lastActivity) use ($task) {
            $this->assertEquals($lastActivity->description, 'task_updated');
            $this->assertInstanceOf(Task::class, $lastActivity->subject);
            $this->assertEquals($task->body, $lastActivity->subject->body);
        });
    }

    public function test_updating_a_task_generates_an_activity() 
    {
        $task = factory(Task::class)->create();
        
        $task->update([ 'body' => 'updated' ]);

        $this->assertDatabaseCount('activities', 3);
    }

    public function test_deleting_a_task_create_activity() 
    {
        $task = factory(Task::class)->create();
        
        $task->delete();

        $this->assertDatabaseCount('activities', 3);

        $this->assertEquals($task->activities->last()->description, 'task_deleted');
    }
}
