@extends('klien.layout1')

@section('content')
    @include('klien.pembayaran.main-layout')
    <div class="main-container">

        @foreach ($groupedBookingDetails as $bookingId => $bookingDetails)
            @php $total = 0 @endphp

            <div class="main">
                <h2>Konfirmasi Pembayaran</h2>
                <hr>

                @if ($bookingDetails->first()->paket_id)
                    @php $firstItem = $bookingDetails->first() @endphp

                    @php $total += $firstItem->harga * $firstItem->quantity @endphp

                    <div class="product-card">
                        <div class="produk-card">
                            <img src="/img/admin/gambarpaket/{{ $firstItem->paket->gambar }}" class="produk-image">
                            <p class="produk-title">{{ $firstItem->paket->nama }}</p>
                            <p>{{ formatRupiah($firstItem->booking->total) }}</p>
                            <p>x{{ $firstItem->quantity }}</p>
                        </div>
                    </div>
                @else
                    @foreach ($bookingDetails as $index => $item)
                        @php $total += $item->harga * $item->quantity @endphp

                        <div class="product-card">
                            <div class="produk-card">
                                <img src="/img/admin/gambarDekor/{{ $item->dekor->gambar }}" class="produk-image">
                                <p class="produk-title">{{ $item->dekor->nama }}</p>
                                <p>{{ formatRupiah($item->harga) }}</p>
                                <p>x{{ $item->quantity }}</p>
                            </div>
                        </div>
                    @endforeach
                @endif

                <hr>
                <p><strong>Batas Pembayaran:
                        {{ \Carbon\Carbon::parse($bookingDetails->first()->booking->expired)->format('d M Y, H:i') }}</strong>
                </p>

                @if ($bookingDetails->first()->paket_id)
                    <div class="total">
                        <p>Total: {{ formatRupiah($firstItem->booking->total) }}</p>
                    </div>
                @else
                    <div class="total">
                        <p>Total: {{ formatRupiah($total) }}</p>
                    </div>
                @endif

                @if (\Carbon\Carbon::now()->greaterThan(\Carbon\Carbon::parse($bookingDetails->first()->booking->expired)))
                    <p class="text-danger"><strong>Pembayaran telah melewati batas waktu.</strong></p>
                    @php
                        // Update status to 'expired'
                        $bookingDetails->first()->booking->status = 'Expired';
                        $bookingDetails->first()->booking->save();
                    @endphp
                @endif

                <hr>
                <form action="{{ route('detail.sewa') }}" method="POST" style="margin: 0px;">
                    @csrf
                    <input type="hidden" name="booking_id" value="{{ $bookingId }}">
                    <button type="submit" style="border:none; margin-top: 0px; height: 40px; width:100%;">Detail
                        Penyewa</button>
                </form>
            </div>
        @endforeach

    </div>
@endsection
