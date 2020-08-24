<?php

namespace Tests\Feature;

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
            'title' => $this->faker()->sentence(),
            'description' => $this->faker()->paragraph()
        ];

        $this->post('/projects', $attributes)->assertRedirect('/projects');
        
        $this->assertDatabaseHas('projects', $attributes);

        $this->get('/projects')->assertSee($attributes['title']);
    }

    public function test_a_project_requires_a_title() 
    {
        $project = factory('App\Project')->raw([ 'title' => '' ]);

        $this->post('/projects', $project)->assertSessionHasErrors('title');
    }

    public function test_a_project_requires_a_description() 
    {
        $project = factory('App\Project')->raw([ 'description' => '' ]);

        $this->post('/projects', $project)->assertSessionHasErrors('description');
    }
}