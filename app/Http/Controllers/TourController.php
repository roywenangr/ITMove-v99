<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Tour;
use App\Models\Category;
use App\Models\Province;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TourController extends Controller
{
    public function index()
    {
        $query = Tour::query();

        // Jika user adalah admin, tampilkan semua data, jika bukan, filter hanya yang is_public
        if (Auth::user() && Auth::user()->is_admin == false) {
            $query->where('is_public', 1);
        }

        // Terapkan pagination
        $tours = $query->paginate(8);

        $province = Province::all();
        $category = Category::all();
        $selectedProv = "all";
        $selectedProvince = null;
        $selectedCategory = null;
        $selectedCat = 'all';
        $disabled = null;
        $selectedSort = null;
        $tourPlaces = Tour::join('tour_places', 'tours.id', '=', 'tour_places.tour_id')->get();

        $stock = null;
        foreach ($tours as $t) {
            $sold = Transaction::where('status', 'Paid')
                ->join('transaction_details', 'transactions.id', 'transaction_details.transaction_id')
                ->where('transaction_details.tour_id', $t->id)
                ->sum('transaction_details.quantity');

            $stock[] = $t->max_slot - $sold;
        }


        return view('tour', compact('tours', 'province', 'category', 'selectedProv', 'selectedCat', 'selectedProvince', 'disabled', 'selectedCategory', 'selectedSort', 'tourPlaces', 'stock'));
    }

    public function detail($id)
    {
        $tour = Tour::find($id);
        $sold = Transaction::where('status', 'Paid')
            ->join('transaction_details', 'transactions.id', 'transaction_details.transaction_id')
            ->where('transaction_details.tour_id', $id)
            ->sum('transaction_details.quantity');

        $cart = 0;

        if (Auth::user()) {
            $cart = Cart::where('user_id', Auth::user()->id)->where('tour_id', $id)->count();
        }

        if ($cart > 0)
            $disabled = "disabled";
        else
            $disabled = "";

        $stock = $tour->max_slot - $sold;

        return view('tourDetail', compact('tour', 'stock', 'disabled'));
    }


    public function filter(Request $request)
    {
        $selectedCategory = null;
        $selectedProvince = $request->province;
        $selectedCategory = $request->category;
        $disabled = null;
        $province = Province::all();
        $category = Category::all();
        $query = Tour::query();

        // Jika user adalah admin, tampilkan semua data, jika bukan, filter hanya yang is_public
        if (Auth::user() && Auth::user()->is_admin == false) {
            $query->where('is_public', 1);
        }

        // Terapkan pagination
        $tours = $query->paginate(8);
        $selectedSort = $request->sort;
        $tourPlaces = null;


        if ($selectedProvince != "all" && $selectedCategory != "all") {
            // Initial query with joins and where conditions
            $query = Tour::join('tour_categories', 'tours.id', '=', 'tour_categories.tour_id')
                ->where('category_id', $selectedCategory)
                ->where('province_id', $selectedProvince);

            // Filter for non-admin users
            if (Auth::user() && !Auth::user()->is_admin) {
                $query = $query->where('is_public', '1');
            }

            // Pagination
            $tours = $query->paginate(8);

            // Getting related tour places
            $tourPlaces = Tour::join('tour_places', 'tours.id', '=', 'tour_places.tour_id')
                ->join('places', 'places.id', '=', 'tour_places.place_id')
                ->where('tours.province_id', $selectedProvince)
                ->get();
        } else if ($selectedProvince != 'all') {
            $query = Tour::where('province_id', '=', $selectedProvince);
            if (Auth::user() && Auth::user()->is_admin == false) {
                $query = $query->where('is_public', '1');
            }
            $tours = $query->paginate(8);

        } else if ($selectedCategory != 'all') {
            // Mulai query dengan filter kategori
            $tourQuery = Tour::join('tour_categories', 'tours.id', '=', 'tour_categories.tour_id')
                ->where('category_id', '=', $selectedCategory);

            // Cek user dan role
            if (Auth::user() && Auth::user()->is_admin == false) {
                $tourQuery = $tourQuery->where('is_public', '1');
            }

            // Implementasi pagination pada query
            $tours = $tourQuery->paginate(8);

            // Jika Anda ingin mendapatkan tourPlaces, pastikan ini tidak mengganggu logika pagination
            // Anda mungkin perlu memisahkan query ini atau menyesuaikannya sesuai kebutuhan
            $tourPlaces = Tour::join('tour_places', 'tours.id', '=', 'tour_places.tour_id')
                ->join('places', 'places.id', '=', 'tour_places.place_id')
                ->get();
        }

        if ($selectedSort == "asc") {
            $tour = $tours->sortBy('tour_title');
        } else if ($selectedSort == "desc") {
            $tour = $tours->sortByDesc('tour_title');
        } else if ($selectedSort == "min") {
            $tour = $tours->sortBy('price');
        } else if ($selectedSort == "max") {
            $tour = $tours->sortByDesc('price');
        }

        //dd($tour);

        $stock = null;

        foreach ($tours as $t) {
            $sold = Transaction::where('status', 'Paid')
                ->join('transaction_details', 'transactions.id', 'transaction_details.transaction_id')
                ->where('transaction_details.tour_id', $t->id)
                ->sum('transaction_details.quantity');

            $stock[] = $t->max_slot - $sold;
        }

        return view('tour', compact('tours', 'selectedProvince', 'selectedCategory', 'disabled', 'province', 'category', 'selectedSort', 'tourPlaces', 'stock'));
    }


}
