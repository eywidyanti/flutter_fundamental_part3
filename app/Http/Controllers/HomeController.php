<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Cart;
use App\Models\Dekor;
use App\Models\Galeri;
use App\Models\Paket;
use App\Models\PaketDekor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */


    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $user = Auth::user();

        $pakets = Paket::all();
        $dekors = Dekor::all();
        $galeris = Galeri::all();
        $cartItems = Cart::where('user_id', $user->id)->get();
        $booking = Booking::all();

        $paketDekors = PaketDekor::with('dekor')->get();
        $dekorsFromPaketDekor = $paketDekors->pluck('dekor');

        return view('klien.tampilan', compact('dekors', 'pakets', 'cartItems', 'galeris', 'dekorsFromPaketDekor'));
    }

    public function detail($slug)
    {
        $paket = Paket::where('slug', $slug)->firstOrFail();
        $paketDekors = PaketDekor::with('dekor')->where('paket_id', $paket->id)->get();
        $dekorsFromPaketDekor = $paketDekors->pluck('dekor');
        $cartItems = Cart::all();
        return view('klien.detail', compact('dekorsFromPaketDekor', 'cartItems'));
    }


    public function adminHome()
    {
        return view('admin.admin');
    }
}
