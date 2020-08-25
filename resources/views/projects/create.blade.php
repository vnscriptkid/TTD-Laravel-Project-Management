<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Create Project</title>
    <link rel="stylesheet" href="/css/app.css">
</head>
<body>
    <div class="container">
        <form action="/projects" method="post">
            @csrf
            <h1 class="heading is-1">Let's create a new project</h1>
            <div class="field">
                <label for="title" class="label">Title</label>
                <div class="control">
                    <input type="text" name="title" class="input" id="title" placeholder="Title">
                </div>
            </div>
            <div class="field">
                <label for="description" class="label">Description</label>
                <div class="control">
                    <input type="text" name="description" class="input" id="description" placeholder="Description">
                </div>
            </div>
            <div class="field">
                <div class="control">
                    <input type="submit" class="button is-link" placeholder="Submit">
                </div>
            </div>
        </form>
    </div>
</body>
</html>