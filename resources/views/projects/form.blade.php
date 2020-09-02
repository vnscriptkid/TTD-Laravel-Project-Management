<div class="form-group">
    <label for="title">Title</label>
    <input value="{{ $project->title }}" name="title" type="text" class="form-control" id="title">
</div>
<div class="form-group">
    <label for="description">Description</label>
    <input value="{{ $project->description }}" name="description" type="text" class="form-control" id="description">
</div>
<button type="submit" class="btn btn-primary">Submit</button>