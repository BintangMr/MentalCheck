@extends('../layout/' . $layout)

@section('head')
    <title>Mental Check | Verifikasi Email</title>
@endsection

@section('content')
    <div class="container sm:px-10">
        <div class="block xl:grid grid-cols-2 gap-4">
            <!-- BEGIN: Login Info -->
            <div class="hidden xl:flex flex-col min-h-screen">
                <a href="{{ route('index') }}" class="-intro-x flex items-center pt-5">
                    <img alt="Rubick Tailwind HTML Admin Template" class="w-6" src="{{ asset('assets/logos/logo.png') }}">
                    <span class="text-white text-lg ml-3">
                        Mental<span class="font-medium"> Check</span>
                    </span>
                </a>
                <div class="my-auto">
                    <img alt="Rubick Tailwind HTML Admin Template" class="-intro-x w-1/2 -mt-16" src="{{ asset('dist/images/illustration.svg') }}">
                    <div class="-intro-x text-white font-medium text-4xl leading-tight mt-10">Hai! <br> Silahkan verifikasi E-mail anda.</div>
                    <div class="-intro-x mt-5 text-lg text-white text-opacity-70 dark:text-gray-500">Mental Check memudahkan untuk mengetahui mental anda</div>
                </div>
            </div>
            <!-- END: Login Info -->
            <!-- BEGIN: Login Form -->
            <div class="h-screen xl:h-auto flex py-5 xl:py-0 my-10 xl:my-0">
                <div class="my-auto mx-auto xl:ml-20 bg-white dark:bg-dark-1 xl:bg-transparent px-5 sm:px-8 py-8 xl:p-0 rounded-md shadow-md xl:shadow-none w-full sm:w-3/4 lg:w-2/4 xl:w-auto">
                    <h2 class="intro-x font-bold text-2xl xl:text-3xl text-center xl:text-left">Verifikasi Email</h2>
                    <div class="intro-x mt-2 text-gray-500 xl:hidden text-center">Selamat datang! Silahkan masuk ke akun anda. Mental Check memudahkan untuk mengetahui mental anda</div>
                    <div class="intro-x mt-8">
                        <form id="login-form">
                            <input id="email" type="text" class="intro-x login__input form-control py-3 px-4 border-gray-300 block" placeholder="Email" value="{{ Auth::user()->email }}" disabled>
                            <div id="error-email" class="login__input-error w-5/6 text-theme-6 mt-2"></div>
                        </form>
                    </div>
                    <div class="intro-x mt-5 xl:mt-8 text-center xl:text-left">
                        <button id="btn-verifikasi" class="btn btn-primary py-3 px-4 w-full xl:w-32 xl:mr-3 align-top">Verifikasi!</button>
                        <button id="btn-logout" class="btn btn-outline-secondary py-3 px-4 w-full xl:w-32 mt-3 xl:mt-0 align-top">Logout</button>
                    </div>
                    <!-- <div class="intro-x mt-10 xl:mt-24 text-gray-700 dark:text-gray-600 text-center xl:text-left">
                        By signin up, you agree to our <br> <a class="text-theme-1 dark:text-theme-10" href="">Terms and Conditions</a> & <a class="text-theme-1 dark:text-theme-10" href="">Privacy Policy</a>
                    </div> -->
                </div>
            </div>
            <!-- END: Login Form -->
        </div>
    </div>
@endsection

@section('script')
    <script>
        cash(function () {
            async function verifikasi() {
                // Reset state
                cash('#login-form').find('.login__input').removeClass('border-theme-6')
                cash('#login-form').find('.login__input-error').html('')

                // Post form
                let email = cash('#email').val()

                // Loading state
                cash('#btn-verifikasi').html('<i data-loading-icon="oval" data-color="white" class="w-5 h-5 mx-auto"></i>').svgLoader()
                await helper.delay(1500)

                axios.post('{{ route('verification.send') }}').then(res => {
                    Swal.fire(
                        'Berhasil!',
                        'Email berhasil di kirim, mohon cek kotak masuk email anda.',
                        'success'
                    )
                    cash('#btn-verifikasi').html('Verifikasi!');
                }).catch(err => {
                    cash('#btn-login').html('Login')
                    Swal.fire(
                        'Gagal!',
                        'Gagal mengirim Email.',
                        'error'
                    );
                    cash('#btn-verifikasi').html('Verifikasi!');
                })

            }

            cash('#btn-verifikasi').on('click', function() {
                verifikasi()
            })

            cash('#btn-logout').on('click', function() {
                window.location.href = '{{ route("logout") }}';
            })
        })
    </script>
@endsection
