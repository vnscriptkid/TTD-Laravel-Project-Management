<?php

namespace Tests\Feature;

use App\Project;
use App\Task;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectTasksTest extends TestCase
{
    use RefreshDatabase;

    // create new task
    public function test_a_project_can_have_tasks() 
    {
        $task = factory(Task::class)->raw();
        
        $taskObj = factory(Task::class)->create($task);

        $this->signIn($taskObj->project->owner);

        $this->get($taskObj->project->path())
            ->assertSee($taskObj->body);

        $this->assertDatabaseHas('tasks', $task);
    }

    public function test_a_task_requires_a_body() 
    {
        $this->signIn(factory(User::class)->create());

        $project = auth()->user()->projects()->create(factory(Project::class)->raw());

        $this->post($project->path() . '/tasks', [])
            ->assertSessionHasErrors([ 'body' ]);
    }

    public function test_guest_can_not_post_a_task() 
    {
        $project = factory(Project::class)->create();

        $this->post($project->path() . '/tasks', factory(Task::class)->raw())
            ->assertRedirect('login');
    }

    public function test_only_owner_of_project_can_add_task() 
    {
        $project = factory(Project::class)->create();

        $this->signIn(factory(User::class)->create());

        $this->post($project->path() . '/tasks', $task = factory(Task::class)->raw())
            ->assertStatus(403);

        $this->assertDatabaseMissing('tasks', $task);
    }

    // update a task
    public function test_user_can_update_a_task() 
    {
        $user = factory(User::class)->create();

        $this->signIn($user);

        $project = $user->projects()->create(factory(Project::class)->raw());

        $task = $project->tasks()->create([ 'body' => 'first task' ]);

        $this->patch($task->path(), [ 'body' => 'updated', 'completed' => true ]);

        $this->assertDatabaseHas('tasks', [ 'body' => 'updated', 'completed' => true ]);
    }

    public function test_guest_can_not_update_a_task() 
    {
        $project = factory(Project::class)->create();

        $task = $project->tasks()->create([ 'body' => 'first task' ]);

        $this->patch($task->path(), ['body' => 'updated'])
            ->assertRedirect('login');
    }

    public function test_user_can_not_update_task_of_other() {
        $me = factory(User::class)->create();

        $this->signIn($me);

        $myProject = $me->projects()->create(factory(Project::class)->raw());

        $taskOfOther = factory(Task::class)->create();

        $url = $myProject->path() . '/tasks/' . $taskOfOther->id;

        $this->patch($url, [ 'body' => 'updated', 'completed' => true ])
            ->assertStatus(403);
    }
}
