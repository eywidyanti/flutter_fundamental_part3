<?php

namespace App\Http\Controllers\klien;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingDetail;
use App\Models\Cart;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    public function checkout(Request $request)
    {
        $user = Auth::user();
        $cartItems = Cart::where('user_id', $user->id)->get();
        return view('klien.checkout', compact('cartItems'));
    }

    public function processCheckout(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'alamat' => 'required|string|max:255',
            'noHp' => 'required|string|max:20',
            'nama_pengantin' => 'required|string|max:255',
            'tanggal_mulai_penggunaan' => 'required|date|after_or_equal:today',
            'jam_mulai_penggunaan' => 'required|string|max:255',
            'jam_berakhir_penggunaan' => 'required|string|max:255',
            'keterangan' => 'required|string|max:255',
        ], [
            'tanggal_mulai_penggunaan.after_or_equal' => 'Tanggal mulai penggunaan tidak boleh kurang dari hari ini.',
        ]);

        $user = Auth::user();
        $cartItems = Cart::where('user_id', $user->id)->with('dekor')->get();

        // cek pesanan (tanggal dan dekor sama)
        foreach ($cartItems as $item) {
            $existingBooking = Booking::whereHas('bookingDetails', function ($query) use ($item) {
                $query->where('dekor_id', $item->dekor_id);
            })->where(function ($query) use ($validatedData) {
                $query->where('tanggal_mulai_penggunaan', $validatedData['tanggal_mulai_penggunaan'])
                    ->where('status', 'Pending');
            })->first();

            if ($existingBooking) {
                return redirect()->back()->withErrors(['error' => 'Maaf, Booking dekor pada tanggal ' . $existingBooking->tanggal_mulai_penggunaan . ' sudah di booking.']);
            }
        }

        //expired 24jam
        $expired = Carbon::now()->addHours(24);

        $checkout = new Booking();
        $checkout->user_id = $user->id;
        $checkout->slug = Str::random(20);
        $checkout->nama = $validatedData['nama'];
        $checkout->email = $validatedData['email'];
        $checkout->alamat = $validatedData['alamat'];
        $checkout->noHp = $validatedData['noHp'];
        $checkout->tanggal_mulai_penggunaan = $validatedData['tanggal_mulai_penggunaan'];
        $checkout->nama_pengantin = $validatedData['nama_pengantin'];
        $checkout->jam_mulai_penggunaan = $validatedData['jam_mulai_penggunaan'];
        $checkout->jam_berakhir_penggunaan = $validatedData['jam_berakhir_penggunaan'];
        $checkout->keterangan = $validatedData['keterangan'];
        $checkout->status = 'Pending';
        $checkout->payment_status = 'Unpaid';
        $checkout->expired = $expired;
        $checkout->total = $cartItems->sum(function ($item) {
            if ($item->paket_id) {
                return $item->paket->harga;
            } else {
                // Jika tidak ada paket_id
                return $item->dekor->harga * $item->quantity;
            }
        });

        $checkout->kekurangan = $cartItems->sum(function ($item) {
            if ($item->paket_id) {
                return $item->paket->harga;
            } else {
                return $item->dekor->harga * $item->quantity;
            }
        });

        $checkout->save();

        foreach ($cartItems as $item) {
            $BookingItem = new BookingDetail();
            $BookingItem->booking_id = $checkout->id;
            $BookingItem->dekor_id = $item->dekor_id;
            $BookingItem->paket_id = $item->paket_id;
            $BookingItem->user_id = $user->id;
            $BookingItem->slug = Str::random(20);
            $BookingItem->quantity = $item->quantity;
            if($item->paket_id){
                $BookingItem->harga = $item->paket->harga;
            }else{
                $BookingItem->harga = $item->dekor->harga;
            }
            
            $BookingItem->save();

            //Dekor::where('id', $item->dekor_id)->decrement('stok', intval($item->quantity));
            //increment
        }

        // Hapus item dari keranjang
        Cart::where('user_id', $user->id)->delete();

        return redirect()->route('booking.success');
    }


    public function showSuccess(Request $request)
    {
        $user = Auth::user();

        $paidBookingDetails = BookingDetail::with(['paket', 'dekor', 'booking'])
            ->whereHas('booking', function ($query) use ($user) {
                $query->where('payment_status', 'unpaid')
                    ->where('dp', '==', 0)
                    ->where('status', 'Pending')
                    ->where('user_id', $user->id);
            })
            ->get();

        // Group booking details berdasarkan booking_id
        $groupedBookingDetails = $paidBookingDetails->groupBy('booking_id');
        $booking = Booking::all();
        $cartItems = Cart::where('user_id', $user->id)->get();

        return view('klien.pembayaran.booking-success', compact('groupedBookingDetails', 'booking', 'cartItems'));
    }

    public function showExpired(Request $request)
    {
        $user = Auth::user();

        $paidBookingDetails = BookingDetail::with(['paket', 'dekor', 'booking'])
            ->whereHas('booking', function ($query) use ($user) {
                $query->where('status', 'Expired')
                    ->where('user_id', $user->id);
            })
            ->get();

        // Group booking details berdasarkan booking_id
        $groupedBookingDetails = $paidBookingDetails->groupBy('booking_id');
        $booking = Booking::all();
        $cartItems = Cart::where('user_id', $user->id)->get();

        return view('klien.pembayaran.booking-expired', compact('groupedBookingDetails', 'booking', 'cartItems'));
    }

    public function showKirim(Request $request)
    {
        $user = Auth::user();

        $paidBookingDetails = BookingDetail::with(['dekor', 'booking'])
            ->whereHas('booking', function ($query) use ($user) {
                $query->where('status', 'Kirim')
                    ->where('user_id', $user->id);
            })
            ->get();

        $groupedBookingDetails = $paidBookingDetails->groupBy('booking_id');
        $cartItems = Cart::all();

        return view('klien.penyewaan.booking-kirim', compact('groupedBookingDetails', 'cartItems'));
    }


    public function showSelesai(Request $request)
    {
        $user = Auth::user();

        $paidBookingDetails = BookingDetail::with(['dekor', 'booking'])
            ->whereHas('booking', function ($query) use ($user) {
                $query->where('status', 'Selesai')
                    ->where('user_id', $user->id);
            })
            ->get();

        // Group booking details berdasarkan booking_id
        $groupedBookingDetails = $paidBookingDetails->groupBy('booking_id');
        $cartItems = Cart::all();

        return view('klien.penyewaan.booking-selesai', compact('groupedBookingDetails', 'cartItems'));
    }


    public function showCancel(Request $request)
    {

        $user = Auth::user();

        $paidBookingDetails = BookingDetail::with(['dekor', 'booking'])
            ->whereHas('booking', function ($query) use ($user) {
                $query->where('status', 'Cancel')
                    ->where('payment_status', 'paid')
                    ->where('user_id', $user->id);
            })
            ->get();

        // Group booking details berdasarkan booking_id
        $groupedBookingDetails = $paidBookingDetails->groupBy('booking_id');
        $cartItems = Cart::all();

        return view('klien.penyewaan.booking-cancel', compact('groupedBookingDetails', 'cartItems'));
    }
}
