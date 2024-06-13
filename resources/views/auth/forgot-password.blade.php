@extends('layout.template')
@section('title','Reset Password')
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
@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <!-- Session Status dari Breeze -->
            <x-auth-session-status class="mb-4 alert alert-success" :status="session('status')" />

            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <div class="text-center mb-4">
                    <p style="font-family: Comfortaa; font-size: 30px; color: #3DA43A;">Reset Password</p>
                    <p>Please Provide the Following Information</p>
                    <x-auth-validation-errors class="mb-4" :errors="$errors" />
                </div>

                <!-- Email Address -->
                <div class="mb-3">
                    <label for="email" class="form-label">{{ __('Email Address') }}</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Enter Your Email" autofocus>
                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <button type="submit" class="btn btn-success w-100">{{ __('Send Reset Password Link') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
