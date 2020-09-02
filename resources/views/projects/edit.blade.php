@extends('layouts.app')

@section('content')
    <form action="{{ $project->path() }}" method="post">
        @method('patch')
        @csrf
        <h2 class="heading-1">Edit project</h2>
        @include('projects.form')
    </form>
@endsection