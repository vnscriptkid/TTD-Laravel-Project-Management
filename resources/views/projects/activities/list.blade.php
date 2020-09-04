<div class="col-3 bg-white">
    <h4 class="h4 font-weight-bold">Latest updates</h4>
    <ul class="list-group">
        @foreach ($project->activities as $activity)
            <li class="list-group-item pb-0">
                @if ($activity->description == 'task_updated')
                    {{ $activity->user->name }} updated the task "{{ $activity->subject->body }}"
                @elseif ($activity->description == 'task_created')
                    {{ $activity->user->name }} created a task "{{ $activity->subject->body }}"
                @elseif ($activity->description == 'created')
                    {{ $activity->user->name }} created a project
                @elseif ($activity->description == 'updated')
                    {{ $activity->user->name }} updated the project at
                    {
                        @foreach ($activity->changes['after'] as $key => $value)
                            {{ $key }} {{ $loop->last ? '' : ',' }}
                        @endforeach
                    }
                @endif
                <p class="small text-secondary">{{$activity->created_at->diffForHumans()}}</p>
            </li>
        @endforeach
    </ul>
</div>