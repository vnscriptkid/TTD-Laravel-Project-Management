<?php

namespace App;

use Illuminate\Cache\Events\CacheHit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class Project extends Model
{
    protected $guarded = [];

    public $old = [];

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
        return $this->hasMany(Activity::class)->latest();
    }

    public function addTask($attributes) {
        return $this->tasks()->create($attributes);
    }

    public function recordActivity($description) {
        $this->activities()->create([
            'description' => $description,
            'changes' => $this->buildChanges($description)
        ]);
    }

    protected function buildChanges($description) {
        return $description === 'updated' ? [
            'before' => Arr::except(array_diff($this->old, $this->getAttributes()), 'updated_at'),
            'after' => Arr::except($this->getChanges(), 'updated_at')
        ] : null;
    }
}
