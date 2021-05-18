@extends('../layout/' . $layout)

@section('breadcrumb')
    <a href="{{ route('admin') }}">Dashboard</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i>
    <a href="{{ route('admin.article') }}">Artikel</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i>
    <a href="{{ route('admin.article.edit',$article->id) }}" class="breadcrumb--active">Tambah Artikel</a>
@endsection

@section('subhead')
    <title>Mental Check | Admin Tambah Artikel</title>
@endsection

@section('subcontent')
    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">Tambah Artikel </h2>
    </div>
    <form id="form">
        <div class="pos intro-y grid grid-cols-12 gap-5 mt-5">
            <!-- BEGIN: Post Content -->
            <div class="intro-y col-span-12 lg:col-span-12">
                <input style="display: none" value="{{ $article->id }}">
                <input type="text" class="intro-y form-control py-3 px-4 box pr-10 placeholder-theme-13 judul__input"
                       placeholder="Judul" id="judul" value="{{ $article->title }}">
                <div id="error-judul"
                     class="judul__input-error w-5/6 text-theme-6 mt-2"></div>
                <div class="post intro-y overflow-hidden box mt-5">
                    <div class="post__tabs nav nav-tabs flex-col sm:flex-row bg-gray-300 dark:bg-dark-2 text-gray-600"
                         role="tablist">
                        <a title="Fill in the article content" data-toggle="tab" data-target="#content"
                           href="javascript:;"
                           class="tooltip w-full sm:w-40 py-4 text-center flex justify-center items-center active"
                           id="content-tab" role="tab" aria-controls="content" aria-selected="true">
                            <i data-feather="file-text" class="w-4 h-4 mr-2"></i> Content
                        </a>
                    </div>
                    <div class="post__content tab-content">
                        <div id="content" class="tab-pane p-5 active" role="tabpanel" aria-labelledby="content-tab">
                            <div class="border border-gray-200 dark:border-dark-5 rounded-md p-5">
                                <div
                                    class="font-medium flex items-center border-b border-gray-200 dark:border-dark-5 pb-5">
                                    <i data-feather="chevron-down" class="w-4 h-4 mr-2"></i> Text Konten
                                </div>
                                <div class="mt-5">
                                    <div class="preview">
                                        <textarea  id="deskripsi" class="form-control" rows="10" name="deskripsi">
                                            {{ $article->description }}
                                        </textarea>
                                    </div>
                                    <div id="error-deskripsi"
                                         class="deskripsi__input-error w-5/6 text-theme-6 mt-2"></div>
                                </div>
                            </div>
                            <div class="border border-gray-200 dark:border-dark-5 rounded-md p-5 mt-5">
                                <div
                                    class="font-medium flex items-center border-b border-gray-200 dark:border-dark-5 pb-5">
                                    <i data-feather="chevron-down" class="w-4 h-4 mr-2"></i> Caption & Gambar
                                </div>
                                <div class="mt-5">
                                    <div>
                                        <label class="form-label">Caption</label>
                                        <input id="caption" type="text" class="form-control caption__input" required
                                               placeholder="Write caption" value="{{ $article->caption }}">
                                        <div id="error-caption"
                                             class="caption__input-error w-5/6 text-theme-6 mt-2"></div>
                                    </div>
                                </div>
                                <div class="mt-5">
                                    <label for="Gambar" class="form-label">Gambar</label>
                                    <div id="kv-avatar-errors" class="center-block" style="display:none"></div>
                                    <div class="col-4 text-center">
                                        <div class="kv-avatar">
                                            <div class="file-loading">
                                                <input id="image" name="image" type="file">
                                            </div>
                                        </div>
                                        <div class="kv-avatar-hint">
                                            <small>Select file < 2000 KB</small>
                                        </div>
                                    </div>
                                    <div id="error-gambar" class="gambar__input-error w-5/6 text-theme-6 mt-2"></div>
                                </div>
                                <div class="mt-5">
                                    <div class="mt-2">
                                        <div class="form-check">
                                            <input id="aktif" name="aktif" class="form-check-switch" type="checkbox"
                                                   value="true"
                                                   @if($article->status) checked @endif>
                                            <label class="form-check-label" id="aktif-label"
                                                   for="checkbox-switch-7">@if($article->status) Aktif @else Tidak Aktif @endif</label>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" id="btn-simpan" class="btn btn-primary mt-5">Simpan</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END: Post Content -->
        </div>
    </form>
@endsection

