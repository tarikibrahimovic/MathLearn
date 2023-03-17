@extends('layouts.app')

@section('content')
<div class="container">


    <div class="d-flex my-3 align-items-center gap-4">
        <img src="{{$course->image}}" alt="course" style="width: 75px; height:75px; object-fit:cover; border-radius: 50%;">
        <h1>{{$course->name}}</h1>
        <form action="{{ route('courses.deactivate', $course->id) }}" method="post">
            @csrf
            @method('post')
            @if($course->status == 1)
                <button class="btn btn-danger">Deactivate</button>
            @else
                <button class="btn btn-success">Activate</button>
            @endif
        </form>
    </div>


    @if(Session('message'))
    <div class="alert alert-success">
        {{Session('message')}}
    </div>
    @endif


    <div class="row">
        <div class="col-md-8">
            <h3>{{$course->description}}</h3>
        </div>
        <div class="col-md-8">
            <h3>Course Status: <b class="{{ $course->status == 1 ? 'text-success': 'text-danger' }}">{{$course->status == 1 ? 'Active': 'Closed'}}</b></h3>
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
    <hr>


    @if($follows && $course->status == 1)

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
            window.open("{{Session('downloadFile')}}", "_blank");
            {{Session::forget('downloadFile')}}
        </script>
    @endif
    @endif
</div>
@endsection