<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Galeri</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/css/galeri.css">

</head>

<body>
    <div class="container">
        @if ($errors->any())
            <div class="notifikasi error ">
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        <div class="title">Edit Paket </div>
        <div class="content">
            <form action="{{ route('paket.update', $paket->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="produk-detail">
                    <div class="input-box">
                        <span class=details> Nama Paket: </span>
                        <input type="text" name="nama" value="{{ $paket->nama }}"
                            placeholder="Masukkan nama Paket">
                    </div>
                    <div class="input-box">
                        <span class=details> Upload Gambar </span>
                        <input type="file" name="gambar">
                        <img src="/img/admin/gambarpaket/{{ $paket->gambar }}" width="300px">
                    </div>
                    <div class="input-box">
                        <span class=details> Deskripsi </span>
                        <textarea name="deskripsi" placeholder="Masukkan detail Paket/Barang">{{ $paket->deskripsi }}</textarea>
                    </div>
                </div>
                <button class="btn"><i class="fa fa-upload"></i> Simpan</button>
                <a class="btn1" style="text-decoration:none ;" href="{{ route('paket.index') }}"><i
                        class="fa fa-ban"></i> Batal</a>
            </form>
        </div>
    </div>
</body>

</html>
