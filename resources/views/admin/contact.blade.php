@extends('../layout/' . $layout)

@section('breadcrumb')
    <a href="{{ route('admin') }}">Dashboard</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i>
    <a href="{{ route('admin.contact') }}" class="breadcrumb--active">Kontak</a>
@endsection

@section('subhead')
    <title>Mental Check | Admin Contact</title>
@endsection

@section('subcontent')
    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">Kontak</h2>
    </div>
    <!-- BEGIN: HTML Table Data -->
    <div class="intro-y box p-5 mt-5">
        <div id="vertical-form" class="p-5">
            <form id="form">
                <input id="id" value="{{ $contact->id }}" style="display: none">
                <div>
                    <label for="alamat" class="form-label">Alamat</label>
                    <textarea id="alamat" required type="text" class="form-control alamat__input"
                              placeholder="Alamat">{{$contact->address}}</textarea>
                    <div id="error-alamat" class="alamat__input-error w-5/6 text-theme-6 mt-2"></div>
                </div>
                <div>
                    <label for="no_telepon" class="form-label">No Telepon</label>
                    <input id="no_telepon" required type="text" class="form-control poin__input"
                           placeholder="(022) xxxxx" value="{{$contact->phone}}">
                    <div id="error-poin" class="poin__input-error w-5/6 text-theme-6 mt-2"></div>
                </div>
                <button type="button" id="btn-simpan" class="btn btn-primary mt-5">Simpan</button>
            </form>
        </div>
    </div>
@endsection

@push('css')

@endpush

@push('js')
    <script>
        cash(function () {
            async function simpan() {
                // Reset state
                cash('#form').find('.alamat__input').removeClass('border-theme-6')
                cash('#form').find('.alamat__input-error').html('')
                cash('#form').find('.no_telepon__input').removeClass('border-theme-6')
                cash('#form').find('.no_telepon__input-error').html('')

                // Post form
                let id = cash('#id').val()
                let alamat = cash('#alamat').val()
                let no_telepon = cash('#no_telepon').val()

                // Loading state
                cash('#btn-simpan').html('<i data-loading-icon="oval" data-color="white" class="w-5 h-5 mx-auto"></i>').svgLoader()
                await helper.delay(1500)

                axios.post('{{ route('admin.contact.update') }}', {
                    id: id,
                    alamat: alamat,
                    no_telepon: no_telepon,
                }).then(res => {
                    Swal.fire(
                        'Berhasil!',
                        'Kontak berhasil di simpan.',
                        'success'
                    ).then(function () {
                        return location.reload();
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

        })
    </script>
@endpush


