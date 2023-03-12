@extends('layouts.app')

@section('content')
<div class="container">
    
    <h1>{{$course->name}}</h1>

    @if(Session('message'))
    <div class="alert alert-success">
        {{Session('message')}}
    </div>
    @endif


    <div class="row">
        <div class="col-md-4">
            <img src="{{$course->image}}" alt="">
        </div>
        <div class="col-md-8">
            <p>{{$course->description}}</p>
        </div>
    </div>


    @if($user->isTeacher($course->id) == true)
    <form action="{{route('courses.edit', $course->id)}}" method="get">
        @csrf
        @method('get')
        <button class="btn btn-primary">Edit</button>
    </form>
    @endif

    <div class="row">
        <div class="col-md-12">
            <h2>Lessons</h2>
            <ul>
                @foreach($course->lesson as $lesson)
                <li>
                    <a href="{{$lesson->file}}">{{$lesson->name}}</a>
                </li>

                @endforeach
            </ul>
        </div>
    </div>
</div>
@endsection