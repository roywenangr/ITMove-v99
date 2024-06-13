<?php

namespace App\Http\Controllers;

use stdClass;
use Midtrans\Snap;
use App\Models\Cart;
use App\Models\Tour;
use Midtrans\Config;
use App\Models\Transaction;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function cart($id)
    {
        $carts = Cart::with('tour')->where('user_id', $id)->get();
        $stock = [];

        foreach ($carts as $cart) {
            $stock[] = $this->calculateStock($cart->tour_id);
        }

        return view('cart', compact('carts', 'stock'));
    }

    private function calculateStock($tourId)
    {
        $tour = Tour::find($tourId);

        if (!$tour) {
            // Handle error if tour is not found
            return 0;
        }

        $sold = Transaction::where('status', 'Paid')
            ->join('transaction_details', 'transactions.id', '=', 'transaction_details.transaction_id')
            ->where('transaction_details.tour_id', $tourId)
            ->sum('transaction_details.quantity');

        return $tour->max_slot - $sold;
    }

    public function store($tourid, $qty)
    {
        DB::table('carts')->insert([
            'user_id' => Auth::user()->id,
            'tour_id' => $tourid,
            'quantity' => $qty
        ]);
    }

    public function update($id, $qty)
    {
        Cart::find($id)->update('quantity', $qty);
    }

    public function hapus($id)
    {
        DB::table('carts')->where('tour_id', $id)->where('user_id', Auth::user()->id)->delete();
    }
    public function checkout(Request $request)
    {
        $grossAmount = 0;
        $itemDetails = [];

        foreach ($request->checkbox as $c) {
            $id = $request->id;

            for ($i = 0; $i < count($id); $i++) {
                if ($c == $id[$i]) {
                    $cart = Cart::find($c);
                    $tour = Tour::find($cart->tour_id);
                    $price = $tour->price;
                    $qty = $request->qty[$i];
                    $grossAmount += ($price * $qty);

                    $item = new stdClass();
                    $item->id = $tour->id;
                    $item->price = $price;
                    $item->quantity = $qty;
                    $item->name = $tour->tour_title;
                    $item->merchant_name = "ITMove";

                    $itemDetails[] = $item;
                }
            }
        }

        $transactionId = 'TRX-' . date('YmdHis') . '-' . Str::random(6);

        $trans = Transaction::create([
            'trx_id' => $transactionId,
            'user_id' => Auth::user()->id,
            'total_price' => $grossAmount,
            'status' => 'Unpaid'
        ]);

        foreach ($itemDetails as $i) {
            DB::table('transaction_details')->insert([
                'transaction_id' => $trans->trx_id,
                'tour_id' =>  $i->id,
                'quantity' => $i->quantity
            ]);
        }

        Cart::where('user_id', Auth::user()->id)->delete();

        return redirect()->route('checkout.invoice', ['trx_id' => $trans->trx_id]);
    }


    public function checkoutAlone(Request $request)
    {
        $grossAmount = 0;

        $id = $request->id;
        $tour = Tour::find($id);
        $price = $tour->price;
        $qty = $request->qty;

        $grossAmount = ($price * $qty);

        $transactionId = 'TRX-' . date('YmdHis') . '-' . Str::random(6);

        $item = new stdClass();
        $item->id = $id;
        $item->price = $price;
        $item->quantity = $qty;
        $item->name = $tour->tour_title;
        $item->merchant_name = "ITMove";

        $itemDetails[] = $item;

        $trans = Transaction::create([
            'trx_id' => $transactionId,
            'user_id' => Auth::user()->id,
            'total_price' => $grossAmount,
            'status' => 'Unpaid'
        ]);


        foreach ($itemDetails as $i) {
            DB::table('transaction_details')->insert([
                'transaction_id' => $trans->trx_id,
                'tour_id' => $i->id,
                'quantity' => $i->quantity
            ]);
        }

        return redirect()->route('checkout.invoice', ['trx_id' => $trans->trx_id]);
    }

    public function invoice($trxId)
    {
        $trans = Transaction::where('trx_id', $trxId)->first();

        if (!$trans) {
            abort(404);
        }

        $trans_details = TransactionDetail::where('transaction_id', $trxId)->get();


        $transaction_details = TransactionDetail::where('transaction_id', $trans->trx_id)->get();

        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = false;
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $itemDetails = [];

        foreach ($trans_details as $detail) {
            $tour = Tour::find($detail->tour_id);

            $item = new stdClass();
            $item->id = $tour->id;
            $item->price = $tour->price;
            $item->quantity = $detail->quantity;
            $item->name = $tour->tour_title;
            $item->merchant_name = "ITMove";

            $itemDetails[] = $item;
        }

        $params = array(
            'transaction_details' => array(
                'order_id' => $trans->trx_id,
                'gross_amount' => $trans->total_price,
            ),
            'item_details' => json_decode(json_encode($itemDetails), true),
            'customer_details' => array(
                'first_name' => $trans->user->name,
                'email' => $trans->user->email,
                'phone' => $trans->user->phone
            ),
        );

        $snapToken = Snap::getSnapToken($params);


        return view('checkout', compact('trans', 'trans_details', 'snapToken', 'params'));
    }

    public function paymentStatus(Request $request, $orderId)
    {
        $transaction = Transaction::where('trx_id', $orderId)->first();
        $trans_details = TransactionDetail::where('transaction_id', $orderId)->get();

        if (!$transaction) {
            redirect()->route('payment.index');
        }

        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = false;
        Config::$isSanitized = true;
        Config::$is3ds = true;


        $status = \Midtrans\Transaction::status($orderId);


        switch ($status->transaction_status) {
            case 'authorize':
                $statusHTML = "<div class=\"alert alert-success\">Status: Authorized</div>";
                break;

            case 'capture':
                $statusHTML = "<div class=\"alert alert-primary\">Status: Captured</div>";
                break;

            case 'settlement':
                $statusHTML = "<div class=\"alert alert-secondary\">Status: Settled</div>";
                break;

            case 'deny':
                $statusHTML = "<div class=\"alert alert-danger\">Status: Denied</div>";
                break;

            case 'pending':
                $statusHTML = "<div class=\"alert alert-warning\">Status: Pending</div>";

                break;

            case 'cancel':
                $statusHTML = "<div class=\"alert alert-info\">Status: Cancelled</div>";
                break;

            case 'refund':
                $statusHTML = "<div class=\"alert alert-dark\">Status: Refunded</div>";
                break;

            case 'partial_refund':
                $statusHTML = "<div class=\"alert alert-light\">Status: Partially Refunded</div>";
                break;

            case 'chargeback':
                $statusHTML = "<div class=\"alert alert-danger\">Status: Chargeback</div>";
                break;

            case 'partial_chargeback':
                $statusHTML = "<div class=\"alert alert-danger\">Status: Partial Chargeback</div>";
                break;

            case 'failure':
                $statusHTML = "<div class=\"alert alert-danger\">Status: Failure</div>";
                break;

            case 'expire':
                $statusHTML = "<div class=\"alert alert-secondary\">Status: Expired</div>";
                break;

            default:
                $statusHTML = "<div class=\"alert alert-dark\">Status: Unknown</div>";
        }


        return view('invoice', compact('transaction', 'status','trans_details','statusHTML'));

    }
}
