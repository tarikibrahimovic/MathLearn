@extends('layouts.app')

@section('content')

<div class="container">
    @if(Session('message'))
    <div class="alert alert-success">
        {{Session('message')}}
    </div>
    @endif

    <h1>Users</h1>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Name</th>
                <th scope="col">Surname</th>
                <th scope="col">Email</th>
            </tr>
        </thead>
        <tbody>
            @foreach($followers as $follower)
            <tr>
                <td>{{$follower->user->name}}</td>
                <td>{{$follower->user->surname}}</td>
                <td>{{$follower->user->email}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>

@endsection