@extends('layouts.app')

@section('content')
<div class="container">
    <form action="{{ route('courses.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('POST')
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


        <button type="submit" class="btn btn-primary">Submit</button>

    </form>
</div>
@endsection
