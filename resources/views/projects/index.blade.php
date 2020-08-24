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
        @foreach ($projects as $project)
            <li>
                <h3>{{ $project->title }}</h3>
                <p>{{ $project->description }}</p>
            </li>
        @endforeach
    </ul>
</body>
</html>