@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between mb-3 align-items-center">
        <h1 class="h1">My Projects</h1>
        <a href="/projects/create" class="btn btn-info">Add Project</a>
    </div>
    {{-- project list --}}
    <div class="d-flex flex-wrap justify-content-between">
        @forelse ($projects as $project)
            <div class="shadow bg-white rounded mb-4 p-3 project-list-item">
                <h3 class="h4">
                    <a class="text-decoration-none text-dark" href="{{ $project->path() }}">{{ $project->title }}</a>
                </h3>
                <p>{{ $project->description }}</p>
                <div>
                    <form action="{{ $project->path() }}" method="POST" class="text-right">
                        @method('delete')                    
                        @csrf
                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        @empty
            <li>No project yet</li>
        @endforelse
    </div>
@endsection