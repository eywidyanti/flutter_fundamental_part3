@extends('klien.layout')

@section('content')
    <!-- galeri start -->
    <section id="produk" class="produk">
        <h2>Dekor<span> Dekorasi</span></h2>

        <div class="row">
            @foreach ($dekorsFromPaketDekor as $dekor)
                <div class="produk-card">
                    <div class="produk-icons">
                        <a href=""><i data-feather="shopping-cart"></i></a>
                    </div>
                    <div class="produk-image">
                        <img src="/img/admin/gambarDekor/{{ $dekor->gambar }}" alt="Produk 1">
                    </div>
                    <div class="produk-content">
                        <h3>{{ $dekor->nama }}</h3>
                        <div class="produk-price"> {{ formatRupiah($dekor->harga) }}</div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- icons -->
@endsection
