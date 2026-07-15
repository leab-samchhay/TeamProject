<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from coderthemes.com/osen/layouts/auth-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 24 Dec 2025 02:31:39 GMT -->

<head>
    <meta charset="utf-8" />
    <title>Log In | Osen - Responsive Bootstrap 5 Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <!-- Theme Config Js -->
    <script src="assets/js/config.js"></script>

    <!-- Vendor css -->
    <link href="assets/css/vendor.min.css" rel="stylesheet" type="text/css" />

    <!-- App css -->
    <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-style" />

    <!-- Icons css -->
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
</head>

<body>

    <div class="auth-bg d-flex min-vh-100 justify-content-center align-items-center">
        <div class="row g-0 justify-content-center w-100 m-xxl-5 px-xxl-4 m-3">
            <div class="col-xl-4 col-lg-5 col-md-6">
                <div class="card overflow-hidden h-100 p-xxl-4 p-3 mb-0">
                    <a href="index.html" class="auth-brand mb-3 text-center">
                        <img src="assets/images/logo-dark.png" alt="dark logo" height="24" class="logo-dark">
                        <img src="assets/images/logo.png" alt="logo light" height="24" class="logo-light">
                    </a>

                    <h3 class="fw-semibold mb-2 text-center">Register Account</h3>


                    <form method="POST" action="{{ route('register') }}" class="text-start mb-2">
                        @csrf
                        <div class="mb-2">
                            <label class="form-label" for="name">Name</label>
                            <input id="name" type="text" name="name"
                                class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}"
                                required autocomplete="name" autofocus>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-2">
                            <label class="form-label" for="email">Email</label>
                            <input id="email" type="email" name="email"
                                class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}"
                                required autocomplete="email">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-2">
                            <label class="form-label" for="password">Password</label>
                            <input id="password" type="password" name="password"
                                class="form-control @error('password') is-invalid @enderror" required
                                autocomplete="new-password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-2">
                            <label class="form-label" for="password-confirm">Confirm Password</label>
                            <input id="password-confirm" type="password" name="password_confirmation"
                                class="form-control" required autocomplete="new-password">
                        </div>

                        <div class="d-grid">
                            <button class="btn btn-primary" type="submit">Register</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <!-- Vendor js -->
    <script src="assets/js/vendor.min.js"></script>

    <!-- App js -->
    <script src="assets/js/app.js"></script>

</body>


<!-- Mirrored from coderthemes.com/osen/layouts/auth-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 24 Dec 2025 02:31:39 GMT -->

</html>
