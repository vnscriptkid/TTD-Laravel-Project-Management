<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class Task extends Model
{
    use RecordsActivity;
    
    protected $fillable = ['body', 'completed'];

    protected $touches = ['project'];

    protected $casts = [
        'completed' => 'boolean'
    ];

    public function path() {
        return $this->project->path() . '/tasks/' . $this->id;
    }

    public function project() 
    {
        return $this->belongsTo(Project::class);
    }
}
