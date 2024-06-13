@extends('layout/template')

@section('title','Verify Email')
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
<div class="container-fluid my-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="text-center">
                <p class="font-weight-bold" style="font-size: 30px; color: #3DA43A;">Verify Your Email</p>
                <x-auth-session-status class="mb-4" :status="session('status')" />
                <x-auth-validation-errors class="mb-4" :errors="$errors" />
            </div>

            <!-- Pesan Verifikasi -->
            <div class="mb-4 text-sm text-gray-600">
                {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on
                the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
            </div>

            @if (session('status') == 'verification-link-sent')
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ __('A new verification link has been sent to the email address you provided during registration.') }}
            </div>
            @endif

            <div class="row">
                <div class="col-12">
                    <!-- Tombol 'Resend Verification Email' -->
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button type="submit" class="btn btn-primary btn-sm btn-block"
                            style="background-color: #3DA43A; border:none">Resend Verification Email</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
