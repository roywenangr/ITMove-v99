@extends('layout/template')

@section('title','Purchase')
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
<div class="container mt-3 mb-1">
    <div class="row justify-content-center">
        <div class="col-12">
            <h3 class="text-success" style="font-family: 'Comfortaa';">Purchase</h3>
            <div class="row my-4">
                <!-- Section for Each Tour Item -->
                @foreach($trans_details as $td)
                <div class="col-12 col-lg-8 mb-3" style="font-family: 'Comfortaa';">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <!-- Image -->
                                @foreach($td->tour->tourPlace as $tp)
                                <div class="col-md-4 d-none d-md-block">
                                    <img src="{{ asset('images/destination/'.$tp->place->place_image)}}" class="img-fluid" alt="{{ $tp->place->place_image }}">
                                </div>
                                @break
                                @endforeach
                                <!-- Tour Details -->
                                <div class="col-12 col-md-8">
                                    <h5 class="font-weight-bold">{{$td->tour->tour_title}}</h5>
                                    <i class="bi bi-geo-alt d-none d-md-block">{{$td->tour->province->province_name}}, Indonesia</i>
                                    <p>{{ date_format(date_create($td->tour->start_date),"l, d F Y") }}</p>
                                    <p class="text-success font-weight-bold">Rp.{{ number_format($td->tour->price, 2, ",", ".") }}</p>
                                    <p>{{$td->quantity}} item(s)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                <!-- Right Section for Order Details -->
                <div class="col-12 col-lg-4" style="font-family: 'Comfortaa';">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Review Order Details</h5>
                            <div>
                                <p class="d-flex justify-content-between"><span>Booking Fee</span><span>Rp0,00</span></p>
                                <p class="d-flex justify-content-between"><span>Subtotal</span><span>Rp.{{ number_format($params['transaction_details']['gross_amount'], 2, ",", ".") }}</span></p>
                                <p class="font-weight-bold d-flex justify-content-between"><span>Total</span><span>Rp.{{ number_format($params['transaction_details']['gross_amount'], 2, ",", ".") }}</span></p>
                            </div>
                            <p class="small">Please recheck your order</p>
                            <button type="submit" id="pay-button" class="btn btn-success w-100">Pay</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var payButton = document.getElementById('pay-button');
    payButton.addEventListener('click', function () {
        window.snap.pay('{{$snapToken}}', {
            onSuccess: function(result){
                var paymentUrl = "{{ route('payment.index', ['id' => Auth::user()->id]) }}";
                window.location = paymentUrl;
            },
            onPending: function(result){
                alert("Wating your payment!");
            },
            onError: function(result){
                alert("Payment failed!");
            },
            onClose: function(){
                alert('You closed the popup without finishing the payment');
            }
        })
    });
</script>
@endsection
