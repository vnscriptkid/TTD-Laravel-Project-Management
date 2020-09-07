<?php

namespace App;

use Illuminate\Support\Arr;

trait RecordsActivity 
{
    public $oldAttributes = [];

    protected static function boot() 
    {
        parent::boot();

        static::updating(function($model) {
            $model->oldAttributes = $model->getOriginal();
        });

        $recordableEvents = self::getRecordableEvents();

        foreach ($recordableEvents as $event) {
            static::$event(function($model) use ($event) 
            {
                $event = $model->getEventName($event);

                $model->recordActivity($event);
            });
        }
    }

    protected function getEventName($event) 
    {
        if (class_basename($this) === 'Project') {
            return $event;
        }
        return strtolower(class_basename($this)) . "_{$event}";
    }

    protected static function getRecordableEvents()
    {
        if (isset(static::$recordableEvents)) {
            return static::$recordableEvents;
        }
 
        return ['created', 'updated', 'deleted'];
    }
    
    public function recordActivity($description) {
        $project = $this->project ?? $this;
        $this->activities()->create([
            'project_id' => $project->id,
            'description' => $description,
            'user_id' => $project->owner->id,
            'changes' => $this->buildChanges()
        ]);
    }

    protected function buildChanges() 
    {
        return $this->wasChanged() ? [
            'before' => Arr::except(array_diff($this->oldAttributes, $this->getAttributes()), 'updated_at'),
            'after' => Arr::except($this->getChanges(), 'updated_at')
        ] : null;
    }

    public function activities() {
        return $this->morphMany(Activity::class, 'subject');
    }
}