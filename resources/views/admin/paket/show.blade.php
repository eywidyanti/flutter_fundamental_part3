<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Paket</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/css/galeri.css">
    <style>
        /* Tambahkan CSS di sini jika diperlukan */
    </style>
</head>

<body>
    <div class="container">
        <div class="title">Detail Paket</div>
        <div class="content">
            <form>
                <div class="produk-detail">
                    <div class="input-box">
                        <strong>Nama Paket:</strong>
                        <span>{{ $paket->nama }}</span>
                    </div>
                    <div class="input-box">
                        <strong>Harga Paket:</strong>
                        <span>{{ formatRupiah($paket->harga) }}</span>
                    </div>
                    <div class="input-box">
                        <strong>Deskripsi:</strong>
                        <span>{{ $paket->deskripsi }}</span>
                    </div>
                    @if (!empty($paket->gambar))
                        <div class="input-box">
                            <strong>Gambar:</strong>
                            <img src="/img/admin/gambarpaket/{{ $paket->gambar }}" width="150px">
                        </div>
                    @else
                        <div class="input-box">
                            <strong>Gambar:</strong>
                            <img src="/img/admin/images.png" width="150px">
                        </div>
                    @endif
                </div>

                <h2>Daftar Dekorasi</h2>

                <table class="table">
                    <thead>
                        <tr>
                            <th>Nama Dekorasi</th>
                            <th>Gambar</th>
                            <th>Deskripsi</th>
                            <th>Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($paketDekors as $paketDekor)
                            <tr>
                                <td>{{ $paketDekor->dekor->nama }}</td>
                                <td><img src="/img/admin/gambarDekor/{{ $paketDekor->dekor->gambar }}" width="50px"></td>
                                <td>{{ $paketDekor->dekor->deskripsi }}</td>
                                <td>{{ formatRupiah($paketDekor->dekor->harga) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                
                <a class="btn1" style="text-decoration:none;" href="{{ route('paket.index') }}">
                    <i class="fa fa-ban"></i> Batal
                </a>
            </form>
        </div>
    </div>
</body>

</html>
