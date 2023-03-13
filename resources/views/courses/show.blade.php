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
        <div class="col-md-8">
            <p>{{$course->description}}</p>
        </div>
    </div>

    @if($user->isUser() == true)
    @if($user->isFollowing($course->id) == false)
    <form action="{{route('follows.store', $course->id)}}" method="post">
        @csrf
        @method('post')
        <button class="btn btn-primary">Follow this Course</button>
    </form>
    @else
    <form action="{{route('follows.destroy', $course->id)}}" method="post">
        @csrf
        @method('delete')
        <button class="btn btn-primary">Unfollow this Course</button>
    </form>
    @endif
    @endif


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
                    @if($user->isTeacher($course->id) == true)
                    <form action="{{route('lessons.destroy', $lesson->id)}}" method="post">
                        @csrf
                        @method('delete')
                        <button class="btn btn-danger">Delete</button>
                    </form>
                    @endif
                </li>

                @endforeach
            </ul>
        </div>
    </div>
</div>
@endsection