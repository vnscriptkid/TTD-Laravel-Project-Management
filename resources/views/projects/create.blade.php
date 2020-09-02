@extends('layouts.app')

@section('content')
    <form action="/projects" method="post">
        @csrf
        <h2 class="heading-1">Create a new Project</h2>
        @include('projects.form', [ 'project' => new App\Project ])
    </form>
@endsection