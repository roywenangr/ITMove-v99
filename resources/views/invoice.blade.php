@extends('layout/template')

@section('title','About Us')
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

.mt-100{
  margin-top: 50px;
}

.mb-100{
  margin-bottom: 50px;
}

.card{
    border-radius:1px !important;
}

.card-header{

    background-color:#fff;
}

.card-header:first-child {
    border-radius: calc(0.25rem - 1px) calc(0.25rem - 1px) 0 0;
}

.btn-sm, .btn-group-sm>.btn {
    padding: .25rem .5rem;
    font-size: .765625rem;
    line-height: 1.5;
    border-radius: .2rem;
}
</style>

<div class="container mt-100 mb-100 my-5">
    <div id="ui-view">
        <div>
            <div class="card">
                <div class="card-header">

                    Invoice <strong>#BBB-245432</strong>

                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-sm-4">
                            <h6 class="mb-3">From:</h6>
                            <div><strong>Afuza Pratama</strong></div>
                            <div>Email: pratama@pratama.com</div>
                            <div>Phone: +6285599291</div>
                        </div>

                        <div class="col-sm-4">
                            <h6 class="mb-3">To:</h6>
                            <div><strong>ITMOVE</strong></div>
                            <div>Email: billings@itmove.com</div>
                            <div>Phone: +6285599222</div>
                        </div>

                        <div class="col-sm-4">
                            <h6 class="mb-3">Payment Details:</h6>


                        {{-- @if($status->transaction_status == 'authorize')
                            <div class="alert alert-success">Status: Authorized</div>

                        @elseif($status->transaction_status == 'capture')
                            <div class="alert alert-primary">Status: Captured</div>

                        @elseif($status->transaction_status == 'settlement')
                            <div class="alert alert-secondary">Status: Settled</div>

                        @elseif($status->transaction_status == 'deny')
                            <div class="alert alert-danger">Status: Denied</div>

                        @elseif($status->transaction_status == 'pending')
                            <div class="alert alert-warning">Status: Pending</div>

                        @elseif($status->transaction_status == 'cancel')
                            <div class="alert alert-info">Status: Cancelled</div>

                        @elseif($status->transaction_status == 'refund')
                            <div class="alert alert-dark">Status: Refunded</div>

                        @elseif($status->transaction_status == 'partial_refund')
                            <div class="alert alert-light">Status: Partially Refunded</div>

                        @elseif($status->transaction_status == 'chargeback')
                            <div class="alert alert-danger">Status: Chargeback</div>

                        @elseif($status->transaction_status == 'partial_chargeback')
                            <div class="alert alert-danger">Status: Partial Chargeback</div>

                        @elseif($status->transaction_status == 'failure')
                            <div class="alert alert-danger">Status: Failure</div>

                        @elseif($status->transaction_status == 'expire')
                            <div class="alert alert-secondary">Status: Expired</div>
                        @endif --}}


                            <div>Invoice <strong>#{{ $status->order_id }}</strong></div>
                        </div>

                    </div>
                    <?php
                    var_dump($status);
                    ?>
                    <div class="table-responsive-sm">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Description</th>
                                    <th class="right">COST</th>
                                    <th class="right">Total</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($trans_details as $detail)
                                    <tr>
                                        <td class="left">{{ $detail->tour->tour_title }}</td>
                                        <td class="left">{{ Str::limit($detail->tour->description, 27) }}</td>
                                        <td class="center">{{ $detail->quantity }}</td>
                                        <td class="right">$900</td>
                                    </tr>
                                @endforeach


                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-sm-5">
                            {!! $statusHTML !!}
                        </div>
                        <div class="col-lg-6 col-sm-5 ml-auto">
                            <table class="table table-clear">
                                <tbody>
                                    <tr>
                                        <td class="left"><strong>Subtotal</strong></td>
                                        <td class="right">$8500</td>
                                    </tr>
                                    <tr>
                                        <td class="left"><strong>Discount (20%)</strong></td>
                                        <td class="right">$160</td>
                                    </tr>
                                    <tr>
                                        <td class="left"><strong>VAT (10%)</strong></td>
                                        <td class="right">$90</td>
                                    </tr>
                                    <tr>
                                        <td class="left"><strong>Total</strong></td>
                                        <td class="right"><strong>$9000</strong></td>
                                    </tr>
                                </tbody>
                            </table>

                            <div class="pull-right">
                                <a class="btn btn-sm btn-success" href="#" data-abc="true"><i
                                        class="fa fa-paper-plane mr-1"></i> Proceed to payment</a>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
