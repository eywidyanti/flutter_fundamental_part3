<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/css/galeri.css">

</head>

<body>
    <div class="container">


        <div class="title">Detail Dekorasi</div>
        <div class="content">
            <form>
                <div class="produk-detail">
                    <div class="input-box">
                        <strong>Nama User:</strong>
                        {{ $dekor->user->name }}
                    </div>
                    <div class="input-box">
                        <strong>Nama:</strong>
                        {{ $dekor->nama }}
                    </div>
                    <div class="input-box">
                        <strong> Deskripsi:</strong>
                        {{ $dekor->deskripsi }}
                    </div>
                    <div class="input-box">
                        <strong>Gambar:</strong>
                        <img src="/img/admin/gambarDekor/{{ $dekor->gambar }}" width="300px">
                    </div>
                </div>
                <a class="btn1" style="text-decoration:none ;" href="{{ route('dekor.index') }}"><i
                        class="fa fa-ban"></i> Batal</a>
            </form>
        </div>
    </div>
</body>

</html>
