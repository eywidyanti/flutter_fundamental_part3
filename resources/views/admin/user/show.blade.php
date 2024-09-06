<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form User</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/css/galeri.css">
    
</head>
<body>
    <div class="container">


        <div class="title">Detail Pengguna</div>
        <div class="content">
            <form>
            <div class="produk-detail">
                    <div class="input-box">
                        <strong>Nama :</strong>
                        {{ $user->name }}
                    </div>
                    <div class="input-box">
                        <strong>Email:</strong>
                        {{ $user->email }}
                    </div>
                    <div class="input-box">
                        <strong>Jenis Kelamin:</strong>
                        {{ $user->jenis_kelamin }}
                    </div>
                    <div class="input-box">
                        <strong> No Telp:</strong>
                        {{ $user->noHp }}
                    </div>
                    <div class="input-box">
                        <strong>Gambar:</strong>
                        <img src="/img/admin/fotoUser/{{ $user->gambar }}" width="300px">
                    </div>
                </div>
                <a class="btn1" style="text-decoration:none ;" href="{{ route('galeri.index') }}"><i class="fa fa-ban"></i> Batal</a>
            </form>
        </div>
    </div>
</body>
</html>
