@extends('layout/template')
@section('title','Register')
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
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <form method="POST" action="{{ route('register') }}" class="card shadow-sm p-4">
                    @csrf
                    <div class="text-center mb-4">
                        <h3 class="mb-3" style="font-family: Comfortaa; color: #3DA43A;">Register</h3>
                        <p class="text-muted">Please Provide the Following Information</p>
                        <x-auth-session-status class="mb-4" :status="session('status')" />
                        <x-auth-validation-errors class="mb-4" :errors="$errors" />
                    </div>

                    <!-- Name -->
                    <div class="mb-3">
                        <x-input-label for="name" :value="__('Name')" class="form-label" />
                        <x-text-input id="name" class="form-control" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Enter Your Name" />
                        <x-input-error :messages="$errors->get('name')" class="text-danger" />
                    </div>

                    <!-- Email Address -->
                    <div class="mb-3">
                        <x-input-label for="email" :value="__('Email Address')" class="form-label" />
                        <x-text-input id="email" class="form-control" type="email" name="email" :value="old('email')" required autocomplete="email" placeholder="Enter Your Email" />
                        <x-input-error :messages="$errors->get('email')" class="text-danger" />
                    </div>

                    <!-- Phone Number -->
                    <div class="mb-3">
                        <x-input-label for="phonenumber" :value="__('Phone Number')" class="form-label" />
                        <x-text-input id="phonenumber" class="form-control" type="number" name="phonenumber" :value="old('phonenumber')" required autocomplete="phone" placeholder="Enter Your Phone Number" />
                        <x-input-error :messages="$errors->get('phonenumber')" class="text-danger" />
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <x-input-label for="password" :value="__('Password')" class="form-label" />
                        <x-text-input id="password" class="form-control" type="password" name="password" required autocomplete="new-password" placeholder="Enter Your Password" />
                        <x-input-error :messages="$errors->get('password')" class="text-danger" />
                    </div>

                    <!-- Confirm Password -->
                    <div class="mb-4">
                        <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="form-label" />
                        <x-text-input id="password_confirmation" class="form-control" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm Your Password" />
                    </div>

                    <div class="d-flex justify-content-between align-items-center ">
                        <a href="{{ route('login') }}" class="text-decoration-none text-muted hover-underline-animation">
                            {{ __('Already registered?') }}
                        </a>
                        <x-primary-button class="btn btn-primary" style="background-color: #3DA43A;">
                            {{ __('Register') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
