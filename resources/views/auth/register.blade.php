<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }} - Register</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="icon" href="{{ asset('/auth/images/favicon.svg') }}" type="image/x-icon" />
    <link rel="stylesheet" href="{{ asset('/auth/fonts/inter/inter.css') }}" id="main-font-link" />
    <link rel="stylesheet" href="{{ asset('/auth/fonts/phosphor/duotone/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('/auth/fonts/tabler-icons.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('/auth/fonts/feather.css') }}" />
    <link rel="stylesheet" href="{{ asset('/auth/fonts/fontawesome.css') }}" />
    <link rel="stylesheet" href="{{ asset('/auth/fonts/material.css') }}" />
    <link rel="stylesheet" href="{{ asset('/auth/css/style.css') }}" id="main-style-link" />
    <link rel="stylesheet" href="{{ asset('/auth/css/style-preset.css') }}" />
    <link rel="stylesheet" href="{{ asset('/auth/css/uikit.css') }}" />
</head>

<body data-pc-preset="preset-8" data-pc-sidebar-caption="true" data-pc-layout="vertical" data-pc-direction="ltr"
    data-pc-theme_contrast="" data-pc-theme="light" class="component-page">

    <div class="auth-main">
        <div class="auth-wrapper v2">
            <div class="auth-form">
                <div class="card my-5">
                    <div class="card-body">
                        <div class="text-center">
                            <a href="#">
                                <h1 class="text-success">Logistics</h1>
                            </a>
                            <h4 class="text-center f-w-500 mb-3">Register</h4>

                            <!-- Error Messages -->
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <!-- Registration Form -->
                            <form action="{{ route('web.auth.register') }}" method="POST" id="registerForm">
                                @csrf
                                <div class="mb-3">
                                    <input type="text" name="first_name" class="form-control"
                                        placeholder="First Name" required value="{{ old('first_name') }}" />
                                    @error('first_name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <input type="text" name="last_name" class="form-control" placeholder="Last Name"
                                        required value="{{ old('last_name') }}" />
                                    @error('last_name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <input type="text" name="username" class="form-control" placeholder="Username"
                                        required value="{{ old('username') }}" />
                                    @error('username')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <input type="email" name="email" class="form-control"
                                        placeholder="Email Address" required value="{{ old('email') }}" />
                                    @error('email')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <input type="password" name="password" class="form-control" placeholder="Password"
                                        required />
                                    @error('password')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <input type="password" name="password_confirmation" class="form-control"
                                        placeholder="Confirm Password" required />
                                    @error('password_confirmation')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <input type="text" name="contact" class="form-control"
                                        placeholder="Contact Number" value="{{ old('contact') }}" />
                                    @error('contact')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <input type="text" name="address" class="form-control" placeholder="Address"
                                        value="{{ old('address') }}" />
                                    @error('address')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="d-grid mt-4">
                                    <button type="submit" class="btn btn-primary" id="registerButton">
                                        Register
                                    </button>
                                </div>
                            </form>
                            <div class="mt-3 text-center">
                                Already have an account? <a href="{{ route('login') }}"
                                    class="text-primary">Login</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('/auth/js/plugins/bootstrap.min.js') }}"></script>
</body>

</html>
