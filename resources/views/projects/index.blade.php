@extends('layouts.app')

@section('content')
    <h1 class="heading-1">Project List</h1>
    <ul>
        @forelse ($projects as $project)
            <li>
                <h3><a href="{{ $project->path() }}">{{ $project->title }}</a></h3>
                <p>{{ $project->description }}</p>
            </li>
        @empty
            <li>There's no project</li>
        @endforelse
    </ul>
@endsection