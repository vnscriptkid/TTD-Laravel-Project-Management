<?php

namespace Tests\Feature;

use App\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ActivityFeedTest extends TestCase
{
    use RefreshDatabase;

    public function test_creating_project_generates_created_activity() 
    {
        $project = factory(Project::class)->create();

        $this->assertDatabaseHas('activities', [ 'description' => 'created', 'project_id' => $project->id ]);
    }

    public function test_updating_project_generates_updated_activity() 
    {
        $project = factory(Project::class)->create();

        $project->update([ 'title' => 'title updated' ]);

        $this->assertDatabaseCount('activities', 2);

        $this->assertDatabaseHas('activities', [ 'description' => 'updated', 'project_id' => $project->id ]);
    }
}
