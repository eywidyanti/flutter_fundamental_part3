<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wedding Org</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,300;0,400;0,700;1,700&display=swap"
        rel="stylesheet">

    <!-- icons -->
    <script src="https://unpkg.com/feather-icons"></script>

    <!-- style -->
    <link rel="stylesheet" href="/css/style.css">

    <!-- Alpine JS -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- midtrans -->
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="SB-Mid-client-d9lenCMr2S90uRk-"></script>
</head>
<body>
    <!-- Navbar started -->
    <nav class="navbar" x-data>
        <a href="#" class="navbar-logo"> Littlemee<span>Deco</span>.</a>

        <div class="navbar-nav">
            <a href="#home">Home</a>
            <a href="#paket">Paket</a>
            <a href="#produk">Dekor</a>
            <a href="#galeri">Galeri</a>
        </div>

        <div class="navbar-extra">
            <a href="{{ route('login') }}" id="users"><i data-feather="users"></i></a>
            <a id="furniture-menu"><i data-feather="menu"></i></a>
        </div>

    </nav>
    <!-- Navbar end -->

    <!-- galeri start -->
    <section id="produk" class="produk">
        <h2>Dekor<span> Dekorasi</span></h2>

        <div class="row">
            @foreach ($dekorsFromPaketDekor as $dekor)
                <div class="produk-card">
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
    <script>
        feather.replace();
    </script>
    </body>

</html>
