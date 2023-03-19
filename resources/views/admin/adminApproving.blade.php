@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Admin dashboard</h1>
    <hr>

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

    <h2 data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="true" aria-controls="collapseExample">
        Users
    </h2>
    <div class="collapse.show" id="collapseExample">

        <div class="d-flex flex-wrap boder-bottom">
            <form action="{{ route('admin.search') }}" class="col-12 d-flex justify-content-center" method="get">
                @csrf
                @method('get')
                <input type="text" name="search" placeholder="Enter user name" class="form-control mb-3">
                <button class="btn btn-primary mx-3 col-1 h-75">Search</button>
            </form>
            @foreach($users as $user)
            <div class="border p-2 mx-2 col-5">
                <div class="d-flex gap-3 align-items-center border-bottom py-1">
                    <img src="{{ $user->image }}" alt="" style="width: 35px; height:35px; object-fit:cover; border-radius: 50%;">
                    <h3>{{$user->name}}</h3>
                    <h3>{{$user->surname}}</h3>
                </div>
                <h3>{{$user->jmbg}}</h3>
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

    </div>
    <hr>
    <h2 data-bs-toggle="collapse" href="#collapseExample2" role="button" aria-expanded="true" aria-controls="collapseExample2">
        Notifications
    </h2>

    <div class="collapse" id="collapseExample2">
        <form action="" method="post" class="d-flex flex-column justfy-content-end">
            @csrf
            @method('post')
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" name="title" id="title" class="form-control">
            </div>
            <div class="form-group">
                <label for="content">Content</label>
                <textarea name="message" id="content" cols="30" rows="10" class="form-control"></textarea>
            </div>
            <button type="submit" class="btn btn-primary mt-3 col-1">Send</button>
        </form>
    </div>
    <hr>
</div>
@endsection