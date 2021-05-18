@extends('../layout/' . $layout)

@section('breadcrumb')
    <a href="{{ route('admin') }}">Dashboard</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i>
    <a href="{{ route('admin.article') }}">Artikel</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i>
    <a href="{{ route('admin.article.detail',$article->id) }}" class="breadcrumb--active">Detail Artikel</a>
@endsection

@section('subhead')
    <title>Mental Check | Admin Detail Artikel</title>
@endsection

@section('subcontent')
    <div class="intro-y news  p-5 box mt-8">
        <!-- BEGIN: Blog Layout -->
        <h2 class="intro-y font-medium text-xl sm:text-2xl">{{ $article->title }}</h2>
        <div class="intro-y text-gray-700 dark:text-gray-600 mt-3 text-xs sm:text-sm">
            {{ \Carbon\Carbon::parse($article->created_at)->format('d M, Y')  }}
        </div>
        <div class="intro-y mt-6">
            <div class="news__preview image-fit">
                <img alt="Rubick Tailwind HTML Admin Template" class="rounded-md" src="{{ $article->image }}">
            </div>
        </div>
        <div class="intro-y flex relative pt-16 sm:pt-6 items-center pb-6">

        </div>
        <div class="intro-y text-justify leading-relaxed">
            {!! $article->description !!}
        </div>
        <div class="intro-y flex text-xs sm:text-sm flex-col sm:flex-row items-center mt-5 pt-5 border-t border-gray-200 dark:border-dark-5">
            <div class="flex items-center text-gray-700 dark:text-gray-600 sm:ml-auto mt-5 sm:mt-0">
                Sebarkan Artikel Ini:
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ route('article.detail',$article->id) }}" onclick="window.open(this.href,'targetWindow','toolbar=no,location=0,status=no,menubar=no,scrollbars=yes,resizable=yes,width=600,height=250'); return false" target="_blank" class="w-8 h-8 sm:w-10 sm:h-10 rounded-full flex items-center justify-center border dark:border-dark-5 ml-2 text-gray-500 zoom-in tooltip" title="Facebook">
                    <i class="w-3 h-3 fill-current" data-feather="facebook"></i>
                </a>
                <a href="https://twitter.com/share?url={{ route('article.detail',$article->id) }}" onclick="window.open(this.href,'targetWindow','toolbar=no,location=0,status=no,menubar=no,scrollbars=yes,resizable=yes,width=600,height=250'); return false" target="_blank" class="w-8 h-8 sm:w-10 sm:h-10 rounded-full flex items-center justify-center border dark:border-dark-5 ml-2 text-gray-500 zoom-in tooltip" title="Twitter">
                    <i class="w-3 h-3 fill-current" data-feather="twitter"></i>
                </a>
            </div>
        </div>
        <!-- END: Blog Layout -->
        </div>
        <!-- END: Comments -->
    </div>
@endsection

@push('css')

@endpush

@push('js')

@endpush


