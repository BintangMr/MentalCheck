@extends('../layout/' . $layout)

@section('head')
    <title>Mental Check | Register</title>
@endsection

@section('content')
    <div class="container sm:px-10">
        <div class="block xl:grid grid-cols-2 gap-4">
            <!-- BEGIN: Login Info -->
            <div class="hidden xl:flex flex-col min-h-screen">
                <a href="{{ route('index') }}" class="-intro-x flex items-center pt-5">
                    <img alt="Logo" class="w-6" src="{{ asset('assets/logos/logo.png') }}">
                    <span class="text-white text-lg ml-3">
                        Mental<span class="font-medium"> Check</span>
                    </span>
                </a>
                <div class="my-auto">
                    <img alt="Bg" class="-intro-x w-1/2 -mt-16" src="{{ asset('dist/images/illustration.svg') }}">
                    <div class="-intro-x text-white font-medium text-4xl leading-tight mt-10">Selamat datang!<br> Silahkan daftar untuk memulai.</div>
                    <div class="-intro-x mt-5 text-lg text-white text-opacity-70 dark:text-gray-500">Mental Check memudahkan untuk mengetahui mental anda</div>
                </div>
            </div>
            <!-- END: Login Info -->
            <!-- BEGIN: Login Form -->
            <div class="h-screen xl:h-auto flex py-5 xl:py-0 my-10 xl:my-0">
                    <div class="my-auto mx-auto xl:ml-20 bg-white dark:bg-dark-1 xl:bg-transparent px-5 sm:px-8 py-8 xl:p-0 rounded-md shadow-md xl:shadow-none w-full sm:w-3/4 lg:w-2/4 xl:w-auto">
                        <h2 class="intro-x font-bold text-2xl xl:text-3xl text-center xl:text-left">
                            Register
                        </h2>
                        <div class="intro-x mt-2 text-gray-500 dark:text-gray-500 xl:hidden text-center">Selamat datang! Silahkan daftar untuk memulai. Mental Check memudahkan untuk mengetahui mental anda</div>
                        <div class="intro-x mt-8">
                            <form id="register-form">
                                <input id="nama" type="text" class="intro-x login__input form-control py-3 px-4 border-gray-300 block" placeholder="Nama Lengkap">
                                <div id="error-nama" class="login__input-error w-5/6 text-theme-6 mt-2"></div>
                                <input id="email" type="email" class="intro-x login__input form-control py-3 px-4 border-gray-300 block mt-4" placeholder="Email">
                                <div id="error-email" class="login__input-error w-5/6 text-theme-6 mt-2"></div>
                                <input id="password" type="password" class="intro-x login__input form-control py-3 px-4 border-gray-300 block mt-4" placeholder="Password">
                                <div id="error-password" class="login__input-error w-5/6 text-theme-6 mt-2"></div>
                                <input id="password_confirmation" type="password" class="intro-x login__input form-control py-3 px-4 border-gray-300 block mt-4" placeholder="Konfirmasi Password">
                                <div id="error-password_confirmation" class="login__input-error w-5/6 text-theme-6 mt-2"></div>
                            </form>
                        </div>
                        <div class="intro-x mt-5 xl:mt-8 text-center xl:text-left">
                            <button id="btn-register" class="btn btn-primary py-3 px-4 w-full xl:w-32 xl:mr-3 align-top">Register</button>
                            <button id="btn-sign-in" class="btn btn-outline-secondary py-3 px-4 w-full xl:w-32 mt-3 xl:mt-0 align-top">Sign in</button>
                        </div>
                    </div>
                </div>
            <!-- END: Login Form -->
        </div>
    </div>
@endsection

@section('script')
    <script>
        cash(function () {
            async function register() {
                // Reset state
                cash('#register-form').find('.login__input').removeClass('border-theme-6')
                cash('#register-form').find('.login__input-error').html('')

                // Post form
                let nama = cash('#nama').val()
                let email = cash('#email').val()
                let password = cash('#password').val()
                let password_confirmation = cash('#password_confirmation').val()

                // Loading state
                cash('#btn-register').html('<i data-loading-icon="oval" data-color="white" class="w-5 h-5 mx-auto"></i>').svgLoader()
                await helper.delay(1500)

                axios.post(`register`, {
                    nama: nama,
                    email: email,
                    password: password,
                    password_confirmation: password_confirmation
                }).then(res => {
                    Swal.fire(
                        'Berhasil!',
                        'Registrasi anda berhasil.',
                        'success'
                    ).then((result) => {
                        location.href = res.data.url
                    })
                }).catch(err => {
                    cash('#btn-register').html('Login')
                    for (const [key, val] of Object.entries(err.response.data.errors)) {
                        cash(`#${key}`).addClass('border-theme-6')
                        cash(`#error-${key}`).html(val)
                    }
                })
            }

            cash('#register-form').on('keyup', function(e) {
                if (e.keyCode === 13) {
                    register()
                }
            })

            cash('#btn-register').on('click', function() {
                register()
            })

            cash('#btn-sign-in').on('click', function() {
                window.location.href = '{{ route("login-view") }}';
            })
        })
    </script>
@endsection
