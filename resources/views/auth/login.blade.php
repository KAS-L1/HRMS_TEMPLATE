<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <!-- [Favicon] icon -->
    <link rel="icon" href="{{ asset('/auth/images/favicon.svg') }}" type="image/x-icon" />
    <!-- [Font] Family -->
    <link rel="stylesheet" href="{{ asset('/auth/fonts/inter/inter.css') }}" id="main-font-link" />
    <!-- [phosphor Icons] https://phosphoricons.com/ -->
    <link rel="stylesheet" href="{{ asset('/auth/fonts/phosphor/duotone/style.css') }}" />
    <!-- [Tabler Icons] https://tablericons.com -->
    <link rel="stylesheet" href="{{ asset('/auth/fonts/tabler-icons.min.css') }}" />
    <!-- [Feather Icons] https://feathericons.com -->
    <link rel="stylesheet" href="{{ asset('/auth/fonts/feather.css') }}" />
    <!-- [Font Awesome Icons] https://fontawesome.com/icons -->
    <link rel="stylesheet" href="{{ asset('/auth/fonts/fontawesome.css') }}" />
    <!-- [Material Icons] https://fonts.google.com/icons -->
    <link rel="stylesheet" href="{{ asset('/auth/fonts/material.css') }}" />
    <!-- [Template CSS Files] -->
    <link rel="stylesheet" href="{{ asset('/auth/css/style.css') }}" id="main-style-link" />
    <script src="{{ asset('/auth/js/tech-stack.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('/auth/css/style-preset.css') }}" />
    <link rel="stylesheet" href="{{ asset('/auth/css/uikit.css') }}" />


    <!-- Scripts -->
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
</head>
<!-- [Head] end -->
<!-- [Body] Start -->

<body data-pc-preset="preset-8" data-pc-sidebar-caption="true" data-pc-layout="vertical" data-pc-direction="ltr"
    data-pc-theme_contrast="" data-pc-theme="light" class="component-page">
    <!-- [ Pre-loader ] start -->
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>

    <!-- [ Pre-loader ] end -->

    <div class="auth-main">
        <div class="auth-wrapper v2">
            <div class="auth-form">
                <div class="card my-5">
                    <div class="card-body">
                        <div class="text-center">
                            <a href="#">
                                <h1 class="text-success">{{ config('app.name') }}</h1>
                            </a>
                            <h4 class="text-center f-w-500 mb-3">Login</h4>

                            <!-- Success Message -->
                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif

                            <!-- Login Form -->
                            <form action="{{ route('login') }}" method="POST" id="loginForm">
                                @csrf
                                <div class="mb-3">
                                    <input type="text" name="login" class="form-control"
                                        placeholder="Username or Email" required value="{{ old('login') }}" />
                                    @error('login')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 position-relative">
                                    <input type="password" name="password" class="form-control" id="passwordInput"
                                        placeholder="Password" required />
                                    <button type="button"
                                        class="btn position-absolute end-0 top-50 translate-middle-y text-success"
                                        id="togglePassword" style="border: none; background: transparent;">
                                        <i class="fas fa-eye" id="passwordIcon"></i>
                                    </button>
                                    @error('password')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="d-flex mt-1 justify-content-between align-items-center">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember"
                                            {{ old('remember') ? 'checked' : '' }} />
                                        <label class="form-check-label">Remember me</label>
                                    </div>
                                    <a href="{{ route('password.request') }}">Forgot Password?</a>
                                </div>
                                <div class="d-grid mt-4">
                                    <button type="submit" class="btn btn-primary" id="loginButton">
                                        <span id="buttonText">Login</span>
                                        <div id="buttonLoader" class="d-none">
                                            <div class="spinner-border spinner-border-sm text-light" role="status">
                                            </div>
                                            <span class="ms-2">Logging in...</span>
                                        </div>
                                    </button>
                                    <div class="mt-3">
                                        <a href="{{ route('register') }}">Don't have Account?</a>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Get the form and button elements
        const loginForm = document.getElementById('loginForm');
        const loginButton = document.getElementById('loginButton');
        const buttonText = document.getElementById('buttonText');
        const buttonLoader = document.getElementById('buttonLoader');

        // Add a submit event listener to the form
        loginForm.addEventListener('submit', function() {
            // Disable the button to prevent multiple submissions
            loginButton.disabled = true;

            // Hide the button text and show the loader with "Logging in..."
            buttonText.classList.add('d-none');
            buttonLoader.classList.remove('d-none');
        });

        // Password Toggle Script
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('passwordInput');
            const passwordIcon = document.getElementById('passwordIcon');

            // Toggle the type attribute
            const isPassword = passwordInput.type === 'password';
            passwordInput.type = isPassword ? 'text' : 'password';

            // Toggle the icon class
            passwordIcon.classList.toggle('fa-eye', !isPassword);
            passwordIcon.classList.toggle('fa-eye-slash', isPassword);
        });
    </script>


    <!-- [ Main Content ] end -->
    <!-- Required Js -->
    <script src="{{ asset('/auth/js/plugins/popper.min.js') }}"></script>
    <script src="{{ asset('/auth/js/plugins/simplebar.min.js') }}"></script>
    <script src="{{ asset('/auth/js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ asset('/auth/js/fonts/custom-font.js') }}"></script>
    <script src="{{ asset('/auth/js/pcoded.js') }}"></script>
    <script src="{{ asset('/auth/js/plugins/feather.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/highlight.min.js"></script>
    <script src="{{ asset('/auth/js/plugins/clipboard.min.js') }}"></script>
    <script src="{{ asset('/auth/js/component.js') }}"></script>
    <script>
        // pc-component
        var elem = document.querySelectorAll('.component-list-card a');
        for (var l = 0; l < elem.length; l++) {
            var pageUrl = window.location.href.split(/[?#]/)[0];
            if (elem[l].href == pageUrl && elem[l].getAttribute('href') != '') {
                elem[l].classList.add('active');
            }
        }
        document.querySelector('#compo-menu-search').addEventListener('keyup', function() {
            var tval = document.querySelector('#compo-menu-search').value.toLowerCase();
            var elem = document.querySelectorAll('.component-list-card a');
            for (var l = 0; l < elem.length; l++) {
                var aval = elem[l].innerHTML.toLowerCase();
                var n = aval.indexOf(tval);
                if (n !== -1) {
                    elem[l].style.display = 'block';
                } else {
                    elem[l].style.display = 'none';
                }
            }
        });
    </script>
    <script src="{{ asset('/auth/js/plugins/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('/auth/js/pages/ac-alert.js') }}"></script>
</body>
<!-- [Body Content] end -->
</body>

</html>
