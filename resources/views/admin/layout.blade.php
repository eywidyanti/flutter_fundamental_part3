<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wedding Org</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> -->
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,300;0,400;0,700;1,700&display=swap"
        rel="stylesheet">

    <!-- icons -->
    <script src="https://unpkg.com/feather-icons"></script>

    <!-- style -->
    <link rel="stylesheet" href="/css/admin.css">
</head>


<body>
    <!-- Navbar started -->
    <nav class="navbar">
        <a href="#" class="navbar-logo"> Littlemee.<span>Deco</span></a>

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
            <img src="{{ Auth::user()->gambar ? asset('img/admin/fotoUser/' . Auth::user()->gambar) : asset('img/admin/fotoUser/default.jpg') }}"
                class="user-pic" id="profilePic">
            <div class="dropdown" id="dropdownMenu">
                <a href="{{ route('profilAdmin') }}" class="dropdown-item">Profil</a>
                <a href="{{ route('logout') }}" class="dropdown-item"
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
    <!-- Navbar end -->

    <!-- hero section start -->
    <div class="container">
        @yield('content')
    </div>
    <!-- dekor end -->

    <!-- icons -->
    <script>
        feather.replace();
    </script>

    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <!-- JS -->
    <script src="js/admin.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function() {
        // Tangani klik pada link pagination
        $(document).on('click', '.pagination-link, .pagination-number', function(e) {
            e.preventDefault();
            
            var url = $(this).attr('href');
            
            if (url) {
                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(data) {
                        // Perbarui konten dengan data baru
                        $('#data-container').html($(data).find('#data-container').html());
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', status, error);
                    }
                });
            }
        });
    });
    </script>
    <script>
        function confirmDelete(event) {
            event.preventDefault(); // Mencegah aksi default dari link
            var result = confirm("Apakah Anda yakin ingin menghapus item ini?");
            if (result) {
                // Jika user mengkonfirmasi, submit form secara manual
                event.target.closest('form').submit();
            }
        }
    </script>
</body>
</html>
