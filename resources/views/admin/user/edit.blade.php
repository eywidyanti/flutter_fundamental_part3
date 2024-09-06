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
    @if ($errors->any())
    <div class="notifikasi error ">
    <strong>Ooops!</strong> ada masalah saat pengisian data.<br><br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif


        <div class="title">Edit Pengguna</div>
        <div class="content">
            <form action="{{ route('user.update',$user->id) }}" method="POST" enctype="multipart/form-data" >
                @csrf
                @method('PUT')

                <div class="produk-detail">
                    <div class="input-box">
                        <span class=details> Nama: </span>
                        <input type="text" name="name" value="{{ $user->name }}"placeholder="Masukkan nama Pengguna">
                    </div>
                    <div class="input-box">
                        <span class=details> Email: </span>
                        <input type="text" name="email" value="{{ $user->email }}"placeholder="Masukkan Email">
                    </div>
                    <div class="input-box">
                    <span class=details> Jenis Kelamin: </span>
                        <select name="jenis_kelamin" >
                            <option value="" disabled selected>Pilih Gender</option>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                    <div class="input-box">
                        <span class=details> No Telp: </span>
                        <input type="text" name="noHp" value="{{ $user->noHp }}" placeholder="Masukkan no Telp">
                    </div>
                    <div class="input-box">
                        <span class=details> Upload Gambar </span>
                        <input type="file" name="gambar">
                        <img src="/img/admin/fotoUser/{{ $user->gambar }}" width="300px">
                    </div>
                </div>
                <button class="btn"><i class="fa fa-upload"></i> Simpan</button>
                <a class="btn1" style="text-decoration:none ;" href="{{ route('user.index') }}"><i class="fa fa-ban"></i> Batal</a>
            </form>
        </div>
    </div>
</body>
</html>
