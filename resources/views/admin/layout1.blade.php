<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Wedding Org</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,300;0,400;0,700;1,700&display=swap"
        rel="stylesheet">

    <!-- icons -->
    <script src="https://unpkg.com/feather-icons"></script>

    <!-- style -->
    <link rel="stylesheet" href="/css/pay.css">

    <!-- @TODO: replace SET_YOUR_CLIENT_KEY_HERE with your client key -->
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('midtrans.client_key') }}"></script>

    <!-- Note: replace with src="https://app.midtrans.com/snap/snap.js" for Production environment -->
    <!-- Bootstrap CSS -->
</head>

</head>

<body>
    <!-- Navbar started -->
    <nav class="navbar">
        <a href="#" class="navbar-logo">Littlemee<span>Deco</span>.</a>

        <div class="navbar-nav">
            <a href="{{ route('admin') }}">Home</a>
            <a href="{{ route('dekor.index') }}">Dekorasi</a>
            <a href="{{ route('paket.index') }}">Paket Dekorasi</a>
            <a href="{{ route('galeri.index') }}">Galeri</a>
            <a href="{{ route('user.index') }}">User</a>
            <a href="{{ route('pembayaran.pending') }}">Sewa Paket</a>
            <a href="{{ route('laporan') }}">Laporan Sewa</a>
        </div>

        <div class="navbar-extra">
            <a id="furniture-menu"><i data-feather="menu"></i></a>
        </div>

        <div class="profile-container">
            <img src="{{ Auth::user()->gambar ? asset('img/admin/fotoUser/' . Auth::user()->gambar) : 'default.jpg' }}"
                class="user-pic" id="profilePic">
            <div class="dropdown" id="dropdownMenu">
                <a href="{{ route('profilAdmin') }}" class="dropdown-item">Profil</a>
                <a href="" class="dropdown-item"
                    onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </div>

    </nav>
    <!-- Navbar end -->
    @yield('content')


    <script>
        feather.replace();
    </script>

    <script src="js/pay.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>

    <script>
        function confirmDelete(event) {
            event.preventDefault(); // Mencegah aksi default dari link
            var result = confirm(
                "Apakah anda yakin membatalkan pesanan? Tidak ada uang pengembalian jika anda membatalkan pesanan");
            if (result) {
                // Jika user mengkonfirmasi, submit form secara manual
                event.target.closest('form').submit();
            }
        }
    </script>
</body>

</html>
