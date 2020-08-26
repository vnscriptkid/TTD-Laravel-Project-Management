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
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" value="Clean the house">
                                <div class="input-group-append">
                                    <span class="input-group-text">Due tomorrow</span>
                                    <div class="input-group-text">
                                        <input type="checkbox" aria-label="Checkbox for following text input">
                                    </div>
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" value="Walk the dog">
                                <div class="input-group-append">
                                    <span class="input-group-text">Due today</span>
                                    <div class="input-group-text">
                                        <input type="checkbox" aria-label="Checkbox for following text input">
                                    </div>
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" value="Study Japanese">
                                <div class="input-group-append">
                                    <span class="input-group-text">Due now</span>
                                    <div class="input-group-text">
                                        <input type="checkbox" aria-label="Checkbox for following text input">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <h4 class="h6 font-weight-bold">General Notes</h4>
                        <textarea class="form-control" aria-label="With textarea"></textarea>
                    </div>
                </div>
                <div class="col-4">
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
        <div class="col-3 bg-white">
            <h4 class="h4 font-weight-bold">Latest updates</h4>
            <ul>
                <li>You completed XYZ</li>
                <li>You added ABC</li>
            </ul>
        </div>
    </div>
@endsection