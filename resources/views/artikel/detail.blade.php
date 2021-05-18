@extends('layout.member')
@push('css')
    <style>
        .btn-facebook {
            color: #fff;
            background-color: #4C67A1;
        }
        .btn-facebook:hover {
            color: #fff;
            background-color: #405D9B;
        }
        .btn-facebook:focus {
            color: #fff;
        }

        .btn-twitter {
            color: #fff;
            background-color: #1DA1F2;
        }
        .btn-twitter:hover {
            color: #fff;
            background-color: #27a2f3;
        }
        .btn-twitter:focus {
            color: #fff;
        }
    </style>
@endpush

@section('content')
    <main id="main" class="mt-5">
        <section id="article" class="about" class="mt-5">
            <div class="container">

                <div class="section-title" data-aos="fade-up">
                    <h2>{{ $article->title }}</h2>
                </div>

                <div class="row content">
                    <div class="card text-center">
                        <div class="card-header">
                            <img src="{{ $article->image }}" class="img-fluid" width="500">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">{{ $article->caption }}</h5>
                            <p class="card-text">{!! $article->description !!}</p>
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ route('article.detail',$article->id) }}" target="_blank" onclick="window.open(this.href,'targetWindow','toolbar=no,location=0,status=no,menubar=no,scrollbars=yes,resizable=yes,width=600,height=250'); return false"><button style="width:100%; margin-top:10px;" type="button" class="btn btn-facebook btn-lg"><i class="bi bi-facebook"></i> Share on Facebook</button></a>
                            <a href="https://twitter.com/share?url={{ route('article.detail',$article->id) }}" target="_blank" onclick="window.open(this.href,'targetWindow','toolbar=no,location=0,status=no,menubar=no,scrollbars=yes,resizable=yes,width=600,height=250'); return false"><button style="width:100%; margin-top:10px;" type="button" class="btn btn-twitter btn-lg"><i class="bi bi-twitter"></i> Share on Twitter</button></a>
                        </div>
                    </div>
                </div>

            </div>
        </section><!-- End About Us Section -->

    </main>
@endsection

@push('js')
<script>

    });
</script>
@endpush
