@extends('layout/template')

@section('title','Your Cart')
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
<style>
    input[type="checkbox"] {
        appearance: none;
        -webkit-appearance: none;
        height: 25px;
        width: 25px;
        background-color: #d5d5d5;
        border-radius: 5px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    input[type="checkbox"]:after {
        font-family: "Font Awesome 5 Free";
        font-weight: 900;
        font-size: 50px;
        content: "\f00c";
        color: #000;
        display: none;
    }

    input[type="checkbox"]:hover {}

    input[type="checkbox"]:checked {
        font-family: "Font Awesome 5 Free";
        font-weight: 900;
        font-size: 50px;
        content: "\f00c";
        color: #fff;
        background-color: #00A651;
    }
</style>

<div class="container my-5">
    <h1 class="text-center">Cart</h1>

 <form onsubmit="return validate()" class="mt-4" action="{{ route('checkout') }}" method="post">
        @csrf

        @if(count($carts) > 0)
        <div class="row mb-4">
            @foreach($carts as $cart)
            <!-- Bagian Foto -->
            <div class="col-6 col-md-3">
                @foreach($cart->tour->tourPlace as $tp)
                <img src="{{ asset('images/destination/'.$tp->place->place_image) }}" class="img-fluid"
                    alt="Tour Image">
                @break
                @endforeach
            </div>

            <!-- Bagian Info -->
            <div class="col-6 col-md-7">
                <p class="mb-1 font-weight-bold">{{$cart->tour->tour_title}}</p>
                <p class="mb-1 text-muted" style="font-size: 0.9rem;">
                    <i class="bi bi-geo-alt"></i>{{$cart->tour->province->province_name}}, Indonesia
                </p>
                <div class="mb-2">
                    @foreach($cart->tour->tourCategory as $cat)
                    <span class="badge badge-primary">{{$cat->category->category_name}}</span>
                    @endforeach
                </div>
                <p class="text-danger mb-1" style="font-size: 0.9rem;">Remaining slot(s): {{$stock[$loop->index]}}</p>
                <p class="mb-1" style="font-size: 0.9rem;">
                    {{ date_format(date_create($cart->tour->start_date),"l, d F Y") }} - {{
                    date_format(date_create($cart->tour->end_date),"l, d F Y") }}
                </p>
                <p class="mb-1" style="font-size: 0.9rem;">
                    Rp{{ number_format($cart->tour->price, 2, ",", ".") }}
                </p>
            </div>

            <!-- Bagian Aksi -->
            <div class="col-12 col-md-2 mt-2 mt-md-0">
                <div class="d-flex flex-row flex-md-column justify-content-between">
                    <!-- Action Element 1: Delete Button and Checkbox -->
                    <div class="d-flex flex-row justify-content-end mb-md-3">
                        <button class="btn bi-trash3 deletebutton bottom-1 border-success" type="button" data-id="{{$cart->tour_id}}" aria-label="Delete"></button>

                        <input class="form-check-input checkbox ms-4" @if($stock[$loop->index] == 0 ||
                        $cart->tour->start_date < date('Y-m-d', strtotime('tomorrow'))) disabled @endif type="checkbox"
                            name="checkbox[]" id="checkbox{{$cart->id}}" value="{{$cart->id}}">

                            <input style="display:none" name="id[]" value="{{$cart->id}}">
                    </div>

                    <!-- Action Element 2: Quantity Control -->
                    <div class="d-flex flex-row align-items-center">
                        <div class="btn minus bg-light text-center align-self-center">-</div>
                        <input class="num text-center border-0 mx-2" name="qty[]" value="{{$cart->quantity}}" style="width: 25px">
                        <div class="btn plus bg-light text-center align-self-center">+</div>
                    </div>
                    <!-- New Message for Unavailable Tour -->
                    @if($stock[$loop->index] == 0 || $cart->tour->start_date < date('Y-m-d', strtotime('tomorrow')))
                        <div class="alert alert-warning mt-2">
                        Tour not available.
                </div>
                @endif
            </div>
        </div>
            <hr class="my-4">
@endforeach
        </div>
        <div class="text-end">
            <button type="submit" class="btn form-control text-white purchase"
                style="background-color: #3DA43A; width:150px; margin: 0 auto;">Purchase</button>
        </div>
</div>
@else
<p>There's nothing here</p>
@endif
</form>

</div>
<script>
    $(document).ready(function() {
        $('.minus').click(function () {
            var $input = $(this).next('.num');
            var value = parseInt($input.val());
            if (value > 1) {
                $input.val(value - 1);
            }
        });

        $('.plus').click(function () {
            var $input = $(this).prev('.num');
            var value = parseInt($input.val());
            $input.val(value + 1);
        });
    });
</script>
<script>
    $('.deletebutton').on('click',function(){
        var tourid = $(this).data('id'); // Mengambil ID
        $.ajax({
            type: "post",
            data: {_method: 'DELETE', _token: "{{ csrf_token() }}"},
            url: "/cart/delete/" + tourid,
             success: function (html) {
                location.reload();
             }
        })
    });
    function validate(){
        var checkboxes = $('.checkbox:checked');
        if (checkboxes.length === 0) {
            alert('Please check at least one box');
            return false;
        }
        return true;
    }
</script>
@endsection
