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
        <div class="auth-wrapper v1">
            <div class="auth-form">
                <div class="card my-5">
                    <div class="card-body">
                        <a href="#">
                            <h1 class="text-success">{{ config('app.name') }}</h1>
                        </a>
                        <div class="d-flex justify-content-between align-items-end mb-4">
                            <h3 class="mb-0"><b>Forgot Password</b></h3>
                            <a href="{{ route('login') }}" class="link-primary">Back to Login</a>
                        </div>
                        @if (session('status'))
                            <div class="alert alert-success mt-3" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <form action="{{ route('password.email') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Email Address</label>
                                <input type="email" name="email" class="form-control" placeholder="Enter your email"
                                    required />
                                @error('email')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="d-grid mt-3">
                                <button type="submit" class="btn btn-primary">Send Reset Link</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


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
