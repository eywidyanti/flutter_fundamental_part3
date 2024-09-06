@extends('admin.layout1')

@section('content')
    <!-- resources/views/admin/menu.blade.php -->
    @include('admin.main-layout')

    <div class="main-container">


        @foreach ($groupedBookingDetails as $bookingId => $bookingDetails)
            @php $total = 0 @endphp

            <div class="main">
                <h2>Proses Penyewaan</h2>

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
                @if ($bookingDetails->first()->paket_id)
                    
                    @if($firstItem->booking->dp!=0)
                    <div class="total">
                        <p>Dp: {{ formatRupiah($firstItem->booking->dp) }}</p>
                    </div>
                    <div class="total">
                        <p>Kurang: {{ formatRupiah($firstItem->booking->kekurangan) }}</p>
                    </div>
                    @endif
                    <div class="total">
                        <p>Total: {{ formatRupiah($firstItem->booking->total) }}</p>
                    </div>
                @else
                    <div class="total">
                        <p>Total: {{ formatRupiah($total) }}</p>
                    </div>
                @endif

                @if ($bookingDetails->first()->booking->status == 'Cancel')
                    <div class="input_group">
                        <div class="input_box">
                            <button style="text-decoration:none ; background-color:red;">Batal</button>
                        </div>
                    </div>
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
    </div>
@endsection
