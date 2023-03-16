@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row d-flex">
        <h1>{{ $test->name }}</h1>
        <hr>
        <h3>Hardness: {{ $test->hardness == 1 ? "Easy" : ($test->hardness == 2 ? "Medium" : "Hard") }}</h3>
        <h3>Number of questions: {{ $test->questions()->count() }}</h3>
        <h3>Number of helps: {{ $result->helps }}</h3>
        <h3>Score: <b class="text-success">{{ $result->score }}</b></h3>
    </div>
    <hr>
    <div class="row">
        @for($i = 0; $i < $test->questions()->count(); $i++)
            <div class="col-md-12 mb-3">
                <div class="card">
                    <div class="card-header">
                        <h3>{{ $i }}: {{ $test->questions[$i]->question }}</h3>
                    </div>
                    <div class="card-body d-flex flex-column" id="section{{$i}}">
                        @for($j = 0; $j < $test->questions[$i]->answers()->count(); $j++)
                            <div class="d-flex align-items-center {{$test->questions[$i]->answers[$j]->is_correct == true ? 'bg-success' : ''}}">
                                <input type="radio" name="answers[{{$i}}]" value="{{ $test->questions[$i]->answers[$j]->id }}" id="answer{{$i}}{{$j}}" class="m-2" {{$userAnswers[$i] == $test->questions[$i]->answers[$j]->id ? 'checked' : ''}}>
                                <label for="answer{{$i}}{{$j}}">{{ $test->questions[$i]->answers[$j]->answer }}</label>
                            </div>
                        @endfor
                    </div>
                </div>
            </div>
        @endfor
        <form action="{{ route('courses.show', $test->courses_id) }}" method='get'>
            <button class="btn btn-primary">Back to course</button>
        </form>    
    </div>
    <hr>
</div>

@endsection