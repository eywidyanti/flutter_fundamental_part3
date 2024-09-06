<?php

namespace App\Jobs;

use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CheckBookingExpired implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $now = Carbon::now();

        // Temukan semua pemesanan yang belum dibayar dan telah melewati batas waktu pembayaran
        $bookings = Booking::where('payment_status', 'Unpaid')
                           ->where('expired', '<', $now)
                           ->get();

        foreach ($bookings as $booking) {
            // Ubah status pemesanan menjadi Expired
            $booking->status = 'Expired';
            $booking->save();
        }
    }
}
