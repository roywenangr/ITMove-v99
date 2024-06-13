@extends('layout/template')

@section('title','Payment History')

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
<div class="container mt-5">
    <h2 class="mb-4" style="color: #3da43a;">Payment History</h2>

    @if($history->count() > 0 )
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">#Invoice</th>
                    <th scope="col">Tour Name</th>
                    <th scope="col">Total Price</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($history as $his )
                    @php
                    $trx_id = $his->trx_id;
                    @endphp
                <!-- Repeat this part for each row of payment data -->
                <tr>
                    <td>{{ $his->trx_id }}</td>
                    <td>
                        @foreach ($trans_detail->filter(function($item) use ($trx_id) {
                            return $item->transaction_id  == $trx_id;
                        }) as $td)
                     {{ $td->tour->tour_title }}<br>
                 @endforeach
                    </td>
                    <td>Rp.{{ $his->total_price }}</td>
                    <td>
                        @if ($his->status == 'Unpaid')
                            <a href="payment/status/invoice/<?=$his->trx_id?>" class="btn btn-warning  fw-bold btn-sm">Bayar</a>
                        @elseif($his->status == 'Pending')
                        <a href="payment/status/invoice/<?=$his->trx_id?>" class="btn btn-info  text-light fw-bold btn-sm">{{ $his->status }}</a>
                        @elseif($his->status == 'Failed')
                         <button class="btn btn-danger btn-sm fw-bold">Failed</button>
                        @else
                            <button class="btn btn-success btn-sm fw-bold">PAID</button>
                        @endif
                    </td>
                </tr>
                <!-- Example ends -->
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="mb-4">
        <h6 colspan="6">There's nothing here</h6>
    </div>
    @endif
    <div class="d-flex justify-content-center">
        {!! $history->links('vendor.pagination.pag') !!}
    </div>
</div>
@endsection
