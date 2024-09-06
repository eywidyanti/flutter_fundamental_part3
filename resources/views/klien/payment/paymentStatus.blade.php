@extends('klien.layout1')

@section('content')
    @include('klien.payment.main-layout')
    <div class="main-container">
        <div class="main">
            <h2>{{ $status->nama }} pembayaran anda berhasil</h2>
            <hr>
            <div class="product-card">
                <p class="product-title"></p>
            </div>
            <div class="produk-card" onclick="goToPage()">
                @if($status->dp == !0 && $status->kekurangan == !0)
                <p>Dp: {{ formatRupiah($status->dp) }}</p>
                <p>Kurang: {{ formatRupiah($status->kekurangan) }}</p>
                @else
                <p>Harga: {{ formatRupiah($status->total) }}</p>
                @endif
            </div>
            <div class="input_group">
                <div class="input_box">
                    <a href="{{ route('payment') }}"><button style="text-decoration:none ; background-color:blue;">Ok</button></a>
                </div>
            </div>
            
            <hr>
        </div>
    </div>
@endsection
