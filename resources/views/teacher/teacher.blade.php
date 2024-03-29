@extends('layouts.app')

@section('content')
<div class="container">
    <h1>TEACHER</h1>

    <div class="row">
        <h3>Your courses</h3>
        <hr>
        <div class="container d-flex flex-wrap gap-2">

            @foreach($courses as $course)
    
            <div class="col-md-3" onclick="window.location.href='{{ route('courses.show', $course->id) }}'">
                <div class="card">
                    <div class="card-header d-flex align-items-center gap-3">
                    <img src="{{$course->image}}" alt="course" style="width: 75px; height:75px; object-fit:cover; border-radius: 50%;">
                        <h3>{{$course->name}}</h3>
                    </div>
                    <div class="card-body">
                        <p>{{$course->description}}</p>
                        <p>Status: <b class="{{ $course->status == 1 ? 'text-success': 'text-danger' }}">{{$course->status == 1 ? 'Active' : 'Closed'}}</b></p>
                    </div>
                </div>
            </div>
            @endforeach

        </div>
    </div>

    <form method="post" action="{{ route('courses.create') }}" >
        @csrf
        @Method('GET')
        <button class="btn btn-primary mt-3">Make a Course</button>
    </form>

</div>
@endsection
