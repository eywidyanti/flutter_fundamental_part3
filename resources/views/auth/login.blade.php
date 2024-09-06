<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,300;0,400;0,700;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="/css/login.css">
</head>
<body>
<div class="wrapper">
         <div class="title">
            Login
         </div>
         <hr>
         @if (session('error'))
            <div class="error-messages">
                {{ session('error') }}
            </div>
        @endif

         <form method="POST" action="{{ route('login') }}">
         @csrf
            <div class="field">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                     @enderror
                     <label>Email</label>
            </div>
            <div class="field">
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                <span class="toggle-password"><i class="fas fa-eye" id="toggle-password-icon"></i></span>
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                <label>Password</label>
            </div>
            <div class="content">
               <!-- <div class="checkbox">
                  <input type="checkbox" id="remember-me">
                  <label for="remember-me">Remember me</label>
               </div>
               <div class="pass-link">
                  <a href="#">Forgot password?</a>
               </div> -->
            </div>
            <div class="field">
               <input type="submit" value="Login">
            </div>
            <div class="signup-link">
               Tidak punya akun? <a href="{{ route('register') }}">Daftar sekarang</a>
            </div>
         </form>
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
      </script>
</body>
</html>