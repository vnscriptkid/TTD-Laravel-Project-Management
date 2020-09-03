<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['body', 'completed'];

    protected $touches = ['project'];

    protected $casts = [
        'completed' => 'boolean'
    ];

    protected static function boot() {
        parent::boot();
        
        static::created(function($task) {
            $task->recordActivity('task_created');
        });
        
        static::updated(function($task) {
            $oldValue = $task->getOriginal('completed');

            if ($task->completed && !$oldValue) {
                $task->recordActivity('task_completed');
            }
        });
    }

    public function path() {
        return $this->project->path() . '/tasks/' . $this->id;
    }

    public function project() 
    {
        return $this->belongsTo(Project::class);
    }

    public function recordActivity($description) {
        $this->activities()->create([
            'project_id' => $this->project->id,
            'description' => $description
        ]);
    }

    public function activities() {
        return $this->morphMany(Activity::class, 'subject');
    }
}
