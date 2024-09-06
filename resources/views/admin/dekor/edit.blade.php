<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit</title>
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


        <div class="title">Edit Dekorasi</div>
        <div class="content">
            <form action="{{ route('dekor.update', $dekor->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="produk-detail">
                    <div class="input-box">
                        <span class=details> Nama Dekorasi: </span>
                        <input type="text" name="nama" value="{{ $dekor->nama }}"
                            placeholder="Masukkan Nama Dekorasi">
                    </div>
                    <div class="input-box">
                        <span class=details> Harga </span>
                        <input type="text" name="harga" value="{{ $dekor->harga }}" placeholder="Masukkan Harga">
                    </div>
                    <div class="input-box">
                        <span class=details> Deskripsi </span>
                        <textarea name="deskripsi" placeholder="Masukkan detail Paket/Barang">{{ $dekor->deskripsi }}</textarea>
                    </div>
                    <div class="input-box">
                        <span class=details> Upload Gambar </span>
                        <input type="file" name="gambar">
                        <img src="/img/admin/gambarDekor/{{ $dekor->gambar }}" width="300px">
                    </div>
                </div>
                <button class="btn"><i class="fa fa-upload"></i> Simpan</button>
                <a class="btn1" style="text-decoration:none ;" href="{{ route('dekor.index') }}"><i
                        class="fa fa-ban"></i> Batal</a>
            </form>
        </div>
    </div>
</body>

</html>
