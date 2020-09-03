@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-9">
            <div class="row">
                <div class="col-8">
                    <div>
                        <span class="h6 font-weight-bold">My Projects / {{ $project->title }}</span>
                        <button class="btn btn-info">Add Task</button>
                    </div>
        
                    <div>
                        <h4 class="h6 font-weight-bold">Tasks</h4>
                        <div>
                            {{-- task add form --}}
                            <form method="POST" action="{{ $project->path() . '/tasks' }}">
                                @csrf
                                <div class="form-group">
                                  <label for="newTaskForm">Add a new task</label>
                                  <input name="body" type="text" class="form-control-file" id="newTaskForm" required>
                                </div>
                              </form>
                            {{-- task list --}}
                            @forelse ($project->tasks as $task)
                                <form method="POST" action="{{ $project->path() . '/tasks/' . $task->id }}">
                                    @csrf
                                    @method('PATCH')
                                    <div class="input-group mb-3">
                                        <input name="body" type="text" class="form-control" value="{{ $task->body }}">
                                        <div class="input-group-append">
                                            <span class="input-group-text">Due tomorrow</span>
                                            <div class="input-group-text">
                                                <input name="completed" {{ $task->completed ? 'checked' : '' }} type="checkbox" onchange="this.form.submit()">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            @empty
                                <div>No task yet</div>
                            @endforelse
                        </div>
                    </div>
                    {{-- notes --}}
                    <div>
                        <h4 class="h6 font-weight-bold">General Notes</h4>
                        <form method="POST" action="{{ $project->path() }}">
                            @csrf
                            @method("PATCH")
                            <textarea name="notes" class="form-control" aria-label="With textarea">{{ $project->notes }}</textarea>
                            <button type="submit" class="btn btn-success">Update</button>
                        </form>
                    </div>
                </div>
                <div class="col-4">
                    <div><a href="{{ $project->path() . '/edit' }}" class="btn btn-warning">Edit Project</a></div>
                    <div>
                        <span>
                            <img src="https://randomuser.me/api/portraits/men/69.jpg" alt="X" class="rounded-circle avatar">
                            <img src="https://randomuser.me/api/portraits/men/27.jpg" alt="Y" class="rounded-circle avatar">
                            <img src="https://randomuser.me/api/portraits/women/75.jpg" alt="Z" class="rounded-circle avatar">
                        </span>
                        <button class="btn btn-info">Invite</button>
                    </div>
                    <div class="shadow bg-white rounded mb-4 p-3">
                        <h3 class="h4">
                            <a class="text-decoration-none text-dark" href="{{ $project->path() }}">{{ $project->title }}</a>
                        </h3>
                        <p>{{ $project->description }}</p>
                    </div>
                </div>
            </div>
        </div>
        {{-- activies --}}
        @include('projects.activities.list')
    </div>
@endsection