@extends('../layout/' . $layout)

@section('breadcrumb')
    <a href="{{ route('admin') }}">Dashboard</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i>
    <a href="{{ route('admin.question.category') }}">Soal Kategori</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i>
    <a href="{{ route('admin.question.result',$result->question_category_id) }}" class="breadcrumb--active">Kesimpulan</a>
@endsection

@section('subhead')
    <title>Mental Check | Admin Result</title>
@endsection

@section('subcontent')
    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">Hasil</h2>
    </div>
    <!-- BEGIN: HTML Table Data -->
    <div class="intro-y box p-5 mt-5">
        <div id="vertical-form" class="p-5">
            <form id="form">
                <input name="id" value="{{ $result->id }}" style="display: none">
                <div>
                    <label  class="form-label"> < 25</label>
                    <input name="cat_a" required type="text" class="form-control cat_a__input"
                           placeholder="" value="{{$result->cat_a }}">
                    <div id="error-cat_a" class="cat_a__input-error w-5/6 text-theme-6 mt-2"></div>
                </div>
                <div>
                    <label  class="form-label">25 - 50</label>
                    <input name="cat_b" required type="text" class="form-control cat_b__input"
                           placeholder="" value="{{ $result->cat_b }}">
                    <div id="error-cat_b" class="cat_b__input-error w-5/6 text-theme-6 mt-2"></div>
                </div>
                <div>
                    <label  class="form-label">50 - 100</label>
                    <input name="cat_c" required type="text" class="form-control cat_c__input"
                           placeholder="" value="{{ $result->cat_c }}">
                    <div id="error-cat_c" class="cat_c__input-error w-5/6 text-theme-6 mt-2"></div>
                </div>
                <div>
                    <label  class="form-label">100</label>
                    <input name="cat_d" required type="text" class="form-control cat_d__input"
                           placeholder="" value="{{ $result->cat_d }}">
                    <div id="error-cat_d" class="cat_d__input-error w-5/6 text-theme-6 mt-2"></div>
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
                cash('#form').find('.cat_a__input').removeClass('border-theme-6')
                cash('#form').find('.cat_a__input-error').html('')
                cash('#form').find('.cat_b__input').removeClass('border-theme-6')
                cash('#form').find('.cat_b__input-error').html('')
                cash('#form').find('.cat_c__input').removeClass('border-theme-6')
                cash('#form').find('.cat_c__input-error').html('')
                cash('#form').find('.cat_d__input').removeClass('border-theme-6')
                cash('#form').find('.cat_d__input-error').html('')

                // Post form
                var form = document.querySelector('form');
                var data = new FormData(form);

                // Loading state
                cash('#btn-simpan').html('<i data-loading-icon="oval" data-color="white" class="w-5 h-5 mx-auto"></i>').svgLoader()
                await helper.delay(1500)

                axios.post('{{ route('admin.question.result.update', $result->id ) }}',data).then(res => {
                    Swal.fire(
                        'Berhasil!',
                        'Kesimpulan berhasil di simpan.',
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
        })
    </script>
@endpush


