@extends('layout/template')

@section('title','Settings')

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
{{-- <div class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-8 mx-auto mb-5">
                <div class="p-3 p-lg-4 bg-white shadow rounded">
                    <div class="mx-auto" style="max-width: 36rem;">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-8 mx-auto mb-5">
                <div class="p-3 p-lg-4 bg-white shadow rounded">
                    <div class="mx-auto" style="max-width: 36rem;">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-8 mx-auto mb-5">
                <div class="p-3 p-lg-4 bg-white shadow rounded">
                    <div class="mx-auto" style="max-width: 36rem;">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> --}}

<div class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-6 mx-auto mb-5">
                <div class="p-3 p-lg-4 bg-white shadow rounded">
                    <div class="mx-auto" style="max-width: 36rem;">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-6 mx-auto mb-5">
                <div class="p-3 p-lg-4 bg-white shadow rounded">
                    <div class="mx-auto" style="max-width: 36rem;">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>
            </div>

            @if(!Auth::user() || Auth::user()->is_admin == false)
            <div class="col-12 col-lg-12 mx-auto mb-5">
                <div class="p-3 p-lg-4 bg-white shadow rounded">
                    <div class="mx-auto" style="max-width: 36rem;">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
            @endif

        </div>
    </div>
</div>


@endsection
