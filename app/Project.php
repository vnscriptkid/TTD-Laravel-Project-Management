<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $guarded = [];

    public function path() {
        return '/projects/' . $this->id;
    }

    public function owner() {
        return $this->belongsTo(User::class);
    }

    public function tasks() {
        return $this->hasMany(Task::class);
    }

    public function activities() {
        return $this->hasMany(Activity::class);
    }

    public function addTask($attributes) {
        return $this->tasks()->create($attributes);
    }

    public function recordActivity($message) {
        $this->activities()->create([
            'description' => $message
        ]);
    }
}
