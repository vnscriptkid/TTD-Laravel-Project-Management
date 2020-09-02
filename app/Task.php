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
            $task->project->recordActivity('task_created');
        });
        
        static::updated(function($task) {
            $oldValue = $task->getOriginal('completed');

            if ($task->completed && !$oldValue) {
                $task->project->recordActivity('task_completed');
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
}
