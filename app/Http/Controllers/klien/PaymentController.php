<?php

namespace App\Http\Controllers\klien;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingDetail;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{


    public function processPayment(Request $request)
    {
        $booking = Booking::findOrFail($request->booking_id);

        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;

        $params = array(
            'transaction_details' => array(
                'order_id' => $booking->id . '#lunas',
                'gross_amount' => $booking->kekurangan,
            ),
            'customer_details' => array(
                'first_name' => $booking->nama,
                'phone' => $booking->noHp,
            ),
        );

        $snapToken = \Midtrans\Snap::getSnapToken($params);
        return view('klien.payment.payment', compact('snapToken', 'booking'));
    }

    public function processPaymentDp(Request $request)
    {
        $booking = Booking::findOrFail($request->booking_id);

        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;

        $params = array(
            'transaction_details' => array(
                'order_id' => $booking->id . '#dp',
                'gross_amount' => $booking->total * 0.3,
            ),
            'customer_details' => array(
                'first_name' => $booking->nama,
                'phone' => $booking->noHp,
            ),
        );

        $snapToken = \Midtrans\Snap::getSnapToken($params);
        return view('klien.payment.paymentDp', compact('snapToken', 'booking'));
    }

    public function callback(Request $request)
    {
        try {
            $serverKey = config('midtrans.server_key');
            Log::info('Server Key: ' . $serverKey);

            // Hash generation
            $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

            // Log received request data
            Log::info('Received request', $request->all());

            // Log individual components
            Log::info('Order ID: ' . $request->order_id);
            Log::info('Status Code: ' . $request->status_code);
            Log::info('Gross Amount: ' . $request->gross_amount);
            Log::info('Generated Hash: ' . $hashed);
            Log::info('Signature Key from Request: ' . $request->signature_key);

            // Verify signature key
            if ($hashed == $request->signature_key) {
                Log::info('Hash matches');

                if ($request->transaction_status == 'settlement') {
                    Log::info('Transaction status is settlement');

                    $idBooking = explode('#', $request->order_id);
                    $booking = Booking::find($idBooking[0]);

                    if (!$booking) {
                        Log::info('Booking not found for order_id: ' . $request->order_id);
                    } else {
                        Log::info('Booking found: ' . $booking);

                        if ($request->gross_amount != $booking->total) {
                            if ($booking->dp == 0) {
                                $booking->dp = $request->gross_amount;
                                $booking->kekurangan = $booking->total - $request->gross_amount;
                            } else {
                                $booking->kekurangan = 0;
                                $booking->payment_status = 'Paid';
                            }
                        } else {
                            // Update booking status
                            $booking->payment_status = 'Paid';
                        }

                        $booking->tgl_bayar = now();

                        if ($booking->save()) {
                            Log::info('Booking status updated to Paid');
                        } else {
                            Log::error('Failed to update booking status');
                        }
                    }
                } else {
                    Log::info('Transaction status is not capture: ' . $request->transaction_status);
                }
            } else {
                Log::info('Hash does not match');
            }
        } catch (\Exception $e) {
            Log::error('Callback error: ' . $e->getMessage());
        }
    }

    public function paymentStatus($id)
    {
        $status = Booking::find($id);
        $cartItems = Cart::all();
        return view('klien.payment.paymentStatus', compact('status', 'cartItems'));
    }

    public function showPayment(Request $request)
    {
        $user = Auth::user();

        $paidBookingDetails = BookingDetail::with(['dekor', 'booking'])
            ->whereHas('booking', function ($query) use ($user) {
                $query->where('payment_status', 'paid')
                    ->where('status', 'Pending')
                    ->where('user_id', $user->id)
                    ->orWhere(function ($query) {
                        $query->where('dp', '!=', 0)
                            ->where('status', 'Pending');
                    });
            })
            ->get();
        // Group booking details berdasarkan booking_id
        $groupedBookingDetails = $paidBookingDetails->groupBy('booking_id');
        $cartItems = Cart::all();

        return view('klien.penyewaan.payment-success', compact('groupedBookingDetails', 'cartItems'));
    }

    public function cancel(Request $request)
    {
        $bookingId = $request->input('id');
        $booking = Booking::find($bookingId);

        $booking->status = 'Cancel';
        $booking->save();

        return redirect()->back();
    }

    public function detailPemesan(Request $request)
    {
        $bookingId = $request->input('booking_id');
        $booking = Booking::find($bookingId);


        return view('klien.payment.detailSewa', compact('booking'));
    }

    
}
