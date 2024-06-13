@extends('layout/templateTrans')

@section('title','Home')

@section('logo', 'white')
@section('cart', 'white')
@section('profile', 'white')
@section('add', 'white')
@section('login', 'text-white')
@section('register', 'text-white')


@section('navHome', 'text-white')
@section('navTour', 'text-white')
@section('navReq', 'text-white')
@section('navGuide', 'text-white')
@section('navAbout', 'text-white')

@section('content')

<style>
    /* Untuk tampilan mobile */
    @media (max-width: 767px) {
        .responsive-image {
            max-width: 200px;
            height: 150px;
            object-fit: cover;
        }
    }

    /* Untuk tampilan desktop */
    @media (min-width: 768px) {
        .responsive-image {
            height: 320px;
            object-fit: cover;
        }
    }

    .home-packeges {
        position: relative;
    }

    .text-overlay {
    position: absolute;
    top: 50%;  /* Sesuaikan nilai ini untuk mengubah posisi vertikal teks */
    left: 50%; /* Sesuaikan nilai ini untuk mengubah posisi horizontal teks */
    transform: translate(-50%, -50%);
    color: white; /* Warna teks */
    font-size: 20px; /* Ukuran teks */
    text-shadow: rgb(8, 8, 8) 3px 0px 0px, rgb(8, 8, 8) 2.83487px 0.981584px 0px, rgb(8, 8, 8) 2.35766px 1.85511px 0px, rgb(8, 8, 8) 1.62091px 2.52441px 0px, rgb(8, 8, 8) 0.705713px 2.91581px 0px, rgb(8, 8, 8) -0.287171px 2.98622px 0px, rgb(8, 8, 8) -1.24844px 2.72789px 0px, rgb(8, 8, 8) -2.07227px 2.16926px 0px, rgb(8, 8, 8) -2.66798px 1.37182px 0px, rgb(8, 8, 8) -2.96998px 0.42336px 0px, rgb(8, 8, 8) -2.94502px -0.571704px 0px, rgb(8, 8, 8) -2.59586px -1.50383px 0px, rgb(8, 8, 8) -1.96093px -2.27041px 0px, rgb(8, 8, 8) -1.11013px -2.78704px 0px, rgb(8, 8, 8) -0.137119px -2.99686px 0px, rgb(8, 8, 8) 0.850987px -2.87677px 0px, rgb(8, 8, 8) 1.74541px -2.43999px 0px, rgb(8, 8, 8) 2.44769px -1.73459px 0px, rgb(8, 8, 8) 2.88051px -0.838247px 0px;
}

</style>

<div class="justify-items-center d-flex flex-column align-content-center " style="background: url({{ asset('images/home/background.jpg') }})  rgba(0, 0, 0, 0.5);  background-blend-mode: multiply; background-position-x: center; background-position-y: center; background-repeat: no-repeat; background-size: cover">
    @include('layout/header');
    <div class="d-flex align-items-center justify-content-center" >
    <div class="d-flex flex-column justify-content-center text-white align-items-start" style="font-size:20px; height: 450px; width:80%;">
        <div class="container">
        <h2 style="font-family: 'Comfortaa'; font-weight: 600; margin-top: -30px" >Live in moments that<br />matter.</h2>
        <a href='/tour' class="btn text-white mt-3 mb-3" type="button" style="background: #3da43a;">Explore Now</a>
        </div>
    </div>
    </div>
</div>

@if(count($tours) > 0)
<div class="container">
    <h4 class="mt-4" style="font-family: 'Comfortaa'; font-weight: 600; color:#3DA43A;">Popular Destinations</h4>
    <p class="mt-1 mb-3" style="font-size: 16px;">Our most favorite destinations you will love</p>

    <div class="row">
        @foreach($poupular as $index => $viral)
        <div class="col-md-4 col-6 mb-4">
            <form action="/tour/filter" method="POST" style="display: none;" id="form_{{ $viral->id }}">
                @csrf
                <input type="hidden" name="province" value="{{ $viral->id }}" id="province">
                <input type="hidden" name="category" value="all" id="category">
                {{-- <input type="hidden" name="sort" value="min" id="sort"> --}}
            </form>
            <a class="text-decoration-none" href="#" onclick="submitForm('{{ $viral->id }}')">
                <div class="square-container">
                    <img class="square" src="{{ asset('images/provinsi/'.$viral->place_image) }}" />
                </div>
                <p class="mt-4 text-center text-black" style="font-size: 16px; font-family: 'Comfortaa';"><strong>{{$viral->province_name}}</strong></p>
            </a>
        </div>
        @endforeach
    </div>
</div>
@endif

<div class="container-fluid" style="background: #f8f7f7;">
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-12 d-flex justify-content-center align-items-center mt-4 mb-3">
            <div>
                <h1 class="" style="font-size: 30px;">Decide your own trip</h1>
                <p>Create and customize your version of an ideal<br />trip and we'll make it happen!</p>
                <a class="btn text-white" href="/requestTrip" style="background-color: #3DA43A">Request Trip</a>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 d-none d-md-block d-flex justify-content-center align-items-center">
            <img src="{{ asset('images/home/compass.jpg') }}" class="img-fluid w-full" alt="Compass Image" />
        </div>
    </div>
</div>


@if(count($tours) > 0)
<div class="container" style="font-family: 'Comfortaa';">
    <h4 class="mt-5 text-center" style="font-family: 'Comfortaa'; font-weight: 600; color:#3DA43A">Tour Packages for you</h4>
    <p class="text-center mb-3">Explore the nature</p>
    <div class="row justify-content-center">


        <!-- Static Example of a Tour Package -->
        @foreach($tours as $index => $tour)
        <a href="/tour/detail/{{$tour->id}}" class="col-md-3 col-6 mb-4 text-decoration-none">
            <div class="card border-0">
                @foreach($tour->tourPlace as $tp)
                <div class="home-packege">
                    <img src="{{ asset('images/destination/'.$tp->place->place_image) }}" class="card-img-top responsive-image" alt="<?= $tp->place->place_image ?>">
                    @if($tour->start_date < date('Y-m-d', strtotime('tomorrow')))
                    <div class="text-overlay">Tour not available.</div>
                    @endif
                </div>
                @break
                @endforeach
                <div class="mt-2">
                    <h6 class="card-title text-black">{{$tour->tour_title}}</h6>
                    <p class="card-text text-black">Rp.<?= number_format($tour->price, 2, ",", ".") ?></p>
                </div>
            </div>
        </a>
        @endforeach

        <!-- Repeat the above block for each tour package you want to display -->
    </div>
</div>
@endif

@endsection
<script>
    function submitForm(provinceId) {
        // Simpan referensi ke form dengan id yang sesuai
        var form = document.getElementById('form_' + provinceId);

        // Submit form menggunakan JavaScript

        console.log(provinceId)
        form.submit();
    }
</script>
