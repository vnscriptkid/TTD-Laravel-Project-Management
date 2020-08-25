@extends('layouts.app')

@section('content')
    <h2>{{ $project->title }}</h2>
    <p>{{ $project->description }}</p>
@endsection