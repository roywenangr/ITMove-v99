<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\Auth;

class PaymentHistoryController extends Controller
{
    public function index()
    {
        if (Auth::user()->is_admin == true) {
            // Admin dapat mengakses semua data
            $history = Transaction::paginate(5);
        } else {
            // Pengguna non-admin hanya dapat mengakses data sesuai dengan user_id mereka
            $history = Transaction::where('user_id', Auth::user()->id)->paginate(5);
        }

        $trans_detail = TransactionDetail::all();

        return view('paymentHistory', compact('history','trans_detail'));
    }
}
