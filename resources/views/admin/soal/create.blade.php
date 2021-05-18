@extends('../layout/' . $layout)

@section('breadcrumb')
    <a href="{{ route('admin') }}">Dashboard</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i>
    <a href="{{ route('admin.question.category') }}">Soal Kategori</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i>
    <a href="{{ route('admin.question',$category_id) }}">List Soal</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i>
    <a href="{{ route('admin.question.create',$category_id) }}" class="breadcrumb--active">Tambah Soal</a>
@endsection

@section('subhead')
    <title>Mental Check | Admin Tambah Soal</title>
@endsection

@section('subcontent')
    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">Tambah Soal</h2>
    </div>
    <!-- BEGIN: HTML Table Data -->
    <form id="form">
        <div class="intro-y box p-5 mt-5">
            <div id="vertical-form" class="p-5">
                <div class="mt-3">
                    <label for="deskripsi" class="form-label">Soal</label>
                    <textarea id="soal" required type="text" class="form-control soal__input"
                              placeholder="Soal"></textarea>
                    <div id="error-soal" class="soal__input-error w-5/6 text-theme-6 mt-2"></div>
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
            </div>
        </div>

        <div class="intro-y box p-5 mt-5">
            <h1 class="text-4xl font-medium leading-none">Jawaban</h1>
            <div id="vertical-form" class="p-5 holder">
                <div class="mt-3 border-2 p-2 entry">
                    <div class="form-inline">
                        <label for="horizontal-form-1" class="form-label sm:w-20"> Text </label>
                        <input id="" type="text" name="text_jawaban[]" class="form-control" placeholder="">
                        <button type="button" class="btn btn-success lg:ml-2 btn-add">+</button>
                    </div>
                    <div class="form-inline mt-5">
                        <label for="horizontal-form-2" class="form-label sm:w-20">POINT</label>
                        <input id="" type="number" name="point_jawaban[]" class="form-control" placeholder="">
                    </div>
                </div>
            </div>
            <button type="button" id="btn-simpan" class="btn btn-primary mt-5">Simpan</button>
        </div>
    </form>

@endsection

@push('css')

@endpush

@push('js')
    <script>
        cash(function () {
            async function simpan() {
                // Reset state
                cash('#form').find('.soal__input').removeClass('border-theme-6')
                cash('#form').find('.soal__input-error').html('')

                // Post form
                let soal = cash('#soal').val()
                let aktif = cash("input[name=aktif]:checked").val()

                let jawaban = document.getElementsByName('text_jawaban[]');
                let point = document.getElementsByName('point_jawaban[]');
                let arrayJawaban = [];

                var formData = new FormData();
                formData.append("soal", soal);
                formData.append("kategori_id", {{ $category_id }});
                formData.append("aktif", aktif);

                for (var i = 0; i < jawaban.length; i++) {
                    var j = jawaban[i];
                    var p = point[i];
                    formData.append("text_jawaban[]", j.value);
                    formData.append("point_jawaban[]", p.value);
                }

                // Loading state
                cash('#btn-simpan').html('<i data-loading-icon="oval" data-color="white" class="w-5 h-5 mx-auto"></i>').svgLoader()
                await helper.delay(1500)

                axios.post('{{ route('admin.question.store',$category_id) }}', formData).then(res => {
                    Swal.fire(
                        'Berhasil!',
                        'Soal berhasil di tambahkan.',
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

            $(document).on('click', '.btn-add', function(e) {
                e.preventDefault();
                var dynaForm = $('.holder'),
                    currentEntry = $(this).parents('.entry:first'),
                    newEntry = $(currentEntry.clone()).appendTo(dynaForm);

                newEntry.find('input').val('');
                dynaForm.find('.entry:not(:last) .btn-add')
                    .removeClass('btn-add').addClass('btn-remove')
                    .removeClass('btn-success').addClass('btn-danger')
                    .text('-');
            }).on('click', '.btn-remove', function(e) {
                $(this).parents('.entry:first').remove();

                e.preventDefault();
                return false;
            });
        })
    </script>
@endpush


