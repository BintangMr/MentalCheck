@extends('../layout/' . $layout)

@section('breadcrumb')
    <a href="{{ route('admin') }}">Dashboard</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i>
    <a href="{{ route('admin.question.category') }}">Soal Kategori</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i>
    <a href="{{ route('admin.question',$category_id) }}">List Soal</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i>
    <a href="{{ route('admin.question.create',$category_id,$soal_id) }}">List Jawaban</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i>
    <a href="{{ route('admin.question.answer.create',[$category_id, $soal_id]) }}" class="breadcrumb--active">Edit Jawaban</a>
@endsection

@section('subhead')
    <title>Mental Check | Admin Edit Jawaban</title>
@endsection

@section('subcontent')
    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">Edit Jawaban</h2>
    </div>
    <!-- BEGIN: HTML Table Data -->
    <div class="intro-y box p-5 mt-5">
        <div id="vertical-form" class="p-5">
            <form id="form">
                <input id="id" value="{{ $jawaban->id }}" style="display: none">
                <div>
                    <label for="jawaban" class="form-label">Jawaban</label>
                    <input id="jawaban" required type="text" class="form-control jawaban__input"
                           placeholder="Jawaban" value="{{$jawaban->answer}}">
                    <div id="error-jawaban" class="jawaban__input-error w-5/6 text-theme-6 mt-2"></div>
                </div>
                <div>
                    <label for="poin" class="form-label">Poin</label>
                    <input id="poin" required type="number" class="form-control poin__input"
                           placeholder="Poin" value="{{$jawaban->point}}">
                    <div id="error-poin" class="poin__input-error w-5/6 text-theme-6 mt-2"></div>
                </div>
                <button type="button" id="btn-simpan" class="btn btn-primary mt-5">Perbarui</button>
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
                cash('#form').find('.poin__input').removeClass('border-theme-6')
                cash('#form').find('.poin__input-error').html('')
                cash('#form').find('.jawaban__input').removeClass('border-theme-6')
                cash('#form').find('.jawaban__input-error').html('')

                // Post form
                let id = cash('#id').val()
                let jawaban = cash('#jawaban').val()
                let poin = cash('#poin').val()

                // Loading state
                cash('#btn-simpan').html('<i data-loading-icon="oval" data-color="white" class="w-5 h-5 mx-auto"></i>').svgLoader()
                await helper.delay(1500)

                axios.put('{{ route('admin.question.answer.update',[ $category_id,$soal_id,$jawaban->id]) }}', {
                    id: id,
                    jawaban: jawaban,
                    poin: poin,
                    soal_id: {{ $soal_id }},
                }).then(res => {
                    Swal.fire(
                        'Berhasil!',
                        'Jawaban berhasil di perbaharui.',
                        'success'
                    ).then(function () {
                        return window.location.href = res.data.redirect
                    });
                }).catch(err => {
                    cash('#btn-simpan').html('Perbarui')
                    for (const [key, val] of Object.entries(err.response.data.errors)) {
                        cash(`#${key}`).addClass('border-theme-6')
                        cash(`#error-${key}`).html(val)
                    }
                })
            }

            cash('#btn-simpan').on('click', function () {
                simpan()
            })

            cash('#aktif').on('change',function(event){
                if(cash(this).is(':checked')){
                    cash('#aktif-label').text('Aktif');
                }else{
                    cash('#aktif-label').text('Tidak Aktif');
                }
            });
        })
    </script>
@endpush


