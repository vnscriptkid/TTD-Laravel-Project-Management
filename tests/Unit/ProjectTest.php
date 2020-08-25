<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Project;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_has_path_method() {
        $project = factory(Project::class)->create();

        $this->assertEquals($project->path(), '/projects/' . $project->id);
    }
}
