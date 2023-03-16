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


    @if($user->isTeacher($course->id) == false)
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
    <form action="{{ route('follows.show', $course->id) }}" method="get">
        @csrf
        @method('get')
        <button class="btn btn-primary">Show Users</button>
    </form>

    @endif

    <div class="row">
        <div class="col-md-12">
            <h2>Lessons</h2>
            <ul>

                @if($user->isTeacher($course->id) == true)
                <form action="{{ route('lessons.create', $course->id) }}" method="get">
                    @csrf
                    @method('get')
                    <button class="btn btn-primary">Add Lesson</button>
                </form>
                @endif

                @foreach($course->lesson as $lesson)
                <li>
                    <a href="{{ route('lessons.download', $lesson->id) }}">{{ $lesson->name }}</a>
                    @if($user->isTeacher($course->id) == true)

                    <form action="{{ route('lessons.destroy', $lesson->id) }}" method="post">
                        @csrf
                        @method('delete')
                        <button class="btn btn-danger">Delete</button>
                    </form>
                    @endif
                </li>
                @endforeach

            </ul>
            <h2>Tests</h2>
            <ul>
                @if($user->isTeacher($course->id) == true)
                <form action="{{ route('test.create', $course->id) }}" method="get">
                    @csrf
                    @method('get')
                    <button class="btn btn-primary">Add Test</button>
                </form>
                @endif

                @if($course->test != null)
                @foreach($course->test as $test)
                <li>
                    <div class="row">
                        <a href="{{ route('test.show', $test->id) }}">{{$test->name}}</a>
                        @if($user->isTeacher($course->id) == true)
                        <form action="{{route('test.edit', $test->id)}}" method="get">
                            @csrf
                            @method('get')
                            <button class="btn btn-primary">Edit</button>
                        </form>

                        <form action="{{route('test.destroy', $test->id)}}" method="post">
                            @csrf
                            @method('delete')
                            <button class="btn btn-danger">Delete</button>
                        </form>
                        @endif
                    </div>
                </li>
                @endforeach
                @endif
            </ul>
        </div>
    </div>
    @if(Session('downloadFile'))
        <script>
            window.location.href = "{{Session('downloadFile')}}";
            setTimeout(function() {
                {{Session::forget('downloadFile')}}
                window.history.back();
            }, 1000);
        </script>
    @endif
</div>
@endsection