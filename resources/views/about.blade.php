@extends('layout/template')

@section('title','About Us')
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

<div class="container-fluid p-5" style="background: url({{ asset('/images/home/aboutus.jpg') }}) rgba(0, 0, 0, 0.6); background-blend-mode: multiply; background-position: center; background-repeat: no-repeat; background-size: cover">
    <div class="row justify-content-center">
        <div class="col-12 col-md-4 text-center mt-5 mb-5">
            <div class="bg-transparent text-white" style="font-family: 'Comfortaa', sans-serif; font-size: 20px;">
                <h2 style="font-family: 'Comfortaa'; font-weight: 600;" class='mb-5'>About ITMove</h2>
                <p style="font-size: 16px" class="m-0">We started with the simple idea of bringing the best from us to you. From our founder to our front-line workers, we put lots of love and careful thought into all we do. We hope you enjoy all we have to offer, and share the experience with others.</p>
            </div>
        </div>
    </div>
</div>


@endsection
