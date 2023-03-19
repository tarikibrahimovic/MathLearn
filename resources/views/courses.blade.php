@extends('layouts.app')

@section('content')

<div class="container">

    <header class="bg-light text-center py-5">
        <div class="container">
            <h1 class="mb-3 text-primary">Explore Our Courses</h1>
            <p class="lead">We offer a wide variety of courses to help you achieve your goals</p>
        </div>
    </header>
    <h1>All Courses</h1>
    <hr>
    <div class="row">
        @foreach ($courses as $course)
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h4 class="card-title">{{ $course->name }}</h4>
                    <p class="card-text">{{ $course->description }}</p>
                    <p class="card-text fst-italic">By: <img src="{{ $course->user->image }}" alt="" width="40" height="40" style="object-fit:cover; border-radius:50%"> {{ $course->user->name }} {{ $course->user->surname }}</p>
                </div>
                <div class="card-footer">
                    <a href="{{ route('courses.show', $course->id) }}" class="btn btn-primary">Learn More</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

@endsection