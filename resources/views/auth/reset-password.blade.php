<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

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
        <div class="auth-wrapper v1">
            <div class="auth-form">
                <div class="card my-5">
                    <div class="card-body">
                        <a href="#">
                            <h1 class="text-success">Logistics</h1>
                        </a>
                        <h3><b>Reset Password</b></h3>
                        @if (session('status'))
                            <div class="alert alert-success mt-3" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <form action="{{ route('password.update') }}" method="POST">
                            @csrf
                            <input type="hidden" name="token" value="{{ $token }}">
                            <input type="hidden" name="email" value="{{ $email }}">
                            <div class="mb-3 position-relative">
                                <label class="form-label">New Password</label>
                                <input type="password" name="password" class="form-control" id="passwordInput"
                                    placeholder="Enter new password" required />
                                <button type="button"
                                    class="btn position-absolute end-0 top-50 translate-middle-y text-success mt-3"
                                    id="togglePassword" style="border: none; background: transparent;">
                                    <i class="fas fa-eye" id="passwordIcon"></i>
                                </button>
                                @error('password')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="mb-3 position-relative">
                                <label class="form-label">Confirm Password</label>
                                <input type="password" name="password_confirmation" class="form-control"
                                    id="confirmPasswordInput" placeholder="Confirm your password" required />
                                <button type="button"
                                    class="btn position-absolute end-0 top-50 translate-middle-y text-success mt-3"
                                    id="toggleConfirmPassword" style="border: none; background: transparent;">
                                    <i class="fas fa-eye" id="confirmPasswordIcon"></i>
                                </button>
                                @error('password_confirmation')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-primary">Reset Password</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


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
    <script>
        // Toggle New Password Visibility
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('passwordInput');
            const passwordIcon = document.getElementById('passwordIcon');

            // Toggle the type attribute
            const isPassword = passwordInput.type === 'password';
            passwordInput.type = isPassword ? 'text' : 'password';

            // Toggle the icon
            passwordIcon.classList.toggle('fa-eye', !isPassword);
            passwordIcon.classList.toggle('fa-eye-slash', isPassword);
        });
        // Toggle Confirm Password Visibility
        document.getElementById('toggleConfirmPassword').addEventListener('click', function() {
            const confirmPasswordInput = document.getElementById('confirmPasswordInput');
            const confirmPasswordIcon = document.getElementById('confirmPasswordIcon');

            // Toggle the type attribute
            const isPassword = confirmPasswordInput.type === 'password';
            confirmPasswordInput.type = isPassword ? 'text' : 'password';

            // Toggle the icon
            confirmPasswordIcon.classList.toggle('fa-eye', !isPassword);
            confirmPasswordIcon.classList.toggle('fa-eye-slash', isPassword);
        });
    </script>
    <script src="{{ asset('/auth/js/plugins/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('/auth/js/pages/ac-alert.js') }}"></script>
</body>

</html>
