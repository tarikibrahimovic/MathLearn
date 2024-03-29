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
        <div class="row">
            <form action="{{ route('courses.search') }}" method="POST">
                @csrf
                @method('POST')
                <div class="input-group mb-3">
                    <input type="text" name="search" class="form-control" placeholder="Search for courses" aria-label="Search for courses" aria-describedby="button-addon2">
                    <button class="btn btn-outline-secondary" type="button" id="button-addon2">Search</button>
            </form>
        </div>
        @foreach ($courses as $course)
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h4 class="card-title">{{ $course->name }}</h4>
                    <p class="card-text">{{ $course->description }}</p>

                    <a href="{{ route('teacher.show', $course->user->jmbg) }}" class="text-decoration-none text-black">

                        <p class="card-text fst-italic">By: <img src="{{ $course->user->image }}" alt="..." width="40" height="40" style="object-fit:cover; border-radius:50%"> {{ $course->user->name }} {{ $course->user->surname }}</p>
                </div>
                <div class="card-footer">
                    <a href="{{ route('courses.show', $course->id) }}" class="btn btn-primary">Learn More</a>
                </div>
                </a>
            </div>
        </div>
        @endforeach
    </div>
</div>

@endsection