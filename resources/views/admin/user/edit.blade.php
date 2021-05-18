@extends('../layout/' . $layout)

@section('breadcrumb')
    <a href="{{ route('admin') }}">Dashboard</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i>
    <a href="{{ route('admin.user') }}">User</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i>
    <a href="{{ route('admin.user.edit',$user->id) }}" class="breadcrumb--active">Edit User</a>
@endsection

@section('subhead')
    <title>Mental Check | Edit Profile</title>
@endsection

@section('subcontent')
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">Update Profile</h2>
    </div>
    <div class="grid grid-cols-12 gap-6">
        <!-- BEGIN: Profile Menu -->
        <div class="col-span-12 lg:col-span-4 xxl:col-span-3 flex lg:block flex-col-reverse">
            <div class="intro-y box mt-5">
                <div class="relative flex items-center p-5">
                    <div class="w-12 h-12 image-fit">
                        <img alt="Rubick Tailwind HTML Admin Template" class="rounded-full" src="{{  $user->avatar }}">
                    </div>
                    <div class="ml-4 mr-auto">
                        <div class="font-medium text-base">{{ $user->name }}</div>
                        <div class="text-gray-600">{{ $user->admin ? 'Admin' : 'Member' }}</div>
                    </div>
                </div>
                <div class="p-5 border-t border-gray-200 dark:border-dark-5">
                    <a class="flex items-center text-theme-1 dark:text-theme-10 font-medium" href="#" id="btnIdentitas">
                        <i data-feather="activity" class="w-4 h-4 mr-2"></i> Identitas
                    </a>
                    <a class="flex items-center mt-5" href="#" id="btnPassword">
                        <i data-feather="lock" class="w-4 h-4 mr-2"></i> Rubah Password
                    </a>
                </div>
                <div class="p-5 border-t border-gray-200 dark:border-dark-5 flex">
                    <button type="button" class="btn btn-primary py-1 px-2">Non Aktifkan User</button>
                    <button type="button" class="btn btn-danger py-1 px-2 ml-auto">Hapus User</button>
                </div>
            </div>
        </div>
        <!-- END: Profile Menu -->
        <div class="col-span-12 lg:col-span-8 xxl:col-span-9">
            <!-- BEGIN: Display Information -->
            <div class="intro-y box lg:mt-5" id="identitasForm">
                <div class="flex items-center p-5 border-b border-gray-200 dark:border-dark-5">
                    <h2 class="font-medium text-base mr-auto">Identitas</h2>
                </div>
                <div class="p-5">
                    <div class="flex flex-col-reverse xl:flex-row flex-col">
                        <div class="flex-1 mt-6 xl:mt-0">
                            <div class="grid grid-cols-12 gap-x-5">
                                <div class="col-span-12 xxl:col-span-6">
                                    <div>
                                        <label class="form-label">Nama</label>
                                        <input id="nama" type="text" class="form-control nama__input" placeholder="Input text" value="{{ $user->name }}"   >
                                        <div id="error-nama" class="nama__input-error w-5/6 text-theme-6 mt-2"></div>
                                    </div>
                                    <div class="mt-3">
                                        <label class="form-label">Email</label>
                                        <input id="email" type="email" class="form-control email__input" placeholder="Input text" value="{{ $user->email }}"   >
                                        <div id="error-email" class="email__input-error w-5/6 text-theme-6 mt-2"></div>
                                    </div>
                                </div>
                                <div class="col-span-12 xxl:col-span-6">
                                    <div class="mt-3 xxl:mt-0">
                                        <label class="form-label">Role</label>
                                        <select data-search="true" class="tail-select w-full role__input" id="role">
                                            <option value="true" {{ $user->admin ? 'selected' : '' }}>Admin</option>
                                            <option value="false" {{ !$user->admin ? 'selected' : '' }}>Member</option>
                                        </select>
                                        <div id="error-role" class="role__input-error w-5/6 text-theme-6 mt-2"></div>
                                    </div>
                                    <div class="mt-3">
                                        <label class="form-label">Nomor Telepon</label>
                                        <input id="no_telepon" type="text" class="form-control no_telepon__input" placeholder="+(62) 12398982" value="{{ $user->phone }}">
                                        <div id="error-no_telepon" class="no_telepon__input-error w-5/6 text-theme-6 mt-2"></div>
                                    </div>
                                </div>
                                <div class="col-span-12">
                                    <div class="mt-3">
                                        <label class="form-label">Alamat</label>
                                        <textarea id="alamat" class="form-control alamat__input" placeholder="Alamat">{{ $user->address }}</textarea>
                                        <div id="error-alamat" class="alamat__input-error w-5/6 text-theme-6 mt-2"></div>
                                    </div>
                                </div>
                            </div>
                            <button type="button" id="btn-update-identitas" class="btn btn-primary w-20 mt-3">Simpan</button>
                        </div>
                        <div class="w-52 mx-auto xl:mr-0 xl:ml-6">
                            <div class="border-2 border-dashed shadow-sm border-gray-200 dark:border-dark-5 rounded-md p-5">
                                <div class="h-40 relative image-fit cursor-pointer zoom-in mx-auto">
                                    <img class="rounded-md" alt="Avatar" id="avatar" src="{{ $user->avatar }}">
                                    @if($user->ava)
                                    <div title="Hapus avatar" id="btnHapusAvatar" class="tooltip w-5 h-5 flex items-center justify-center absolute rounded-full text-white bg-theme-6 right-0 top-0 -mr-2 -mt-2">
                                        <i data-feather="x" class="w-4 h-4"></i>
                                    </div>
                                    @endif
                                </div>
                                <div class="mx-auto cursor-pointer relative mt-5">
                                    <button type="button" class="btn btn-primary w-full">{{ $user->ava ? 'Rubah Foto' : 'Tambah Foto' }}</button>
                                    <input type="file" id="avatarInput" class="w-full h-full top-0 left-0 absolute opacity-0">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END: Display Information -->
            <!-- BEGIN: Personal Information -->
            <div class="intro-y box mt-5 d-none" id="passwordForm">
                <div class="flex items-center p-5 border-b border-gray-200 dark:border-dark-5">
                    <h2 class="font-medium text-base mr-auto">Rubah Password</h2>
                </div>
                <div class="p-5">
                    <div class="grid grid-cols-12 gap-x-5">
                        <div class="col-span-12 xl:col-span-12">
                            <div >
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
                        </div>
                    </div>
                    <div class="flex justify-end mt-4">
                        <button type="button" id="btn-update-password" class="btn btn-primary w-20 mr-auto">Simpan</button>
                    </div>
                </div>
            </div>
            <!-- END: Personal Information -->
        </div>
    </div>
