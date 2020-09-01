@extends('layouts.app')

@section('content')
    <form action="/projects" method="post">
        @csrf
        <h2 class="heading-1">Create a new Project</h2>
        <div class="form-group">
            <label for="title">Title</label>
            <input name="title" type="text" class="form-control" id="title">
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <input name="description" type="text" class="form-control" id="description">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection