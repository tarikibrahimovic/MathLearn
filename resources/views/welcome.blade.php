@extends('layouts.app')

@section('content')

<section id="hero" class="d-flex align-items-center min-vh-100">

    <div class="container">
        <div class="row">
            <div class="col-lg-6 d-flex flex-column justify-content-center pt-4 pt-lg-0 order-2 order-lg-1">
                <h1 class="text-primary">Welcome to ProLearn</h1>
                <h2>The Best Place to Learn Programming Online</h2>
            </div>
            <div class="col-lg-6 order-1 order-lg-2 hero-img aos-init aos-animate" data-aos="zoom-in" data-aos-delay="200">
                <img src="{{asset('images/hero.png')}}" class="img-fluid animated" alt="">
            </div>
        </div>
    </div>

</section>
<section id="features">
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <div class="icon-box">
                    <i class="bi bi-laptop"></i>
                    <h3>Learn Online</h3>
                    <p>Our courses are designed to betaken online, so you can learn at your own pace and in the comfort of your own home.</p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="icon-box">
                    <i class="bi bi-award"></i>
                    <h3>Certified Instructors</h3>
                    <p>Our instructors are experts in their fields and are certified to teach our courses.</p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="icon-box">
                    <i class="bi bi-chat-dots"></i>
                    <h3>Community Support</h3>
                    <p>Join our online community to connect with other learners, ask questions, and get help.</p>
                </div>
            </div>
        </div>
    </div>

</section>

<!-- notification section -->

<section id="notifications">
    <?php
        $notifications = DB::table('notifications')->get();
        $courses = DB::table('courses')->get();
    ?>
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2>Latest News</h2>
                <hr>
            </div>
            @foreach ($notifications as $notification)
                <div class="card p-4">
                    <h3 class="border-bottom">Title: {{ $notification->title }}</h3>
                    <p class="card-text">Date: {{ $notification->created_at }} by: Admin</p>
                    <p class="card-text">Message: {{ $notification->message }}</p>
                    
                </div>
            @endforeach 
        </div>
    </div>
</section>

<hr>

<!-- Courses Section -->
<section id="courses">

    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2>Our Courses</h2>
                <a class="btn btn-primary" href="{{ route('courses.index') }}">See all Courses</a>
                <hr>
            </div>
        </div>
        <div class="row d-flex gap-3 flex-wrap justify-content-around my-4">
            @foreach ($courses as $course)
            @if($loop->iteration > 3)
            @break
            @endif
            <div class="col-lg-3 col-md-4 d-flex align-items-stretch justify-content-center">
                <div class="card col-10">
                    <img src="{{$course->image}}" class="card-img-top" alt="..." style="width: full; height:75px; object-fit:cover;">
                    <div class="card-body">
                        <h5 class="card-title">{{$course->name}}</h5>
                        <p class="card-text">{{$course->description}}</p>
                    </div>
                    <a href="{{ route('courses.show', $course->id) }}" class="btn btn-primary col-6 m-2">Learn More</a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Call to Action Section -->
<section id="cta">
    <div class="container">
        <div class="row">
            <div class="col-lg-9 text-center text-lg-start">
                <h3>Ready to start learning?</h3>
                <p>Sign up for one of our courses today and take the first step towards a new career!</p>
            </div>
            <div class="col-lg-3 cta-btn-container text-center">
                @if(Auth::check())
                    <a class="cta-btn btn btn-primary" href="{{route('courses.index')}}">Get Started</a>
                @else
                <a class="cta-btn btn btn-primary" href="{{route('register')}}">Get Started</a>
                @endif
            </div>
        </div>
    </div>
</section>
</div>
<div class="footer bg-secondary p-4 text-white">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 footer-info d-flex">
                <div class="col-6 d-flex">
                    <a href="#" class="logo d-flex align-items-center gap-3 text-decoration-none col-lg-9 col-md-12 justify-content-center">
                        <img src="{{asset('images/ProLearnLogo.png')}}" alt="" width="40" height="40">
                        <h3>ProLearn</h3>
                    </a>
                </div>

                <div class="col-lg-4 col-md-12 footer-contact text-center text-md-start d-flex flex-column align-items-end">
                    <h4>Contact Us</h4>
                    <p>
                        A108 Adam Street <br>
                        New York, NY 535022<br>
                        United States <br><br>
                        <strong>Phone:</strong> +1 5589 55488 55<br>
                        <strong>Email:</strong> info@example.com<br>
                    </p>

                </div>

            </div>
        </div>

        @endsection