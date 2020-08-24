<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Birdboard</title>
</head>
<body>
    <h1>Project List</h1>

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
</body>
</html>