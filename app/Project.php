<?php

namespace App;

use Illuminate\Cache\Events\CacheHit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class Project extends Model
{
    use RecordsActivity;
    
    protected $guarded = [];

    protected static $recordableEvents = ['created', 'updated'];

    public function path() {
        return '/projects/' . $this->id;
    }

    public function owner() {
        return $this->belongsTo(User::class);
    }

    public function tasks() {
        return $this->hasMany(Task::class);
    }

    public function addTask($attributes) {
        return $this->tasks()->create($attributes);
    }
    
    public function activities() {
        return $this->hasMany(Activity::class)->latest();
    }

    public function members() {
        return $this->belongsToMany(User::class);
    }

    public function invite(User $user) {
        $this->members()->attach($user);
    }
}
