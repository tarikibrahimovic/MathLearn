@extends('layouts.app')

@section('content')
<div class="container">
    <h1>TEACHER</h1>

    <div class="row">
        <h3>Your courses</h3>
        @foreach($courses as $course)
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3>{{$course->name}}</h3>
                </div>
                <div class="card-body">
                    <p>{{$course->description}}</p>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <form method="post" action="{{ route('courses.create') }}" novalidate>
        @csrf
        <button class="btn btn-primary">Make a Course</button>
    </form>

</div>
@endsection
