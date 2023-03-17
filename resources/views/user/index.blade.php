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

                        <a href="{{ route('user.edit', $user->id) }}" class="btn btn-primary mt-3">Change picture</a>

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

                                <th scope="col">Action</th>

                            </tr>


                        </thead>

                        <tbody>

                            @foreach ($user->courses as $course)

                            <tr>

                                <td class="align-middle">{{ $course->name }}</td>

                                <td class="align-middle">{{ $course->description }}</td>

                                <td class="align-middle">

                                    <img src="{{$course->image}}" alt="course" style="width: 75px; height:75px; object-fit:cover; border-radius: 50%;">

                                </td>

                                <td class="align-middle">

                                    <a href="{{ route('courses.show', $course->id) }}" class="btn btn-primary">View</a>

                                </td>

                            </tr>



                            @endforeach

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

    <!-- form for changing password -->

    <form action="" class="mt-3">
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

    <form action="" class="mt-3">
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

</div>

@endsection