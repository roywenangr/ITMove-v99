@extends('layout/template')

@section('title','Tour')

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


<style>
    .square-container {
        position: relative;
    }

    .text-overlay {
        position: absolute;
        top: 50%;
        /* Sesuaikan nilai ini untuk mengubah posisi vertikal teks */
        left: 50%;
        /* Sesuaikan nilai ini untuk mengubah posisi horizontal teks */
        transform: translate(-50%, -50%);
        color: white;
        /* Warna teks */
        font-size: 20px;
        /* Ukuran teks */
        text-shadow: rgb(8, 8, 8) 3px 0px 0px, rgb(8, 8, 8) 2.83487px 0.981584px 0px, rgb(8, 8, 8) 2.35766px 1.85511px 0px, rgb(8, 8, 8) 1.62091px 2.52441px 0px, rgb(8, 8, 8) 0.705713px 2.91581px 0px, rgb(8, 8, 8) -0.287171px 2.98622px 0px, rgb(8, 8, 8) -1.24844px 2.72789px 0px, rgb(8, 8, 8) -2.07227px 2.16926px 0px, rgb(8, 8, 8) -2.66798px 1.37182px 0px, rgb(8, 8, 8) -2.96998px 0.42336px 0px, rgb(8, 8, 8) -2.94502px -0.571704px 0px, rgb(8, 8, 8) -2.59586px -1.50383px 0px, rgb(8, 8, 8) -1.96093px -2.27041px 0px, rgb(8, 8, 8) -1.11013px -2.78704px 0px, rgb(8, 8, 8) -0.137119px -2.99686px 0px, rgb(8, 8, 8) 0.850987px -2.87677px 0px, rgb(8, 8, 8) 1.74541px -2.43999px 0px, rgb(8, 8, 8) 2.44769px -1.73459px 0px, rgb(8, 8, 8) 2.88051px -0.838247px 0px;
    }
</style>

<div class="container my-5">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <h3 class="mb-4" style="color: #3da43a; font-family: 'Comfortaa'; font-weight: bold">Tours</h3>

            <form id="filter" action="/tour/filter" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="province" class="form-label">Province</label>
                        <select class="form-select" name="province" id="province">
                            <option selected value="all">All</option>
                            @foreach($province as $p)
                            @php
                            $selectedP = "";
                            @endphp
                            @if ($p->id == $selectedProvince)
                            @php
                            $selectedP = "selected";
                            @endphp
                            @endif
                            <option value="{{$p->id}}" {{$selectedP}}>{{$p->province_name}}</option>
                            @endforeach
                            <!-- Add more options as needed -->
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="category" class="form-label">Category</label>
                        <select class="form-select" name="category" id="category">
                            <option selected value="all">All</option>
                            @foreach($category as $c)
                            @php
                            $selected = "";
                            @endphp
                            @if ($c->id == $selectedCategory)
                            @php
                            $selected = "selected";
                            @endphp
                            @endif
                            <option value="{{$c->id}}" {{$selected}}>{{$c->category_name}}</option>
                            @endforeach>
                            <!-- Add more options as needed -->
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="sort" class="form-label">Sort By</label>
                        <select class="form-select" name="sort" id="sort">
                            <option value="asc" {{ $selectedSort=='asc' ? 'selected' : '' }}>A-Z</option>
                            <option value="desc" {{ $selectedSort=='desc' ? 'selected' : '' }}>Z-A</option>
                            <option value="min" {{ $selectedSort=='min' ? 'selected' : '' }}>Price (Low-High)</option>
                            <option value="max" {{ $selectedSort=='max' ? 'selected' : '' }}>Price (High-Low)</option>
                        </select>
                    </div>
                </div>
                <div class="d-grid">
                    <button name="search" class="btn btn-primary"
                        style="background-color: #3DA43A; outline:#3DA43A; border:#3DA43A;"
                        type="submit">Search</button>
                </div>
            </form>

            <div class="row mt-4">
                @foreach ($tours as $tour)
                @if($stock[$loop->index] != 0)
            @php
                $tour_showup = $tour->is_public == 1;
            @endphp

            @if(Auth::user() && Auth::user()->is_admin == 1)
                @php $tour_showup = true; @endphp
            @else
                @php $tour_showup = $tour->is_public == 1; @endphp
            @endif

            @if($tour_showup)
                <!-- Example of a tour item -->
                <div class="col-md-3 col-6 mb-3">
                    <a href="/tour/detail/{{$tour->id}}" class="text-black text-decoration-none">
                        <!-- Image for the tour place -->
                        @if($selectedCategory == null || $selectedCategory == "all")
                        @foreach ($tour->tourPlace as $tp)
                        <div class="square-container">
                            <img class="square img-fluid"
                                src="{{ asset('images/destination/'. $tp->place->place_image) }}"
                                alt="{{ $tour->tour_title }}" />
                            @if($tour->start_date < date('Y-m-d', strtotime('tomorrow'))) <div class="text-overlay">Tour
                                not available.
                        </div>
                        @endif
                </div>
                @break
                @endforeach
                @else
                @foreach ($tourPlaces as $tp)
                @if($tp->tour_id - $tour->tour_id )
                <div class="square-container">
                    <img class="square img-fluid" src="{{ asset('images/destination/'. $tp->place_image) }}"
                        alt="{{ $tour->tour_title }}" />
                    @if($tour->start_date < date('Y-m-d', strtotime('tomorrow'))) <div class="text-overlay">Tour not
                        available.
                </div>
                @endif
            </div>
            @break
            @endif
            @endforeach
            @endif
            <!-- Tour title -->
            <p class="mt-2 mb-2" style="font-weight: bold">{{ $tour->tour_title }}</p>
            <!-- Tour price -->
            <p>Rp.
                <?= number_format($tour->price, 2, ",", ".") ?>
            </p>
            </a>
        </div>
        @endif
        @endif
        @endforeach
        <!-- Additional tour items would be similarly structured -->
        <!-- Pagination Links -->
        <div class="d-flex justify-content-center">
            {!! $tours->links('vendor.pagination.pag') !!}
        </div>
    </div>
</div>
</div>
</div>

@endsection
