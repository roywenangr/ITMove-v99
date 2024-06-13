@extends('layout/template')

@section('title','Guide')
@section('border', 'border-bottom')

@section('logo', '#3DA43A')
@section('cart', 'black')
@section('profile', 'black')
@section('login', 'text-black')
@section('register', 'text-black')
@section('navHome', 'text-black')
@section('navTour', 'text-black')
@section('navReq', 'text-black')
@section('navGuide', 'text-black')
@section('navAbout', 'text-black')
@section('add', 'black')

@section('content')

<div class="d-flex flex-column align-items-center justify-content-center p-5" style="background: url({{ asset('/images/home/aboutus.jpg') }}) rgba(0, 0, 0, 0.6); background-blend-mode: multiply; background-position: center; background-repeat: no-repeat; background-size: cover">
    <h2 class="text-white text-center mb-4" style="font-family: 'Comfortaa', sans-serif;">Guide</h2>
    <div class="text-center" style="width: 90%; font-family: 'Comfortaa', sans-serif;">
        <h4 class="text-warning">Booking Guide</h4>
        <div class="d-flex flex-column flex-md-row justify-content-around align-items-start my-5">
            <div class="guide-step">
                <i class="bi bi-1-circle-fill text-primary" style="font-size: 1.5rem;"></i>
                <h5 class="mt-2 text-light">Log In to Your Account</h5>
                <p class="text-light">Start by logging into your account to access more features</p>
            </div>
            <div class="guide-step">
                <i class="bi bi-2-circle-fill text-success" style="font-size: 1.5rem;"></i>
                <h5 class="mt-2 text-light">Go to the Tour Page</h5>
                <p class="text-light">Find the best tour package for you</p>
            </div>
            <div class="guide-step">
                <i class="bi bi-3-circle-fill text-danger" style="font-size: 1.5rem;"></i>
                <h5 class="mt-2 text-light">Purchase</h5>
                <p class="text-light">Click on the purchase button and complete your payment</p>
            </div>
            <div class="guide-step">
                <i class="bi bi-4-circle-fill text-info" style="font-size: 1.5rem;"></i>
                <h5 class="mt-2 text-light">Check Your Email</h5>
                <p class="text-light">We will send an email about your purchase</p>
            </div>
        </div>
    </div>
</div>

@endsection
