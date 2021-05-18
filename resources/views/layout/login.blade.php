@extends('../layout/base')

@section('body')
    <body class="login">
        @yield('content')
        @include('../layout/components/dark-mode-switcher')

        <!-- BEGIN: JS Assets-->
        <script src="{{ mix('dist/js/app.js') }}"></script>
        <!-- END: JS Assets-->
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
        @yield('script')
    </body>
@endsection
