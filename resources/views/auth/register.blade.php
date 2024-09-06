<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,300;0,400;0,700;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="/css/login.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="wrapper">
        <div class="title">
            REGISTRASI
        </div>
        <hr>
        
        @if ($errors->any())
            <div class="error-messages">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
            @csrf

            <div class="field">
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required>
                <label>Nama</label>
            </div>

            <div class="field">
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required>
                <label>Email</label>
            </div>

            <div class="field">
                <input id="noHp" type="text" class="form-control @error('noHp') is-invalid @enderror" name="noHp" value="{{ old('noHp') }}" required>
                <label>No Hp</label>
            </div>

            <div class="field">
                <select name="jenis_kelamin" required>
                    <option value="" disabled selected>Jenis Kelamin</option>
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
            </div>

            <div class="field">
                <input id="gambar" type="file" class="form-control @error('gambar') is-invalid @enderror" name="gambar" value="{{ old('gambar') }}" required>
            </div>

            <div class="field">
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
                <span class="toggle-password"><i class="fas fa-eye" id="toggle-password-icon"></i></span>
                <label>Password</label>
            </div>
            
            <div class="field">
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                <span class="toggle-password"><i class="fas fa-eye" id="toggle-password-confirm-icon"></i></span>
                <label>Confirm Password</label>
            </div>

            <div class="field">
                <input type="submit" value="register">
            </div>

            <div class="signup-link">
                Punya akun? <a href="{{ route('login') }}">Login Sekarang</a>
            </div>
        </form>
    </div>
        <!-- Terms & Conditions Modal -->
        <div id="termsModal" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <h2>SYARAT LAYANAN</h2>
                    <br>
                    <p>Salam Kepada Para Pengguna,</p>
                    <br>
                    <p>Apabila penyewa ingin membatalkan pesanan maka uang yang telah di bayar tidak dapat dikembalikan.</p>
                    <br>
                    <p>Penyewa tidak dapat mengubah tanggal pemesanan apabila pesanan telah di bayar.</p>
                    <div class="modal-footer">
                        <input type="checkbox" id="termsCheckbox">
                        <label for="termsCheckbox">Saya setuju dengan <span>Ketentuan Layanan</span> dan membaca pemberitahuan privasi.</label>
                        <br>
                        <button id="acceptTerms">Setuju</button>
                        <button id="declineTerms">Tidak Setuju</button>
                    </div>
                </div>
            </div>
    <script>
        document.getElementById('toggle-password-icon').addEventListener('click', function() {
            var passwordField = document.getElementById('password');
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                this.classList.remove('fa-eye');
                this.classList.add('fa-eye-slash');
            } else {
                passwordField.type = 'password';
                this.classList.remove('fa-eye-slash');
                this.classList.add('fa-eye');
            }
        });

        document.getElementById('toggle-password-confirm-icon').addEventListener('click', function() {
            var passwordField = document.getElementById('password-confirm');
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                this.classList.remove('fa-eye');
                this.classList.add('fa-eye-slash');
            } else {
                passwordField.type = 'password';
                this.classList.remove('fa-eye-slash');
                this.classList.add('fa-eye');
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
        var modal = document.getElementById("termsModal");
        var btn = document.querySelector('input[type="submit"]');
        var span = document.getElementsByClassName("close")[0];
        var acceptBtn = document.getElementById("acceptTerms");
        var declineBtn = document.getElementById("declineTerms");
        var termsCheckbox = document.getElementById("termsCheckbox");

        btn.addEventListener('click', function(event) {
            event.preventDefault();
            modal.style.display = "block";
        });

        span.onclick = function() {
            modal.style.display = "none";
        }

        acceptBtn.onclick = function() {
            if (termsCheckbox.checked) {
                modal.style.display = "none";
                document.querySelector('form').submit();
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Anda harus menyetujui Syarat dan Ketentuan.',
                });
            }
        }

        declineBtn.onclick = function() {
            modal.style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    });
    </script>
</body>
</html>