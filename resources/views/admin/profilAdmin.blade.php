<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Profil Admin</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,300;0,400;0,700;1,700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/jquery-editable/css/jquery-editable.css"
    rel="stylesheet" />
    <script>$.fn.poshytip = { defaults: null }</script>
    <script
    src="https://cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/jquery-editable/js/jquery-editable-poshytip.min.js"></script>

    <!-- CSS -->
    <!-- icons -->
    <script src="https://unpkg.com/feather-icons"></script>
    <!-- style -->
    <link rel="stylesheet" href="/css/profil.css">
</head>
<body>
  <nav class="navbar">
        <a href="#" class="navbar-logo"> Littlemee<span>Deco</span>.</a>

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
            <a  id="furniture-menu"><i data-feather="menu"></i></a>
        </div>
        <div class="profile-container">
            <img src="{{ Auth::user()->gambar ? asset('img/admin/fotoUser/' . Auth::user()->gambar) : asset('img/admin/fotoUser/default.jpg') }}" class="user-pic" id="profilePic">
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

  <div class="container">
  @csrf
    <div class="profile-card">
        <div class="profile-img-container">
            <img id="profile-img" src="{{ Auth::user()->gambar ? asset('img/admin/fotoUser/' . Auth::user()->gambar) : 'default.jpg' }}" alt="Profile Picture" class="profile-img">
            <div class="camera-icon-container" id="update-photo-icon">
                <i class="fa fa-camera camera-icon"></i>
            </div>
        </div>
    </div>
    <form id="profile-update-form" action="{{ route('profile.imgadmin.update') }}" method="POST" enctype="multipart/form-data" style="display: none;">
        @csrf
        <input type="file" id="profile-image-input" name="profile_image">
    </form>
    <div class="details-card">
      <table>
        <tr>
          <td>Nama</td>
          <td class="editable" data-name="name" data-type="text" data-pk="{{ Auth::user()->id }}"
          data-title="Masukkan Nama">{{ Auth::user()->name }}</td>
        </tr>
        <tr>
          <td>Email</td>
          <td class="editable" data-name="email" data-type="text" data-pk="{{ Auth::user()->id }}"
          data-title="Masukkan Email">{{ Auth::user()->email }}</td>
        </tr>
        <tr>
          <td>No. Telp</td>
          <td class="editable" data-name="noHp" data-type="text" data-pk="{{ Auth::user()->id }}"
          data-title="Masukkan No. Telp">{{ Auth::user()->noHp }}</td>
        </tr>
        <tr>
          <td>Jenis Kelamin</td>
          <td class="editable" data-name="jenis_kelamin"
                    data-type="select" data-pk="{{ Auth::user()->id }}" data-title="Select Gender"
                    data-source='[{"value": "Laki-laki", "text": "Laki-laki"},{"value": "Perempuan", "text": "Perempuan"}]'>{{ Auth::user()->jenis_kelamin }}</td>
        </tr>
      </table>
      
    </div>
  </div>
  <div class="buttons">
    <a href="{{ route('admin') }}"><button class="btnb back">Kembali</button></a>
  </div>

  <script>
      feather.replace();

      document.getElementById('update-photo-icon').onclick = function() {
      document.getElementById('profile-image-input').click();
      };

      document.getElementById('profile-image-input').onchange = function() {
          var formData = new FormData(document.getElementById('profile-update-form'));
          
          $.ajax({
              url: document.getElementById('profile-update-form').action,
              type: 'POST',
              data: formData,
              processData: false,
              contentType: false,
              success: function(response) {
                  if (response.success) {
                      document.getElementById('profile-img').src = response.image;
                      document.getElementById('profilePic').src = response.image;
                  } else {
                      alert('There was an error updating your profile picture.');
                  }
              },
              error: function() {
                  alert('There was an error updating your profile picture.');
              }
          });
      };

      $.fn.editable.defaults.mode = "inline";

      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': '{{ csrf_token() }}'
          }
      });

      $('.editable[data-name="name"]').editable({
          url: "{{ route('admin.update') }}",
          type: 'text',
          pk: 1,
          name: 'name',
          title: 'Enter name'
      });
      $('.editable[data-name="email"]').editable({
          url: "{{ route('admin.update') }}",
          type: 'text',
          pk: 1,
          name: 'email',
          title: 'Enter Email'
      });
      $('.editable[data-name="noHp"]').editable({
          url: "{{ route('admin.update') }}",
          type: 'text',
          pk: 1,
          name: 'noHp',
          title: 'Enter Phone'
      });
      $('.editable[data-name="jenis_kelamin"]').editable({
      url: "{{ route('admin.update') }}",
      type: 'select',
      pk: 1,
      name: 'jenis_kelamin',
      title: 'Select Gender',
      source: [
          { value: 'Laki-laki', text: 'Laki-laki' },
          { value: 'Perempuan', text: 'Perempuan' }
      ]
      });
  </script>

    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <!-- JS -->
    <script src="js/admin.js"></script>
</body>
</html>
