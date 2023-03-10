@extends('layouts.app')

@section('content')
<div class="container">

    <form action="{{ route('courses.update', $course->id) }}" enctype="multipart/form-data" method="post">
        @csrf
        @method('put')
        <div class="form-group my-5">
            <h3>Course Info</h3>
        </div>
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" class="form-control">
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <input type="text" name="description" id="description" class="form-control">
        </div>
        <div class="form-group">
            <label for="image">Image</label>
            <input type="file" name="image" id="image" class="form-control">
        </div>


        <div class="form-group my-5">
            <h3>Add Files</h3>
        </div>

        <div class="form-group">
            <label for="fileName">File name</label>
            <input type="text" name="fileName" id="fileName" class="form-control">
        </div>

        <div class="form-group">
            <label for="fileDesc">File description</label>
            <input type="text" name="fileDesc" id="fileDesc" class="form-control">
        </div>

        <div class="form-group">
            <label for="files">Add more Files</label>
            <input type="file" name="files[]" id="files" class="form-control" multiple>
        </div>

        <button class="btn btn-primary">Save</button>
    </form>
</div>
@endsection