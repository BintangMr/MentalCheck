@extends('../layout/' . $layout)

@section('breadcrumb')
    <a href="{{ route('admin') }}">Dashboard</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i>
    <a href="{{ route('admin.teams') }}">Teams</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i>
    <a href="{{ route('admin.teams.create') }}" class="breadcrumb--active">Tambah Team</a>
@endsection

@section('subhead')
    <title>Mental Check | Admin Tambah Team</title>
@endsection

@section('subcontent')
    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">Tambah Team</h2>
    </div>
    <!-- BEGIN: HTML Table Data -->
    <div class="intro-y box p-5 mt-5">
        <div id="vertical-form" class="p-5">
            <form id="form">
                <div>
                    <label for="nama" class="form-label">Nama</label>
                    <input id="nama" required type="text" class="form-control nama__input"
                           placeholder="Nama">
                    <div id="error-nama" class="nama__input-error w-5/6 text-theme-6 mt-2"></div>
                </div>
                <div>
                    <label for="role" class="form-label">Role</label>
                    <input id="role" required type="text" class="form-control role__input"
                           placeholder="Role">
                    <div id="error-role" class="role__input-error w-5/6 text-theme-6 mt-2"></div>
                </div>
                <div>
                    <label for="instagram" class="form-label">Link Instagram</label>
                    <input id="instagram" required type="text" class="form-control instagram__input"
                           placeholder="Instagram">
                    <div id="error-instagram" class="instagram__input-error w-5/6 text-theme-6 mt-2"></div>
                </div>
                <div>
                    <label for="facebook" class="form-label">Link Facebook</label>
                    <input id="facebook" required type="text" class="form-control facebook__input"
                           placeholder="Facebook">
                    <div id="error-facebook" class="facebook__input-error w-5/6 text-theme-6 mt-2"></div>
                </div>
                <div>
                    <label for="twitter" class="form-label">Link Twitter</label>
                    <input id="twitter" required type="text" class="form-control twitter__input"
                           placeholder="Twiiter">
                    <div id="error-twitter" class="twitter__input-error w-5/6 text-theme-6 mt-2"></div>
                </div>
                <div>
                    <label for="whatsapp" class="form-label">Link Whatsapp</label>
                    <input id="whatsapp" required type="text" class="form-control whatsapp__input"
                           placeholder="Whatsapp">
                    <div id="error-whatsapp" class="whatsapp__input-error w-5/6 text-theme-6 mt-2"></div>
                </div>
                <div class="mt-3">
                    <div class="mt-2">
                        <div class="form-check">
                            <input id="aktif" name="aktif" class="form-check-switch" type="checkbox" value="true"
                                   checked>
                            <label class="form-check-label" id="aktif-label" for="checkbox-switch-7">Aktif</label>
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    <label for="Gambar" class="form-label">Image</label>
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
                    <div id="error-image" class="image__input-error w-5/6 text-theme-6 mt-2"></div>
                </div>
                <button type="button" id="btn-simpan" class="btn btn-primary mt-5">Simpan</button>
            </form>
        </div>
    </div>
@endsection

@push('css')
    <link href="{{ asset('assets/vendor/krajee/css/fileinput.css') }}" media="all" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/vendor/krajee/themes/explorer-fas/theme.css') }}" media="all" rel="stylesheet"
          type="text/css"/>
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
    <script>
        cash(function () {
            async function simpan() {
                // Reset state
                cash('#form').find('.nama__input').removeClass('border-theme-6')
                cash('#form').find('.nama__input-error').html('')
                cash('#form').find('.role__input').removeClass('border-theme-6')
                cash('#form').find('.role__input-error').html('')
                cash('#form').find('.instagram__input').removeClass('border-theme-6')
                cash('#form').find('.instagram__input-error').html('')
                cash('#form').find('.facebook__input').removeClass('border-theme-6')
                cash('#form').find('.facebook__input-error').html('')
                cash('#form').find('.whatsapp__input').removeClass('border-theme-6')
                cash('#form').find('.whatsapp__input-error').html('')
                cash('#form').find('.twitter__input').removeClass('border-theme-6')
                cash('#form').find('.twitter__input-error').html('')
                cash('#form').find('.image__input').removeClass('border-theme-6')
                cash('#form').find('.image__input-error').html('')

                // Post form
                let name = cash('#nama').val()
                let role = cash('#role').val()
                let instagram = cash('#instagram').val()
                let facebook = cash('#facebook').val()
                let twitter = cash('#twitter').val()
                let whatsapp = cash('#whatsapp').val()
                let aktif = cash("input[name=aktif]:checked").val()
                var background = document.querySelector('#image');

                var formData = new FormData();
                formData.append("nama", name);
                formData.append("role", role);
                formData.append("instagram", instagram);
                formData.append("facebook", facebook);
                formData.append("twitter", twitter);
                formData.append("whatsapp", whatsapp);
                formData.append("aktif", aktif);
                if (typeof background.files[0] !== 'undefined'){
                    formData.append("image", background.files[0]);
                }

                // Loading state
                cash('#btn-simpan').html('<i data-loading-icon="oval" data-color="white" class="w-5 h-5 mx-auto"></i>').svgLoader()
                await helper.delay(1500)

                axios.post('{{ route('admin.teams.store') }}', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }).then(res => {
                    Swal.fire(
                        'Berhasil!',
                        'Teams berhasil di tambahkan.',
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
                defaultPreviewContent: '<img src="{{ asset('assets/img/new-services-1.jpg') }}" alt="Avatar"><h6 class="text-muted">Klik untuk mengganti</h6>',
                layoutTemplates: {main2: '{preview}  {remove} {browse}'},
                allowedFileExtensions: ["jpg", "png", "gif"]
            });
        })
    </script>
@endpush


