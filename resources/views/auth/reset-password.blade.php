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
            <!-- Menggunakan action dari code breeze untuk memastikan fungsi reset password tetap berjalan -->
            <form method="POST" action="{{ route('password.store') }}">
                @csrf

                <!-- Menampilkan judul dan deskripsi seperti di code kostum -->
                <div class="text-center mb-4">
                    <p style="font-family: Comfortaa; font-size: 30px; color: #3DA43A;">Reset Password</p>
                    <p>Please Enter Your New Password</p>
                </div>

                <!-- Menggunakan input hidden untuk token dari code breeze -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Elemen Email Address -->
                <div class="mb-3">
                    <label for="email" class="form-label">{{ __('Email Address') }}</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="email">
                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Elemen Password -->
                <div class="mb-3">
                    <label for="password" class="form-label">{{ __('Password') }}</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Enter Your Password">
                    @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Elemen Confirm Password -->
                <div class="mb-3">
                    <label for="password-confirm" class="form-label">{{ __('Confirm Password') }}</label>
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Enter Your Password">
                </div>

                <!-- Tombol Submit -->
                <div class="mb-3">
                    <button type="submit" style="background-color: #3DA43A; border:none;" class="btn btn-primary w-100 text-white ">{{ __('Reset Password') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
