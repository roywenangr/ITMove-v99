@extends('layout/template')
@section('title','Login')
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
<div class="container-md my-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div style="text-align:center">
                    <!-- Custom Title dan Deskripsi -->
                    <p style="font-family: Comfortaa; font-size:30px; color: #3DA43A;">Login</p>
                    <p>Please Provide the Following Information</p>
                    <x-auth-session-status class="mb-4" :status="session('status')" />
                    <x-auth-validation-errors class="mb-4" :errors="$errors" />
                </div>

                <!-- Email Address -->
                <div class="form-floating mb-3">
                    <x-text-input id="email" class="form-control" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="Enter Your Email" />
                    <x-input-label for="email" :value="__('Email Address')" />
                    <x-input-error :messages="$errors->get('email')" class="invalid-feedback" />
                </div>

                <!-- Password -->
                <div class="form-floating mb-3">
                    <x-text-input id="password" class="form-control"
                                  type="password"
                                  name="password"
                                  required autocomplete="current-password" placeholder="Enter Your Password" />
                    <x-input-label for="password" :value="__('Password')" />
                    <x-input-error :messages="$errors->get('password')" class="invalid-feedback" />
                </div>

                <!-- Remember Me -->
                <div class="row mb-3">
                    <div class="col-md-6 offset-md-4">
                        <label for="remember_me" class="form-check-label">
                            <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                            <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                        </label>
                    </div>
                </div>

                <!-- Buttons and Links -->
                <div class="d-flex flex-column">
                    <x-primary-button class="btn text-white" style="background-color: #3DA43A;">
                        {{ __('Log in') }}
                    </x-primary-button>

                    @if (Route::has('password.request'))
                        <a class="btn btn-link mt-3 text-decoration-none" href="{{ route('password.request') }}">
                            {{ __('Forgot Your Password?') }}
                        </a>
                    @endif

                    {{-- <div class="d-flex flex-row mt-3">
                        <hr class="flex-grow-1">
                        <p class="mx-2" style="font-size: 10px">OR</p>
                        <hr class="flex-grow-1">
                    </div> --}}
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
