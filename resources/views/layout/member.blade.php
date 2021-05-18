<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    @yield('title')
    <title>Mental Check Website</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="{{ asset("assets/img/favicon.png") }}" rel="icon">
    <link href="{{ asset("assets/img/favicon.png") }}" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">

    <!-- Vendor CSS Files -->
    <link href="{{ asset("assets/vendor/aos/aos.css") }}" rel="stylesheet">
    <link href="{{ asset("assets/vendor/bootstrap/css/bootstrap.min.css") }}" rel="stylesheet">
    <link href="{{ asset("assets/vendor/bootstrap-icons/bootstrap-icons.css") }}" rel="stylesheet">
    <link href="{{ asset("assets/vendor/boxicons/css/boxicons.min.css") }}" rel="stylesheet">
    <link href="{{ asset("assets/vendor/glightbox/css/glightbox.min.css") }}" rel="stylesheet">
    <link href="{{ asset("assets/vendor/remixicon/remixicon.css") }}" rel="stylesheet">
    <link href="{{ asset("assets/vendor/swiper/swiper-bundle.min.css") }}" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="{{ asset("assets/css/style.css") }}" rel="stylesheet">

    <style>
        .services .icon-box:hover .icon {
            color: #3498db !important;
        }
    </style>

    @stack('css')
</head>

<body>
<!--loader-->
<div class="bg-loader">
    <div class="loader"></div>
</div>
<!-- ======= Header ======= -->
<header id="header" class="fixed-top d-flex align-items-center">
    <div class="container d-flex align-items-center justify-content-between">

        <div class="logo">
            <h1><a href="{{ route('index') }}">MENTAL CHECK</a></h1>
            <!-- Uncomment below if you prefer to use an image logo -->
            <!-- <a href="index.html"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->
        </div>

        <nav id="navbar" class="navbar">
            <ul>
                <li><a class="nav-link scrollto" @if(Route::currentRouteName() != 'index') href="{{route('index')}}#hero" @else href="#hero" @endif>Beranda</a></li>
                <li><a class="nav-link scrollto" @if(Route::currentRouteName() != 'index') href="{{route('index')}}#about" @else href="#about" @endif>Tentang</a></li>
                <li><a class="nav-link scrollto" @if(Route::currentRouteName() != 'index') href="{{route('index')}}#check" @else href="#check" @endif>Mental Check</a></li>
                <li><a class="nav-link scrollto" @if(Route::currentRouteName() != 'index') href="{{route('index')}}#team" @else href="#team" @endif>Tim</a></li>
                <li><a class="nav-link scrollto" @if(Route::currentRouteName() != 'index') href="{{route('index')}}#article" @else href="#article" @endif>Artikel</a></li>
                <li><a class="nav-link scrollto" @if(Route::currentRouteName() != 'index') href="{{route('index')}}#contact" @else href="#contact" @endif>Kontak</a></li>
                @if(Auth::check())
                    @if(Auth::user()->admin)
                        <li><a class="nav-link scrollto" href="{{ route('admin') }}">Admin Panel</a></li>
                    @else
                        <li><a class="nav-link scrollto" href="{{ route('member') }}">Member Panel</a></li>
                    @endif
                @endif

                @if(Auth::check())
                    <style>
                        .bs-example {
                            margin: 20px;
                        }
                    </style>
                    <div class="bs-example">
                        <div class="btn-group">
                            <div class="btn-group">
                                <button type="reset" class="btn btn-primary dropdown-toggle"
                                        data-toggle="dropdown">{{ Auth::user()->name }}</button>
                                <div class="dropdown-menu">
                                    <a href="{{ route('member.profile') }}" class="dropdown-item">Profile</a>
                                    <a href="{{ route('member.history') }}" class="dropdown-item">Riwayat</a>
                                    <div class="dropdown-divider"></div>
                                    <a href="{{ route('logout') }}" class="dropdown-item">Logout</a>

                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <li><a class="getstarted scrollto" href="{{ route('login-view') }}">Login</a></li>
                @endif
            </ul>
            <i class="bi bi-list mobile-nav-toggle"></i>
        </nav><!-- .navbar -->

    </div>
</header><!-- End Header -->

<!-- ======= Hero Section ======= -->
@yield('content')
<!-- ======= Footer ======= -->
<footer id="footer">
    <div class="container">
        <div class="row d-flex align-items-center">
            <div class="col-lg-6 col-sm-12 text-lg-left text-center">
                <div class="copyright">
                    &copy; Copyright <strong>SMKN 1 Katapang</strong>. Seluruh Hak Cipta
                </div>
                <div class="credits">
                    Dibuat {{ \Carbon\Carbon::now()->year }}</a>
                </div>
            </div>
            <div class="col-lg-6 col-sm-12 text-center mx-auto">
                <span> Support By</span>
                <a href="https://inovindo.co.id/" target="_blank">
                    <img src="{{ asset('assets/logos/Inovindo-digital-media.png') }}" width="150px">
                </a>
            </div>
        </div>
    </div>
</footer><!-- End Footer -->
<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
        class="bi bi-arrow-up-short"></i></a>

<!-- Vendor JS Files -->
<script src="{{ asset("assets/vendor/aos/aos.js") }}"></script>
<script src="{{ asset("assets/vendor/bootstrap/js/bootstrap.bundle.min.js") }}"></script>
<script src="{{ asset("assets/vendor/glightbox/js/glightbox.min.js") }}"></script>
<script src="{{ asset("assets/vendor/isotope-layout/isotope.pkgd.min.js") }}"></script>
<script src="{{ asset("assets/vendor/php-email-form/validate.js") }}"></script>
<script src="{{ asset("assets/vendor/purecounter/purecounter.js") }}"></script>
<script src="{{ asset("assets/vendor/swiper/swiper-bundle.min.js") }}"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>

<!-- Template Main JS File -->
<script src="{{ asset("assets/js/main.js") }}"></script>
<script>
    feather.replace()
</script>

@stack('js')
</body>

</html>
