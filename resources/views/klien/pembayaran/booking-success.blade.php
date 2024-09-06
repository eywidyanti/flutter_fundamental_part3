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
                        @php
                            $dp = $firstItem->booking->total * 0.3;
                        @endphp
                        <p>Dp: {{ formatRupiah($dp) }}</p>
                    </div>
                @else
                    <div class="total">
                        <p>Total: {{ formatRupiah($total) }}</p>
                        @php
                            $dp = $total * 0.3;
                        @endphp
                        <p>Dp: {{ formatRupiah($dp) }}</p>
                    </div>
                @endif

                @if (\Carbon\Carbon::now()->greaterThan(\Carbon\Carbon::parse($bookingDetails->first()->booking->expired)))
                    <p class="text-danger"><strong>Pembayaran telah melewati batas waktu.</strong></p>
                    @php
                        // Update status to 'expired'
                        $bookingDetails->first()->booking->status = 'expired';
                        $bookingDetails->first()->booking->save();
                    @endphp
                @else
                    @if ($bookingDetails->first()->booking->kekurangan != 0)
                        @if ($bookingDetails->first()->booking->dp == 0)
                            <div class="input_group">
                                <div class="input_box">
                                    <form action="{{ route('process.dp') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="booking_id" value="{{ $bookingId }}">
                                        <button type="submit">Dp</button>
                                    </form>
                                </div>
                            </div>
                        @endif
                        <div class="input_group">
                            <div class="input_box">
                                <form action="{{ route('process.payment') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="booking_id" value="{{ $bookingId }}">
                                    <button type="submit">Bayar Total</button>
                                </form>
                            </div>
                        </div>
                    @endif
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