@push('css')
    <link href="{{ asset('assets/vendor/krajee/css/fileinput.css') }}" media="all" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/vendor/krajee/themes/explorer-fas/theme.css') }}" media="all" rel="stylesheet"
          type="text/css"/>
          <link rel="stylesheet" href="{{ asset('assets/vendor/sceditor/development/themes/default.css')}}" />
    <style>
        .kv-avatar .krajee-default.file-preview-frame, .kv-avatar .krajee-default.file-preview-frame:hover {
            margin: 0;
            padding: 0;
            border: none;
            box-shadow: none;
            text-align: center;
        }

        .kv-avatar {
            display: inline-block;
        }

        .kv-avatar .file-input {
            display: table-cell;
            width: 213px;
        }

        .kv-reqd {
            color: red;
            font-family: monospace;
            font-weight: normal;
        }
    </style>
@endpush

@push('js')
    <script src="{{ asset('assets/vendor/krajee/js/plugins/piexif.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendor/krajee/js/plugins/sortable.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendor/krajee/js/fileinput.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendor/krajee/js/locales/id.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendor/krajee/themes/fas/theme.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendor/krajee/themes/explorer-fas/theme.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendor/sceditor/development/sceditor.js') }}"></script>
    <script src="{{ asset('assets/vendor/sceditor/development/formats/bbcode.js') }}"></script>
    <script>
    var textarea = document.getElementById('deskripsi');
        sceditor.create(textarea, {
            format: 'html',
            style: '{{ asset('assets/vendor/sceditor/development/themes/default.css') }}'
        });
        cash(function () {
            async function simpan() {
                // Reset state
                cash('#form').find('.deskripsi__input').removeClass('border-theme-6')
                cash('#form').find('.deskripsi__input-error').html('')
                cash('#form').find('.caption__input').removeClass('border-theme-6')
                cash('#form').find('.caption__input-error').html('')
                cash('#form').find('.judul__input').removeClass('border-theme-6')
                cash('#form').find('.judul__input-error').html('')

                // Post form
                let judul = cash('#judul').val()
                let deskripsi = sceditor.instance(textarea).val();
                let caption = cash('#caption').val()
                let aktif = cash("input[name=aktif]:checked").val()
                var gambar = document.querySelector('#image');

                var formData = new FormData();
                formData.append("_method", 'put');
                formData.append("deskripsi", deskripsi);
                formData.append("caption", caption);
                formData.append("judul", judul);
                formData.append("aktif", aktif);
                if (typeof gambar.files[0] !== 'undefined') {
                    formData.append("gambar", gambar.files[0]);
                }

                // Loading state
                cash('#btn-simpan').html('<i data-loading-icon="oval" data-color="white" class="w-5 h-5 mx-auto"></i>').svgLoader()
                await helper.delay(1500)

                axios.post('{{ route('admin.article.update',$article->id) }}', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }).then(res => {
                    Swal.fire(
                        'Berhasil!',
                        'Artikel berhasil di perbaharui.',
                        'success'
                    ).then(function () {
                        return window.location.href = res.data.redirect
                    });
                }).catch(err => {
                    cash('#btn-simpan').html('Simpan')
                    for (const [key, val] of Object.entries(err.response.data.errors)) {
                        cash(`#${key}`).addClass('border-theme-6')
                        cash(`#error-${key}`).html(val)
                    }
                })
            }

            cash('#btn-simpan').on('click', function () {
                simpan()
            })

            cash('#aktif').on('change', function (event) {
                if (cash(this).is(':checked')) {
                    cash('#aktif-label').text('Aktif');
                } else {
                    cash('#aktif-label').text('Tidak Aktif');
                }
            });

            $("#image").fileinput({
                overwriteInitial: true,
                maxFileSize: 2000,
                showClose: false,
                showCaption: false,
                showBrowse: false,
                browseOnZoneClick: true,
                removeLabel: '',
                language: 'id',
                cancelIcon: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-circle block mx-auto"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>',
                previewFileIcon: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search block mx-auto"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                browseIcon: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search block mx-auto"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                zoomIcon: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search block mx-auto"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                removeIcon: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x block mx-auto"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>',
                removeTitle: 'Cancel or reset changes',
                elErrorContainer: '#kv-avatar-errors',
                msgErrorClass: 'alert alert-block alert-danger',
                defaultPreviewContent: '<img src="{{ $article->image }}" alt="Avatar"><h6 class="text-muted">Klik untuk mengganti</h6>',
                layoutTemplates: {main2: '{preview}  {remove} {browse}'},
                allowedFileExtensions: ["jpg", "png", "gif"]
            });
        })
    </script>
@endpush


