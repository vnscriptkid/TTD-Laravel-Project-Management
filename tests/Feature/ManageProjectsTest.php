<?php

namespace Tests\Feature;

use App\Project;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ManageProjectsTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    
    public function test_a_user_can_create_a_project()
    {
        // $this->withoutExceptionHandling();
        
        $attributes = [
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
        ];
        
        $this->signIn();

        $this->get('/projects/create')->assertStatus(200);

        $this->post('/projects', $attributes)->assertRedirect('/projects');
        
        $this->assertDatabaseHas('projects', $attributes);

        $this->get('/projects')->assertSee($attributes['title']);
    }

    public function test_a_project_requires_a_title() 
    {
        $project = factory(Project::class)->raw([ 'title' => '' ]);

        $this->signIn();

        $this->post('/projects', $project)->assertSessionHasErrors('title');
    }

    public function test_a_project_requires_a_description() 
    {
        $project = factory(Project::class)->raw([ 'description' => '' ]);

        $this->signIn();

        $this->post('/projects', $project)->assertSessionHasErrors('description');
    }

    public function test_only_authenticated_user_can_create_a_project() 
    {
        $project = factory(Project::class)->raw();

        $this->get('/projects/create')->assertRedirect('login');

        $this->post('/projects', $project)->assertRedirect('login');
    }

    public function test_user_can_only_see_his_own_projects() 
    {
        $projectOfOther = factory(Project::class)->create([
            'owner_id' => factory(User::class)->create()->id
        ]);

        $myProject = factory(Project::class)->create([
            'owner_id' => ($me = factory(User::class)->create())->id
        ]);

        $this->signIn($me);

        $this->get('/projects')
            ->assertDontSee($projectOfOther->title)
            ->assertSee($myProject->title);
    }

    /* GET /projects */
    public function test_a_guest_can_not_view_project_list() 
    {
        $this->get('/projects')->assertRedirect('login');
    }

    public function test_a_user_can_view_project_list() 
    {
        $this->be(factory(User::class)->create());
        
        $this->get('/projects')->assertStatus(200);
    }

    /* GET /projects/:id */
    public function test_a_user_can_see_his_own_project() 
    {
        $user = factory(User::class)->create();
        
        $this->signIn($user);

        $project = factory('App\Project')->create([
            'owner_id' => $user->id
        ]);

        $this->get($project->path())
            ->assertSee($project->title)
            ->assertSee($project->description);
    }

    public function test_a_user_can_not_see_project_of_others() 
    {
        $this->signIn();

        $project = factory('App\Project')->create();

        $this->get($project->path())->assertStatus(403);
    }

    public function test_a_guest_can_not_view_a_project() 
    {
        $project = factory('App\Project')->create();

        $this->get($project->path())->assertRedirect('login');
    }
}