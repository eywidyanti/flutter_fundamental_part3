<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingDetail;
use App\Models\Cart;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PembayaranController extends Controller
{
    public function pending(Request $request)
    {
        $groupedBookingDetails = BookingDetail::with(['dekor', 'paket', 'booking'])
            ->whereHas('booking', function ($query) {
                $query->where('status', 'Pending');
            })
            ->get()
            ->groupBy('booking_id');

        // Urutkan booking details berdasarkan tanggal booking
        $sortedBookingDetails = $groupedBookingDetails->sortBy(function ($details, $key) {
            return $details->first()->booking->tanggal_mulai_penggunaan; // Pastikan 'tanggal' adalah nama kolom yang benar
        });

        $user = Auth::user();
        $cartItems = Cart::where('user_id', $user->id)->get();

        return view('admin.payment.pending', compact('sortedBookingDetails', 'cartItems'));
    }


    public function kirim(Request $request)
    {
        $groupedBookingDetails = BookingDetail::with(['dekor', 'paket', 'booking'])
            ->whereHas('booking', function ($query) {
                $query->where('status', 'kirim');
            })
            ->get()
            ->groupBy('booking_id');

        $user = Auth::user();
        $cartItems = Cart::where('user_id', $user->id)->get();

        return view('admin.payment.kirim', compact('groupedBookingDetails', 'cartItems'));
    }

    public function selesai(Request $request)
    {
        $groupedBookingDetails = BookingDetail::with(['dekor', 'paket', 'booking'])
            ->whereHas('booking', function ($query) {
                $query->where('status', 'selesai');
            })
            ->get()
            ->groupBy('booking_id');

        $user = Auth::user();
        $cartItems = Cart::where('user_id', $user->id)->get();

        return view('admin.payment.selesai', compact('groupedBookingDetails', 'cartItems'));
    }

    public function cancel(Request $request)
    {
        $groupedBookingDetails = BookingDetail::with(['dekor', 'paket', 'booking'])
            ->whereHas('booking', function ($query) {
                $query->where('status', 'cancel');
            })
            ->get()
            ->groupBy('booking_id');

        $user = Auth::user();
        $cartItems = Cart::where('user_id', $user->id)->get();

        return view('admin.payment.cancel', compact('groupedBookingDetails', 'cartItems'));
    }

    public function processKirim(Request $request)
    {

        $user = Auth::user();
        $booking = Booking::findOrFail($request->booking_id);

        $booking->status = 'Kirim';
        $booking->save();

        return redirect()->back();
    }

    public function processSelesai(Request $request)
    {
        $user = Auth::user();
        $booking = Booking::findOrFail($request->booking_id);

        $booking->status = 'Selesai';
        $booking->save();

        return redirect()->back();
    }

    public function detailPemesan(Request $request)
    {
        $bookingId = $request->input('booking_id');
        $booking = Booking::find($bookingId);


        return view('admin.payment.detailBooking', compact('booking'));
    }



    public function laporan(Request $request)
    {
        $dateFrom = $request->input('date_from');
        $dateTo = $request->input('date_to');

        $query = BookingDetail::with(['dekor', 'paket', 'booking']);

        if ($dateFrom && $dateTo) {
            $query->whereHas('booking', function ($q) use ($dateFrom, $dateTo) {
                $q->whereDate('tanggal_mulai_penggunaan', '>=', $dateFrom)
                    ->whereDate('tanggal_mulai_penggunaan', '<=', $dateTo)
                    ->where('status', '!=', 'expired');
            });
        } else {
            $query->whereHas('booking', function ($q) {
                $q->where('status', '!=', 'expired'); 
            });
        }

        $group = $query->get()->groupBy('booking_id');

        $groupBooking = $group->sortBy(function ($details, $key) {
            return $details->first()->booking->tanggal_mulai_penggunaan;
        });

        $booking = Booking::all();

        return view('admin.payment.laporan', compact('booking', 'groupBooking'));
    }



    public function cetak(Request $request)
    {
        $dateFrom = $request->input('date_from');
        $dateTo = $request->input('date_to');

        $query = BookingDetail::with(['dekor', 'paket', 'booking']);

        if ($dateFrom && $dateTo) {
            $query->whereHas('booking', function ($q) use ($dateFrom, $dateTo) {
                $q->whereDate('tanggal_mulai_penggunaan', '>=', $dateFrom)
                    ->whereDate('tanggal_mulai_penggunaan', '<=', $dateTo)
                    ->where('status', '!=', 'expired');
            });
        } else {
            $query->whereHas('booking', function ($q) {
                $q->where('status', '!=', 'expired');
            });
        }

        $group = $query->get()->groupBy('booking_id');

        $sortedGroupBooking = $group->sortBy(function ($details, $key) {
            return $details->first()->booking->tanggal_mulai_penggunaan;
        });

        $totalPendapatan = $sortedGroupBooking->sum(function ($bookingDetails) {
            $firstDetail = $bookingDetails->first();
            if($firstDetail->booking->dp!=0 && $firstDetail->booking->kekurangan==0) {
                return $firstDetail->booking->total;
            } elseif($firstDetail->booking->dp==0 && $firstDetail->booking->kekurangan!=0) {
                return $firstDetail->booking->total;
            }else{
                return $firstDetail->booking->dp;
            }
        });

        $pdf = PDF::loadView('admin.payment.cetak', compact('sortedGroupBooking', 'dateFrom', 'dateTo', 'totalPendapatan'));

        return $pdf->download('laporan.pdf');
    }
}
