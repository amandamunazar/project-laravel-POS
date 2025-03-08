<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Login</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('asset') }}/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('asset') }}/css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom style -->
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background: linear-gradient(90deg, #4e73df 0%, #224abe 100%);
        }

        .card-login {
            max-width: 360px;
            width: 100%;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        }

        .bg-login-image {
            background-image: url('your-image-url-here');
            /* Sesuaikan URL gambar */
            background-size: cover;
            background-position: center;
            height: 100%;
        }

        .card-body {
            padding: 20px;
        }

        .btn {
            border-radius: 20px;
        }

        .form-control {
            border-radius: 20px;
        }

        .btn-user {
            font-size: 0.9rem;
        }

        h1 {
            font-size: 1.5rem;
        }
    </style>
</head>

<body>

    <div class="card o-hidden border-0 shadow-lg card-login">
        <div class="card-body">
            <!-- Nested Row within Card Body -->
            <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
            </div>
            <form action="{{ route('login-cek') }}" method="POST" class="user">
                @csrf

                <!-- Username Input -->
                <div class="form-group">
                    <input type="email" name="email" class="form-control form-control-user" id="email"
                        placeholder="Enter Useremail" value="{{ old('email') }}" required>
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Password Input -->
                <div class="form-group">
                    <input type="password" name="password" class="form-control form-control-user" id="password"
                        placeholder="Enter Password" required>
                    @error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Remember Me Checkbox -->
                <div class="form-group">
                    <div class="custom-control custom-checkbox small">
                        <input type="checkbox" class="custom-control-input" id="customCheck">
                        <label class="custom-control-label" for="customCheck">Remember
                            Me</label>
                    </div>
                </div>

                <!-- Login Button -->
                <button type="submit" class="btn btn-primary btn-user btn-block">
                    Login
                </button>

            </form>
            <hr>
            <div class="text-center">
                <a class="small" href="forgot-password.html">Forgot Password?</a>
            </div>
            <div class="text-center">
                <a class="small" href="register.html">Create an Account!</a>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('asset') }}/vendor/jquery/jquery.min.js"></script>
    <script src="{{ asset('asset') }}/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('asset') }}/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('asset') }}/js/sb-admin-2.min.js"></script>

</body>

</html>
