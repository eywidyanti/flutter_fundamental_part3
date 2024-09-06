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

        <div class="title">Detail Galeri</div>
        <div class="content">
            <form>
                <div class="produk-detail">
                    <div class="input-box">
                        <strong>Gambar:</strong>
                        <img src="/img/admin/gambarGaleri/{{ $galeri->gambar }}" width="300px">
                    </div>
                    <div class="input-box">
                        <strong>Gambar:</strong>
                        <img src="/img/admin/gambarGaleri/{{ $galeri->gambar1 }}" width="300px">
                    </div>
                    <div class="input-box">
                        <strong>Gambar:</strong>
                        <img src="/img/admin/gambarGaleri/{{ $galeri->gambar2 }}" width="300px">
                    </div>
                    <div class="input-box">
                        <strong>Video:</strong>
                        <video width="300" height="180" controls>
                            <source src="/img/admin/videoGaleri/{{ $galeri->video }}" type="video/mp4">
                        </video>
                    </div>
                    <div class="input-box">
                        <strong> Deskripsi:</strong>
                        {{ $galeri->deskripsi }}
                    </div>
                    <div class="input-box">
                        <strong>Nama User:</strong>
                        {{ $galeri->user->name }}
                    </div>
                </div>
                <a class="btn1" style="text-decoration:none ;" href="{{ route('galeri.index') }}"><i
                        class="fa fa-ban"></i> Batal</a>
            </form>
        </div>
    </div>
</body>

</html>
