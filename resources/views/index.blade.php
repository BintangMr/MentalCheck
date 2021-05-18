@extends('layout.member')
@section('content')
    <main id="main">
        <section id="hero" class="d-flex align-items-center">

            <div class="container">
                <div class="row">
                    <div class="col-lg-6 pt-5 pt-lg-0 order-2 order-lg-1 d-flex flex-column justify-content-center">
                        <h1 data-aos="fade-up">Selamat Datang di</h1>
                        <h1 data-aos="fade-up">Mental Check Website</h1>
                        <h2 data-aos="fade-up" data-aos-delay="400">Memudahkan untuk mengetahui tingkat kesehatan mental
                            anda</h2>
                        <div data-aos="fade-up" data-aos-delay="800">
                            @if(Auth::check())
                                <a href="#check" class="btn-get-started scrollto">MULAI SEKARANG</a>
                            @else
                                <a href="{{ route('login-view') }}" class="btn-get-started scrollto">MASUK SEKARANG</a>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-4 order-1 order-lg-2 hero-img" data-aos="fade-left" data-aos-delay="200">
                        <img src="assets/img/hero.png" class="img-fluid animated" alt="">
                    </div>
                </div>
            </div>

        </section><!-- End Hero -->


        <!-- ======= Clients Section ======= -->
        <section id="clients" class="clients clients">
            <div class="container">
                <div class="p-3 mb-2 bg-gradient-secondary text-white"></div>

                <div class="row">

                    <div class="col-lg-2 col-md-4 col-6">
                    </div>

                    <div class="col-lg-2 col-md-4 col-6">
                    </div>

                    <div class="col-lg-2 col-md-4 col-6">
                    </div>

                    <div class="col-lg-2 col-md-4 col-6">
                    </div>

                    <div class="col-lg-2 col-md-4 col-6">
                    </div>

                    <div class="col-lg-2 col-md-4 col-6">

                    </div>

                </div>

            </div>
        </section><!-- End Clients Section -->

        <!-- ======= About Us Section ======= -->
        <section id="about" class="about">
            <div class="container">

                <div class="section-title" data-aos="fade-up">
                    <h2>Tentang</h2>
                </div>

                <div class="row content">
                    <div class="col-lg-6" data-aos="fade-up" data-aos-delay="150">
                        <h2>Mental Check</h2>
                        <p>
                            Adalah sebuah website untuk mengukur atau sekedar untuk mengetahui tingkat kesehatan mental
                            seseorang. Apakah buruk atau baik. Hal ini dilihat dari hasil jawaban yang telah diinputkan
                            ke
                            sistem
                        </p>
                        <ul>
                            <li><i class="ri-check-double-line"></i> Pilihan test lebih dari satu</li>
                            <li><i class="ri-check-double-line"></i>Tersedia kontak ahli jika tak ada jalan keluar</li>
                            <li><i class="ri-check-double-line"></i> Hasil tes yang spesifik</li>
                        </ul>
                    </div>
                    <div class="col-lg-6 pt-4 pt-lg-0" data-aos="fade-up" data-aos-delay="300">
                        <h2>Tujuan</h2>
                        <p>
                            Dibuat untuk mengukur atau sekedar mengetahui kesehatan mental seseorang. Hal ini bisa
                            menjadi
                            alat untuk mempermudah tes mental tanpa perlu pergi ke psikiater
                        </p>
                    </div>
                </div>

            </div>
        </section><!-- End About Us Section -->

        <!--MentalCheck-->
        <section id="check" class="services">
            <div class="container">

                <div class="section-title" data-aos="fade-up">
                    <h2>Mental Check</h2>
                    <p>Ada beberapa pengertian tentang mental dan mungkin saja Anda mengalami dari beberapa berikut
                        ini.</p>
                    <p>Anda juga bisa melakukan tes.</p>
                </div>

                <div class="row">
                    @foreach($categories as $category)
                        <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-3">
                            <div class="icon-box" data-aos="fade-up" data-aos-delay="100">
                                <div class="icon text-white pt-2" style="font-size: 25px"><i
                                        data-feather="{{$category->icon}}" class="block mx-auto my-auto"></i></div>
                                <h4 class="title"><a href="">{{ $category->category }}</a></h4>
                                <p class="description">
                                    @if(strlen($category->description) > 200)
                                        {{substr($category->description, 0, 200)}}<span id="remove-{{$category->id}}">...</span>
                                        <span id="add-{{ $category->id }}" style="display: none">{{substr($category->description, 200, strlen($category->description))}}
                                        </span>
                                <div class="mx-auto mt-2">
                                    <button onclick="readMore(this)" class="btn btn-primary"
                                            data-add="add-{{ $category->id }}" data-remove="remove-{{$category->id}}">Read More</button>
                                </div>
                                @else
                                {{ $category->description }}
                                @endif
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </section>
        <!--End Mental  Check-->

        <!--Masih mental check-->
        <section id="more-services" class="more-services">
            <div class="container">
                @if(!Auth::check())
                    <div class="section-title" data-aos="fade-up">
                        <h2>TES</h2>
                        <p>Pastikan anda telah login untuk melakukan tes di bawah ini</p>
                    </div>
                @endif
                <div class="row">
                    @foreach($categories as $category)
                        <div class="col-md-6 d-flex align-items-stretch mb-3">
                            <div class="card" style='background-image: url("{{ $category->image }}");'
                                 data-aos="fade-up"
                                 data-aos-delay="100">
                                <div class="card-body">
                                    <h5 class="card-title"><a href="">{{ $category->category }}</a></h5>
                                    <p class="card-text"> 
                                    @if(strlen($category->description) > 200)
                                        {{substr($category->description, 0, 200)}}<span id="remove2-{{$category->id}}">...</span>
                                        <span id="add2-{{ $category->id }}" style="display: none">{{substr($category->description, 200, strlen($category->description))}}
                                        </span>
                                <div class="mx-auto mt-2">
                                    <button onclick="readMore(this)" class="btn btn-primary"
                                            data-add="add2-{{ $category->id }}" data-remove="remove2-{{$category->id}}">Read More</button>
                                </div>
                                @else
                                {{ $category->description }}
                                @endif </p>
                                    @if(Auth::check())
                                        <div class="read-more"><a href="{{ route('member.test.start',$category->id) }}"><i
                                                    class="header-Depresi"></i> Mulai
                                                Tes</a></div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </section>
        <!--End masih mental check-->

        <!-- ======= Team Section ======= -->
        <section id="team" class="team section-bg">
            <div class="container">

                <div class="section-title" data-aos="fade-up">
                    <h2>Team</h2>
                    <p>Team Program Mental Check Satu Katapang</p>
                </div>

                <div class="row">
                    @foreach($teams as $team)
                        <div class="col-lg-3 col-md-6 d-flex align-items-stretch">
                            <div class="member" data-aos="fade-up" data-aos-delay="100">
                                <div class="member-img">
                                    <img src="{{ $team->image }}" class="img-fluid" alt="">
                                    <div class="social">
                                        @if($team->instagram)
                                            <a href="{{$team->instagram}}"><i
                                                    class="bi bi-instagram"></i></a>
                                        @endif
                                        @if($team->facebook)
                                            <a href="{{$team->facebook}}"><i
                                                    class="bi bi-facebook"></i></a>
                                        @endif
                                        @if($team->twitter)
                                            <a href="{{$team->twitter}}"><i
                                                    class="bi bi-twitter"></i></a>
                                        @endif
                                        @if($team->whatsapp)
                                            <a href="{{$team->whatsapp}}" class="Whatsapp"><i
                                                    class="bi bi-whatsapp"></i></a>
                                        @endif
                                    </div>
                                </div>
                                <div class="member-info">
                                    <h4>{{$team->name}}</h4>
                                    <span>{{$team->role}}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </section>
        <!-- End Team Section -->

        <!-- ======= Artikel Section ======= -->
        <section id="article" class="team section-bg">
            <div class="container">

                <div class="section-title" data-aos="fade-up">
                    <h2>Artikel</h2>
                </div>

                <div class="row">
                    @foreach($articles as $article)
                        <div class="col-lg-3 col-md-6 d-flex align-items-stretch">
                            <div class="card" style="width: 18rem;">
                                <img class="card-img-top" src="{{ $article->image }}" alt="Card image cap">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $article->title }}</h5>
                                    <p class="card-text">{{ $article->caption }}</p>
                                    <a href="{{ route('article.detail',$article->id) }}"
                                       class="btn btn-primary">Baca</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </section>

        <!--kontak-->
        <section id="contact" class="contact">
            <div class="container">

                <div class="section-title" data-aos="fade-up">
                    <h2>Kontak</h2>
                </div>

                <div class="row">

                    <div class="col-lg-6 col-md-6 mt-4 mt-md-0" data-aos="fade-up" data-aos-delay="200">
                        <div class="info">
                            <h3>Alamat</h3>
                            <div>
                                <i class="ri-map-pin-line"></i>
                                <p>{{ $contact ? $contact->address : '' }}
                                </p>
                            </div>

                            <div>
                                <i class="ri-phone-line"></i>
                                <p>{{ $contact ? $contact->phone : '' }}</p>
                            </div>

                        </div>
                    </div>

                    <div class="col-lg-6 col-md-12" data-aos="fade-up" data-aos-delay="300">
                        <h5 class="text-center">Kritik dan Saran</h5>
                        <form action="{{ route('email.feedback') }}" method="post" role="form" class="php-email-form">
                            @csrf
                            <div class="form-group">
                                <input type="text" name="nama" class="form-control" id="name" placeholder="Nama anda"
                                       required>
                            </div>
                            <div class="form-group">
                                <input type="email" class="form-control" name="email" id="email"
                                       placeholder="Email anda"
                                       required>
                            </div>
                            <div class="form-group">
                            <textarea class="form-control" name="pesan" rows="5" placeholder="Pesan"
                                      required></textarea>
                            </div>
                            <div class="my-3">
                                <div class="loading">Loading</div>
                                <div class="error-message"></div>
                                <div class="sent-message">Pesan anda telah terkirim. Terimakasih!</div>
                            </div>
                            <div class="text-center">
                                <button type="submit">Kirim</button>
                            </div>
                        </form>
                    </div>

                </div>

            </div>
        </section>
        <!--akhir kontak-->
    </main>

@endsection

@push('js')
    <script>
        function readMore(e) {
            var elem = $(e).text();
            if (elem == "Read More") {
                //Stuff to do when btn is in the read more state
                $(e).text("Read Less");
                $("#" + $(e).data('add')).slideDown();
                $("#" + $(e).data('remove')).hide();
            } else {
                //Stuff to do when btn is in the read less state
                $(e).text("Read More");
                $("#" + $(e).data('add')).slideUp();
                $("#" + $(e).data('remove')).show();
            }
        }
    </script>
@endpush
