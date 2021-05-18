@extends('../layout/' . $layout)

@section('breadcrumb')
    <a href="{{ route('admin') }}">Dashboard</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i>
    <a href="{{ route('admin.user') }}">User</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i>
    <a href="{{ route('admin.user.create') }}" class="breadcrumb--active">Tambah User</a>
@endsection

@section('subhead')
    <title>Mental Check | Admin Tambah User</title>
@endsection

@section('subcontent')
    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">Tambah User</h2>
    </div>
    <!-- BEGIN: HTML Table Data -->
    <div class="intro-y box p-5 mt-5">
        <div id="vertical-form" class="p-5">
            <form id="form">
                <div class="mt-3">
                    <label class="form-label">Nama</label>
                    <input id="nama" required type="text" class="form-control nama__input"
                           placeholder="Nama">
                    <div id="error-nama" class="nama__input-error w-5/6 text-theme-6 mt-2"></div>
                </div>
                <div class="mt-3">
                    <label class="form-label">Email</label>
                    <input id="email" required type="text" class="form-control email__input"
                           placeholder="Email">
                    <div id="error-email" class="email__input-error w-5/6 text-theme-6 mt-2"></div>
                </div>
                <div class="mt-3">
                    <label class="form-label">Password</label>
                    <input id="password" required type="password" class="form-control password__input"
                           placeholder="">
                    <div id="error-password" class="password__input-error w-5/6 text-theme-6 mt-2"></div>
                </div>
                <div class="mt-3">
                    <label class="form-label">Konfirmasi Password</label>
                    <input id="password_confirmation" required type="password" class="form-control password_confirmation__input"
                           placeholder="">
                    <div id="error-password_confirmation" class="password_confirmation__input-error w-5/6 text-theme-6 mt-2"></div>
                </div>
                <div class="mt-3">
                    <label class="form-label">No Telepon</label>
                    <input id="no_telepon" type="text" class="form-control no_telepon__input"
                           placeholder="+62 821038xxx">
                    <div id="error-no_telepon" class="no_telepon__input-error w-5/6 text-theme-6 mt-2"></div>
                </div>
                <div class="mt-3">
                    <label class="form-label">Alamat</label>
                    <textarea id="alamat" type="text" class="form-control alamat__input"
                              placeholder="Alamat"></textarea>
                    <div id="error-alamat" class="alamat__input-error w-5/6 text-theme-6 mt-2"></div>
                </div>
                <div class="mt-3">
                    <label>Role</label>
                    <div class="flex flex-col sm:flex-row mt-2">
                        <div class="form-check mr-2">
                            <input id="member" class="form-check-input role__input" type="radio"
                                   name="admin" value="false" checked>
                            <label class="form-check-label" for="radio-switch-4">Member</label>
                        </div>
                        <div class="form-check mr-2 mt-2 sm:mt-0">
                            <input id="admin" class="form-check-input role__input" type="radio"
                                   name="admin" value="true">
                            <label class="form-check-label" for="radio-switch-5">Admin</label>
                        </div>
                    </div>
                    <div id="error-role" class="role__input-error w-5/6 text-theme-6 mt-2"></div>
                </div>
                <div class="mt-3">
                    <div id="kv-avatar-errors" class="center-block" style="display:none"></div>
                    <div class="col-4 text-center">
                        <div class="kv-avatar">
                            <div class="file-loading">
                                <input id="avatar" name="avatar-2" type="file">
                            </div>
                        </div>
                        <div class="kv-avatar-hint">
                            <small>Select file < 1500 KB</small>
                        </div>
                    </div>
                    <div id="error-avatar" class="role__input-error w-5/6 text-theme-6 mt-2"></div>
                </div>
                <button type="button" id="btn-simpan" class="btn btn-primary mt-5">Simpan</button>
            </form>
        </div>
    </div>
@endsection

@push('css')
    <link href="{{ asset('assets/vendor/krajee/css/fileinput.css') }}" media="all" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/vendor/krajee/themes/explorer-fas/theme.css') }}" media="all" rel="stylesheet" type="text/css"/>
    <style>
        .kv-avatar .krajee-default.file-preview-frame,.kv-avatar .krajee-default.file-preview-frame:hover {
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
                cash('#form').find('.email__input').removeClass('border-theme-6')
                cash('#form').find('.email__input-error').html('')
                cash('#form').find('.phone__input').removeClass('border-theme-6')
                cash('#form').find('.phone__input-error').html('')
                cash('#form').find('.alamat__input').removeClass('border-theme-6')
                cash('#form').find('.alamt__input-error').html('')
                cash('#form').find('.password__input').removeClass('border-theme-6')
                cash('#form').find('.password__input-error').html('')
                cash('#form').find('.password_confirmation__input').removeClass('border-theme-6')
                cash('#form').find('.password_confirmation__input-error').html('')

                // Post form
                let nama = cash('#nama').val()
                let email = cash('#email').val()
                let password = cash('#password').val()
                let password_confirmation = cash('#password_confirmation').val()
                let phone = cash('#no_telepon').val()
                let alamat =  cash('#alamat').val()
                let admin = cash("input[name=admin]:checked").val()
                var picture = document.querySelector('#avatar');

                var formData = new FormData();
                formData.append("nama", nama);
                formData.append("email", email);
                formData.append("no_telepon", phone);
                formData.append("password", password);
                formData.append("password_confirmation", password_confirmation);
                formData.append("alamat", alamat);
                formData.append("role", admin);
                if (typeof picture.files[0] !== 'undefined'){
                    formData.append("avatar", picture.files[0]);
                }

                // Loading state
                cash('#btn-simpan').html('<i data-loading-icon="oval" data-color="white" class="w-5 h-5 mx-auto"></i>').svgLoader()
                await helper.delay(1500)

                axios.post('{{ route('admin.user.store') }}', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }).then(res => {
                    Swal.fire(
                        'Berhasil!',
                        'User berhasil di tambahkan.',
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
        })
    </script>
    <script>
        $("#avatar").fileinput({
            overwriteInitial: true,
            maxFileSize: 2000,
            showClose: false,
            showCaption: false,
            showBrowse: false,
            browseOnZoneClick: true,
            removeLabel: '',
            language: 'id',
            cancelIcon : '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-circle block mx-auto"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>',
            previewFileIcon : '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search block mx-auto"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
            browseIcon : '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search block mx-auto"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
            zoomIcon : '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search block mx-auto"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
            removeIcon: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x block mx-auto"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>',
            removeTitle: 'Cancel or reset changes',
            elErrorContainer: '#kv-avatar-errors',
            msgErrorClass: 'alert alert-block alert-danger',
            defaultPreviewContent: '<img src="{{ asset('assets/img/user.png') }}" alt="Avatar"><h6 class="text-muted">Klik untuk mengganti</h6>',
            layoutTemplates: {main2: '{preview}  {remove} {browse}'},
            allowedFileExtensions: ["jpg", "png", "gif"]
        });
    </script>
@endpush


