<div class="col-3 bg-white">
    <h4 class="h4 font-weight-bold">Latest updates</h4>
    <ul class="list-group">
        @foreach ($project->activities as $activity)
            <li class="list-group-item pb-0">
                @if ($activity->description == 'task_completed')
                    You completed the task "{{ $activity->subject->body }}"
                @elseif ($activity->description == 'task_created')
                    You created a task "{{ $activity->subject->body }}"
                @elseif ($activity->description == 'created')
                    You created a project
                @elseif ($activity->description == 'updated')
                    You updated the project
                @endif
                <p class="small text-secondary">{{$activity->created_at->diffForHumans()}}</p>
            </li>
        @endforeach
    </ul>
</div>