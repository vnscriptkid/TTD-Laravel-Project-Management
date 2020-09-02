<?php

namespace Tests\Unit;

use App\Project;
use App\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_it_has_a_path() 
    {
        $this->withoutExceptionHandling();
        
        $project = factory(Project::class)->create();
        
        $task = factory(Task::class)->create([ 'project_id' => $project->id ]);

        $this->assertEquals($task->path(), '/projects/' . $project->id . '/tasks/' . $task->id);
    }

    public function test_it_belongs_to_a_project() 
    {
        $project = factory(Project::class)->create();
        
        $task = factory(Task::class)->create([ 'project_id' => $project->id ]);

        $this->assertInstanceOf(Project::class, $task->project);
    }
}