@endsection

@push('css')
    <style>
        .d-none{
            display: none !important;
        }
    </style>
@endpush

@push('js')
    <script>
        cash(function () {
            let removePhoto = false;

            cash('#btnIdentitas').on('click',function () {
                $(this).addClass('text-theme-1 dark:text-theme-10 font-medium');
                $('#btnPassword').removeClass('text-theme-1 dark:text-theme-10 font-medium');
                $('#identitasForm').removeClass('d-none');
                $('#passwordForm').addClass('d-none');
                $('#avatar').attr('src', '{{ $user->avatar }}' )
                removePhoto = false;
            })

            cash('#btnPassword').on('click',function () {
                $(this).addClass('text-theme-1 dark:text-theme-10 font-medium');
                $('#btnIdentitas').removeClass('text-theme-1 dark:text-theme-10 font-medium');
                $('#identitasForm').addClass('d-none');
                $('#passwordForm').removeClass('d-none');
            })

            cash('#btnHapusAvatar').on('click',function () {
                $('#avatar').attr('src', '{{ asset('assets/img/user.png') }}' )
                $('#avatarInput').val(null)
                removePhoto = true;
            })

            cash('#btn-update-identitas').on('click',function () {
                updateIdentitas();
            })
            cash('#btn-update-password').on('click',function () {
                updatePassword();
            })
            cash('#btn-delete').on('click',function () {
                deleteUser();
            })

            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        $('#avatar').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(input.files[0]); // convert to base64 string
                }
            }

            $('#avatarInput').change(function () {
                readURL(this);
            })

            async function updateIdentitas() {
                // Reset state
                cash('#identitasForm').find('.nama__input').removeClass('border-theme-6')
                cash('#identitasForm').find('.nama__input-error').html('')
                cash('#identitasForm').find('.email__input').removeClass('border-theme-6')
                cash('#identitasForm').find('.email__input-error').html('')
                cash('#identitasForm').find('.phone__input').removeClass('border-theme-6')
                cash('#identitasForm').find('.phone__input-error').html('')
                cash('#identitasForm').find('.alamat__input').removeClass('border-theme-6')
                cash('#identitasForm').find('.alamat__input-error').html('')

                // Post form
                let nama = cash('#nama').val()
                let email = cash('#email').val()
                let phone = cash('#no_telepon').val()
                let alamat =  cash('#alamat').val()
                let admin = cash("#role").val()
                let picture = document.getElementById('avatarInput')

                let formData = new FormData();
                formData.append("_method", 'put');
                formData.append("nama", nama);
                formData.append("email", email);
                formData.append("no_telepon", phone);
                formData.append("removePhoto", removePhoto);
                formData.append("alamat", alamat);
                formData.append("role", admin);
                if (typeof picture.files[0] !== 'undefined'){
                    formData.append("avatar", picture.files[0]);
                }

                // Loading state
                cash('#btn-update-identitas').html('<i data-loading-icon="oval" data-color="white" class="w-5 h-5 mx-auto"></i>').svgLoader()
                await helper.delay(1500)

                axios.post('{{ route('admin.user.update.identitas',$user->id) }}', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }).then(res => {
                    Swal.fire(
                        'Berhasil!',
                        'User berhasil di perbaharui.',
                        'success'
                    ).then(function () {
                        return window.location.href = res.data.redirect
                    });
                }).catch(err => {
                    cash('#btn-update-identitas').html('Simpan')
                    for (const [key, val] of Object.entries(err.response.data.errors)) {
                        cash(`#${key}`).addClass('border-theme-6')
                        cash(`#error-${key}`).html(val)
                    }
                })
            }

            async function updatePassword() {
                // Reset state
                cash('#passwordForm').find('.password__input').removeClass('border-theme-6')
                cash('#passwordForm').find('.password__input-error').html('')
                cash('#passwordForm').find('.password_confirmation__input').removeClass('border-theme-6')
                cash('#passwordForm').find('.password_confirmation__input-error').html('')

                // Post form
                let password = cash('#password').val()
                let password_confirmation = cash('#password_confirmation').val()

                let formData = new FormData();
                formData.append("_method", 'put');
                formData.append("password", password);
                formData.append("password_confirmation", password_confirmation);
                // Loading state
                cash('#btn-update-password').html('<i data-loading-icon="oval" data-color="white" class="w-5 h-5 mx-auto"></i>').svgLoader()
                await helper.delay(1500)

                axios.post('{{ route('admin.user.update.password',$user->id) }}', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }).then(res => {
                    Swal.fire(
                        'Berhasil!',
                        'User berhasil di perbaharui.',
                        'success'
                    ).then(function () {
                        return window.location.href = res.data.redirect
                    });
                }).catch(err => {
                    cash('#btn-update-password').html('Simpan')
                    for (const [key, val] of Object.entries(err.response.data.errors)) {
                        cash(`#${key}`).addClass('border-theme-6')
                        cash(`#error-${key}`).html(val)
                    }
                })
            }

            async function deleteUser() {
                Swal.fire({
                    title: 'Apa anda yakin?',
                    text: "Anda akan menghapus data user!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Tidak, batalkan!',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        axios.delete('{{ route('admin.user.delete', $user->id ) }}/', {
                            params: {
                                'id': {{ $user->id }}
                            }
                        })
                            .then((response) => {
                                Swal.fire(
                                    'Dihapus!',
                                    'User berhasil di hapus.',
                                    'success'
                                )
                                table.refreshFilter();
                            })
                            .catch((error) => {
                                Swal.fire(
                                    'Error!',
                                    error.message,
                                    'error'
                                )
                            })
                    }
                });
            }
        })
    </script>
@endpush
