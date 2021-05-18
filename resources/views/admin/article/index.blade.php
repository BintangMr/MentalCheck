@extends('../layout/' . $layout)

@section('breadcrumb')
    <a href="{{ route('admin') }}">Dashboard</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i>
    <a href="{{ route('admin.article') }}" class="breadcrumb--active">Artikel</a>
@endsection

@section('subhead')
    <title>Mental Check | Admin Artikel</title>
@endsection

@section('subcontent')
    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">Artikel</h2>
        <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
            <a href="{{ route('admin.article.create') }}" class="btn btn-primary shadow-md mr-2">Tambah Artikel</a>
        </div>
    </div>
    <div class="intro-y grid grid-cols-12 gap-6 mt-5">
        <!-- BEGIN: Blog Layout -->
        @foreach ($article as $data)
            <div class="intro-y blog col-span-12 md:col-span-6 box">
                <div class="blog__preview image-fit">
                    <img alt="" class="rounded-t-md"
                         src="{{ $data->image  }}">
                    <div class="absolute w-full flex items-center px-5 pt-6 z-10">
                        <div class="w-10 h-10 flex-none image-fit">
                            <img alt="Rubick Tailwind HTML Admin Template" class="rounded-full"
                                 src="{{ asset('assets/img/user.png') }}">
                        </div>
                        <div class="ml-3 text-white mr-auto">
                            <a href="" class="font-medium">Admin</a>
                            <div class="text-xs mt-0.5">{{ \Carbon\Carbon::parse($data->created_at)->format('d M, Y')  }}</div>
                        </div>
                        <div class="dropdown ml-3">
                            <a href="javascript:;"
                               class="blog__action dropdown-toggle w-8 h-8 flex items-center justify-center rounded-full"
                               aria-expanded="false">
                                <i data-feather="more-vertical" class="w-4 h-4 text-white"></i>
                            </a>
                            <div class="dropdown-menu w-40">
                                <div class="dropdown-menu__content box dark:bg-dark-1 p-2">
                                    <a href="{{ route('admin.article.edit',$data->id) }}"
                                       class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">
                                        <i data-feather="edit-2" class="w-4 h-4 mr-2"></i> Edit Artikel
                                    </a>
                                    <a href="javascript:;" onclick="hapusArtikel({{$data->id}})"
                                       class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">
                                        <i data-feather="trash" class="w-4 h-4 mr-2"></i> Hapus Artikel
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="absolute bottom-0 text-white px-5 pb-6 z-10">
                        <a href="{{ route('admin.article.detail',$data->id) }}" class="block font-medium text-xl mt-3">{{ $data->title }}</a>
                    </div>
                </div>
                <div class="p-5 text-gray-700 dark:text-gray-600">{{ $data->caption }}</div>
                <div class="flex items-center px-5 py-3 border-t border-gray-200 dark:border-dark-5">
                    <div class="flex items-center text-gray-700 dark:text-gray-600 sm:ml-auto mt-5 sm:mt-0">
                        Sebarkan Artikel Ini:
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ route('article.detail',$data->id) }}" onclick="window.open(this.href,'targetWindow','toolbar=no,location=0,status=no,menubar=no,scrollbars=yes,resizable=yes,width=600,height=250'); return false" target="_blank" class="w-8 h-8 sm:w-10 sm:h-10 rounded-full flex items-center justify-center border dark:border-dark-5 ml-2 text-gray-500 zoom-in tooltip" title="Facebook">
                            <i class="w-3 h-3 fill-current" data-feather="facebook"></i>
                        </a>
                        <a href="https://twitter.com/share?url={{ route('article.detail',$data->id) }}" onclick="window.open(this.href,'targetWindow','toolbar=no,location=0,status=no,menubar=no,scrollbars=yes,resizable=yes,width=600,height=250'); return false" target="_blank" class="w-8 h-8 sm:w-10 sm:h-10 rounded-full flex items-center justify-center border dark:border-dark-5 ml-2 text-gray-500 zoom-in tooltip" title="Twitter">
                            <i class="w-3 h-3 fill-current" data-feather="twitter"></i>
                        </a>
                    </div>
                </div>
            </div>
    @endforeach
    <!-- END: Blog Layout -->
        <!-- BEGIN: Pagiantion -->
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-row sm:flex-nowrap items-center">
            <?php
            // config
            $link_limit = 7; // maximum number of links (a little bit inaccurate, but will be ok for now)
            ?>
            @if ($article->lastPage() > 1)
                <ul class="pagination">
                    <li class="{{ ($article->currentPage() == 1) ? ' disabled' : '' }}">
                        <a href="{{ $article->url(1) }}" class="pagination__link" ><i class="w-4 h-4" data-feather="chevrons-left"></i></a>
                    </li>
                    @for ($i = 1; $i <= $article->lastPage(); $i++)
                        <?php
                        $half_total_links = floor($link_limit / 2);
                        $from = $article->currentPage() - $half_total_links;
                        $to = $article->currentPage() + $half_total_links;
                        if ($article->currentPage() < $half_total_links) {
                            $to += $half_total_links - $article->currentPage();
                        }
                        if ($article->lastPage() - $article->currentPage() < $half_total_links) {
                            $from -= $half_total_links - ($article->lastPage() - $article->currentPage()) - 1;
                        }
                        ?>
                        @if ($from < $i && $i < $to)
                            <li class="{{ ($article->currentPage() == $i) ? ' disabled' : '' }}">
                                <a class="pagination__link {{ ($article->currentPage() == $i) ? ' pagination__link--active' : '' }}" href="{{ $article->url($i) }}">{{ $i }}</a>
                            </li>
                        @endif
                    @endfor
                    <li class="{{ ($article->currentPage() == $article->lastPage()) ? ' disabled' : '' }}">
                        <a class="pagination__link" href="{{ $article->url($article->lastPage()) }}"><i class="w-4 h-4" data-feather="chevrons-right"></i></a>
                    </li>
                </ul>
            @endif
        </div>
        <!-- END: Pagiantion -->
    </div>
@endsection

@push('css')
    <style>
        a.disabled {
            pointer-events: none;
            cursor: default;
        }
        li.disabled {
            pointer-events:none;
            opacity:0.6;
            cursor: default;
        }
    </style>
@endpush

@push('js')
    <script>
        function hapusArtikel(id){
            Swal.fire({
                title: 'Apa anda yakin?',
                text: "Anda akan menghapus data artikel!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Tidak, batalkan!',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete('{{ route('admin.article.delete','') }}/'+id, {
                        params: {
                            'id': id
                        }
                    })
                        .then((response) => {
                            Swal.fire(
                                'Dihapus!',
                                'artikel berhasil di hapus.',
                                'success'
                            )
                            location.reload();
                        })
                        .catch((error) => {
                            Swal.fire(
                                'Error!',
                                error.message,
                                'error'
                            )
                        })

                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    Swal.fire(
                        'Dibatalkan!',
                        'Anda membatalkan penghapusan artikel',
                        'error'
                    )
                }
            })
        }
    </script>
@endpush


