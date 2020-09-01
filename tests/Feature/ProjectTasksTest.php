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

    public function test_a_project_can_have_tasks() 
    {
        $project = factory(Project::class)->create();

        $this->signIn($project->owner);

        $this->post($project->path() . '/tasks', $task = factory(Task::class)->raw());

        $this->get($project->path())
            ->assertSee($task['body']);

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
}
