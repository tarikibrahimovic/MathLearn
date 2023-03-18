@extends('layouts.app')

@section('content')
<div class="container">
    <h1>nesto</h1>

    @if(Session::has('approved'))
    <div class="alert alert-success" role="alert">
        {{Session::get('approved')}}
    </div>
    @endif

    @if(Session::has('deleted'))
    <div class="alert alert-danger" role="alert">
        {{Session::get('deleted')}}
    </div>
    @endif

    @foreach($users as $user)
    <div class="">
        <h3>{{$user->jmbg}}</h3>
        <h3>{{$user->name}}</h3>
        <h3>{{$user->email}}</h3>
        <h3>{{$user->type}}</h3>
        <div class="">
            <img src="{{$user->image}}" alt="" width="100px" height="100px">
        </div>
        @if($user->approved == 0)
        <form action="{{ route('admin.update', [$user->jmbg]) }}" method="POST">
            @csrf
            @method('PATCH')
            <button type="submit" class="btn btn-primary">Approve</button>
        </form>
        @endif
        <form action="{{ route('admin.destroy', [$user->jmbg]) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Delete</button>
        </form>
    </div>
    @endforeach
</div>
@endsection