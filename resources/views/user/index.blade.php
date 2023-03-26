@extends('layouts.app')

@section('content')


<div class="container">

    @if (session('message'))
    <div class="col-md-12">
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    </div>
    @endif


    @if (session('error'))
    <div class="col-md-12">
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    </div>
    @endif

    <div class="row">

        <div class="col-md-4">

            <div class="card">

                <div class="card-header">

                    <h3 class="text-center">User Profile</h3>

                </div>

                <div class="card-body">

                    <div class="text-center">

                        <img src="{{$user->image}}" alt="course" style="width: 200px; height:200px; object-fit:cover; border-radius: 50%;">

                    </div>

                    <div class="text-center">

                        <a href="{{ route('user.changeImage', $user->id) }}" class="btn btn-primary mt-3">Change picture</a>

                    </div>

                    <div class="text-center mt-3">

                        <h4>{{ $user->name }} {{ $user->surname }}</h4>

                        <h5>{{ $user->email }}</h5>

                        <h5>Role: {{ $user->type }}</h5>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-md-8 overflow-auto" style="max-height: 450px;">

            <div class="card">

                <div class="card-header">

                    <h3 class="text-center">User Courses</h3>

                </div>

                <div class="card-body">

                    <table class="table table-striped">

                        <thead>

                            <tr>

                                <th scope="col">Name</th>

                                <th scope="col">Description</th>

                                <th scope="col">Image</th>

                                <th scope="col">Status</th>
                                
                                <th scope="col">Action</th>

                            </tr>


                        </thead>

                        <tbody>
                            @if(!$user->following->isEmpty())
                            @foreach ($user->following as $follow)

                            <tr>

                                <td class="align-middle">{{ $follow->course->name }}</td>

                                <td class="align-middle">{{ $follow->course->description }}</td>

                                <td class="align-middle">

                                    <img src="{{$follow->course->image}}" alt="course" style="width: 75px; height:75px; object-fit:cover; border-radius: 50%;">

                                </td>

                                <td class="align-middle">
                                    
                                    {{$user->results->whereIn('test_id', $follow->course->test->pluck('id'))->count() > 0 ? 'Completed' : 'In progress'}}
                                    
                                </td>

                                <td class="align-middle">

                                    <a href="{{ route('courses.show', $follow->course->id) }}" class="btn btn-primary">View</a>

                                </td>

                            </tr>

                            @endforeach
                            @else
                            <tr>
                                <td colspan="4" class="text-center">No courses</td>
                            </tr>
                            @endif

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

    <form action="{{ route('user.updateName') }}" class="mt-3" method="post">
        @csrf
        @method('post')
        <h2>Change Name:</h2>
        <hr>
        <div class="row m-3">
            <label for="name" class="col-form-label text-md-start">{{ __('Name') }}</label>

            <div>
                <input id="name" type="text" class="form-control" name="name" required >
            </div>
        </div>
        <div class="row m-3">
            <label for="surname" class="col-form-label text-md-start">{{ __('Surname') }}</label>

            <div>
                <input id="surname" type="text" class="form-control" name="surname" required >
            </div>
        </div>

        <div class="row m-3 text-md-end">
            <div>
                <button type="submit" class="btn btn-primary">
                    {{ __('Change Name') }}
                </button>
            </div>
        </div>
    </form>

    <form action="{{ route('user.updatePassword') }}" class="mt-3" method="post">
        @csrf
        @method('post')
        <h2>Change Password:</h2>
        <hr>
        <div class="row m-3">
            <label for="password" class="col-form-label text-md-start">{{ __('Password') }}</label>

            <div>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="row m-3">
            <label for="password-confirm" class="col-form-label text-md-start">{{ __('Confirm Password') }}</label>

            <div>
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
            </div>
        </div>

        <div class="row m-3 text-md-end">
            <div>
                <button type="submit" class="btn btn-primary">
                    {{ __('Change Password') }}
                </button>
            </div>
        </div>
    </form>

    <form action="{{ route('user.destroy') }}" method="post">
        @csrf
        @method('delete')
        <h2>Delete Account</h2>
        <hr>

        <div class="row m-3">
            <label for="password" class="col-form-label text-md-start">{{ __('Password') }}</label>

            <div>
                <input id="password" type="password" class="form-control" name="password" required >
            </div>
        </div>

        <div class="row m-3 text-md-end">
            <div>
                <button type="submit" class="btn btn-primary">
                    {{ __('Delete Account') }}
                </button>
            </div>
        </div>
    </form>

</div>

@endsection