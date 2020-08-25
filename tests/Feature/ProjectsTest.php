<?php

namespace Tests\Feature;

use App\Project;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectsTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    
    public function test_a_user_can_create_a_project()
    {
        $this->withoutExceptionHandling();
        
        $attributes = [
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
        ];

        $this->actingAs(factory(User::class)->create());

        $this->post('/projects', $attributes)->assertRedirect('/projects');
        
        $this->assertDatabaseHas('projects', $attributes);

        $this->get('/projects')->assertSee($attributes['title']);
    }

    public function test_a_project_requires_a_title() 
    {
        $project = factory(Project::class)->raw([ 'title' => '' ]);

        $this->actingAs(factory(User::class)->create());

        $this->post('/projects', $project)->assertSessionHasErrors('title');
    }

    public function test_a_project_requires_a_description() 
    {
        $project = factory(Project::class)->raw([ 'description' => '' ]);

        $this->actingAs(factory(User::class)->create());

        $this->post('/projects', $project)->assertSessionHasErrors('description');
    }

    public function test_only_authenticated_user_can_create_a_project() 
    {
        $project = factory(Project::class)->raw();

        $this->post('/projects', $project)->assertRedirect('login');
    }

    public function test_a_user_can_see_a_single_project() 
    {
        $project = factory('App\Project')->create();

        $this->get($project->path())
            ->assertSee($project->title)
            ->assertSee($project->description);
    }
}