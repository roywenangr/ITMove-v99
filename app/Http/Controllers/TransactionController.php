<?php

namespace App\Http\Controllers;

use App\Models\Tour;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\TransactionDetail;

class TransactionController extends Controller
{
    public function callback(Request $request){
        $server_key = config('midtrans.server_key');

        $sign_key = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $server_key);

        if ($sign_key == $request->signature_key){
            if($request->transaction_status == "capture"){
                $trans = Transaction::where('trx_id', $request->order_id)->first();
                if ($trans) {
                    $trans->update(['status' => 'Paid']);

                    $transaction_details = TransactionDetail::class::where('transaction_id', $request->order_id)->get();

                    foreach ($transaction_details as $detail) {
                        $tour = Tour::find($detail->tour_id);
                        $tour->update([
                            'max_slot' => $tour->max_slot - $detail->quantity
                        ]);
                    }
                }
            }else if($request->transaction_status == "settlement"){
                $trans = Transaction::where('trx_id', $request->order_id)->first();
                if ($trans) {
                    $trans->update(['status' => 'Paid']);

                    $transaction_details = TransactionDetail::class::where('transaction_id', $request->order_id)->get();

                    foreach ($transaction_details as $detail) {
                        $tour = Tour::find($detail->tour_id);
                        $tour->update([
                            'max_slot' => $tour->max_slot - $detail->quantity
                        ]);
                    }
                }
            }else if($request->transaction_status == "pending"){
                $trans = Transaction::where('trx_id', $request->order_id)->first();
                if ($trans) {
                    $trans->update(['status' => 'Pending']);
                }
            }else if($request->transaction_status == "deny"){
                $trans = Transaction::where('trx_id', $request->order_id)->first();
                if ($trans) {
                    $trans->update(['status' => 'Failed']);
                }
            }else if($request->transaction_status == "expire"){
                $trans = Transaction::where('trx_id', $request->order_id)->first();
                if ($trans) {
                    $trans->update(['status' => 'Expired']);
                }
            }else if($request->transaction_status == "cancel"){
                $trans = Transaction::where('trx_id', $request->order_id)->first();
                if ($trans) {
                    $trans->update(['status' => 'Failed']);
                }
            }else if($request->transaction_status == "refund"){
                $trans = Transaction::where('trx_id', $request->order_id)->first();
                if ($trans) {
                    $trans->update(['status' => 'Refund']);
                }
            }else if($request->transaction_status == "partial_refund"){
                $trans = Transaction::where('trx_id', $request->order_id)->first();
                if ($trans) {
                    $trans->update(['status' => 'Partial Refund']);
                }
            }else if($request->transaction_status == "authorize"){
                $trans = Transaction::where('trx_id', $request->order_id)->first();
                if ($trans) {
                    $trans->update(['status' => 'Authorized']);
                }
            }else if($request->transaction_status == "partial_capture"){
                $trans = Transaction::where('trx_id', $request->order_id)->first();
                if ($trans) {
                    $trans->update(['status' => 'Partial Capture']);
                }
            }
        }
    }
}
