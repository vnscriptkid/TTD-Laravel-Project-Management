@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between mb-3 align-items-center">
        <h1 class="h1">My Projects</h1>
        <div>
            <a href="/projects/create" class="btn btn-info">Add Project</a>
            <modal name="addNewProject">
                <div class="p-3">
                    <h2 class="text-center">Let's start a project</h2>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="projectTitle">Title</label>
                                <input name="title" type="text" class="form-control" id="projectTitle" placeholder="Project title" required>
                            </div>
                            <div class="form-group">
                                <label for="projectDescription">Description</label>
                                <textarea name="description" id="projectDescription" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>Need some tasks?</label>
                                <input name="task" type="text" class="form-control" placeholder="A task" required>
                            </div>
                            <button class="btn">+ One more task</button>
                        </div>
                    </div>
                    <div class="text-right">
                        <button class="btn btn-info">Cancel</button>
                        <button class="btn btn-info">Create Project</button>
                    </div>
                </div>
            </modal>
            <a href="" @click.prevent="$modal.show('addNewProject')">Add Project</a>
        </div>
    </div>
    {{-- project list --}}
    <div class="d-flex flex-wrap justify-content-between">
        @forelse ($projects as $project)
            <div class="shadow bg-white rounded mb-4 p-3 project-list-item">
                <h3 class="h4">
                    <a class="text-decoration-none text-dark" href="{{ $project->path() }}">{{ $project->title }}</a>
                </h3>
                <p>{{ $project->description }}</p>
                {{-- delete project --}}
                @can('manage', $project)
                    <div>
                        <form action="{{ $project->path() }}" method="POST" class="text-right">
                            @method('delete')                    
                            @csrf
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </div>
                @endcan
            </div>
        @empty
            <li>No project yet</li>
        @endforelse
    </div>
@endsection