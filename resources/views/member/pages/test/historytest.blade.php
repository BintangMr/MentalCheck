@extends('../layout/' . $layout)

@section('breadcrumb')
    <a href="{{ route('member') }}">Dashboard</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i>
    <a href="{{ route('member.history') }}">History</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i>
    <a href="{{ route('member.history.test',$user->question_category_id) }}" class="breadcrumb--active">{{ $user->category_name }}</a>
@endsection

@section('subhead')
    <title>Mental Check | History Test</title>
@endsection

@section('subcontent')
    <div class="flex items-center mt-8">
        <h2 class="intro-y text-lg font-medium mr-auto">{{ $user->category_name }}</h2>
    </div>
    <!-- BEGIN: Wizard Layout -->
    <div class="intro-y box py-10 sm:py-20 mt-5">
        <div class="flex justify-center">
            @if(count($user->answer) > 0)
                @foreach($user->answer as $key => $soal)
                    @if($key == 0)
                        <button class="intro-y w-10 h-10 rounded-full btn btn-primary mx-2" id="no-{{$key}}">{{ $key+1 }}</button>
                    @else
                        <button
                            class="intro-y w-10 h-10 rounded-full btn bg-gray-200 dark:bg-dark-1 text-gray-600 mx-2"  id="no-{{$key}}">{{ $key+1 }}</button>
                    @endif
                @endforeach
            @else
                <div class="font-medium text-center text-lg">Tidak ada Soal yang tersedia</div>
            @endif
        </div>
        <form>
            @foreach($user->answer as $key => $soal)
                @if($key == 0)
                    <div id="soal-{{$key}}">
                        @else
                            <div style="display: none" id="soal-{{$key}}">
                                @endif
                                <div>
                                    <div class="px-5 mt-10">
                                        <div class="font-medium text-center text-lg">Pertanyaan</div>
                                        <input name="soal[{{$key}}]" value="{{ $soal->id }}" type="number" style="display: none">
                                        <div class="text-gray-600 text-center mt-2">{{ $soal->question }}
                                        </div>
                                    </div>
                                    <div class="px-5 sm:px-20 mt-10 pt-10 border-t border-gray-200 dark:border-dark-5" id="">
                                        <div class="font-medium text-base">Jawaban</div>
                                        <div class="grid grid-cols-12 gap-4 gap-y-5 mt-5">
                                            <div class="intro-y col-span-12">
                                                @foreach($soal->history as $index => $answer)
                                                    @if($answer->question_answer_id == $soal->question_answer_id)
                                                        <div class="form-check mr-2 mt-2 mb-3">
                                                            <input class="form-check-input" type="radio" name="jawaban[{{$key}}]" value="{{ $answer->id }}" checked disabled>
                                                            @else
                                                                <div class="form-check mr-2 mt-2 mb-3 sm:mt-0">
                                                                    <input class="form-check-input" type="radio" name="jawaban[{{$key}}]" value="{{ $answer->id }}" disabled>
                                                                    @endif
                                                                    <label class="form-check-label font-medium text-center text-lg" for="radio-switch-4" >{{ $answer->answer }}</label>
                                                                </div>
                                                                @endforeach
                                                        </div>
                                                        <div class="intro-y col-span-12 flex items-center justify-center sm:justify-end mt-5">
                                                            @if($key != 0)
                                                                <button type="button" class="btn btn-secondary w-24 btn-previous" data-id="{{ $key-1 }}"  data-current="{{$key}}">Sebelumnya</button>
                                                            @endif
                                                            @if(($key+1) != count($user->answer))
                                                                <button type="button" class="btn btn-primary w-24 ml-2 btn-next" data-id="{{ $key+1 }}" data-current="{{$key}}">Selanjutnya</button>
                                                            @endif
                                                        </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                    @endforeach
        </form>
    </div>
    <!-- END: Wizard Layout -->
@endsection

@push('js')
    <script>
        cash(function () {
            cash('.btn-previous').on('click', function() {
                let to = $(this).data('id');
                let current = $(this).data('current');

                $('#soal-'+current).hide();
                $('#soal-'+to).show();
                $('#no-'+current).removeClass('btn-primary').addClass('bg-gray-200 dark:bg-dark-1 text-gray-600')
                $('#no-'+to).addClass('btn-primary').removeClass('bg-gray-200 dark:bg-dark-1 text-gray-600')
            });

            cash('.btn-next').on('click', function() {
                let to = $(this).data('id');
                let current = $(this).data('current');

                $('#soal-'+current).hide();
                $('#soal-'+to).show();
                $('#no-'+current).removeClass('btn-primary').addClass('bg-gray-200 dark:bg-dark-1 text-gray-600')
                $('#no-'+to).addClass('btn-primary').removeClass('bg-gray-200 dark:bg-dark-1 text-gray-600')
            });

        })
    </script>
@endpush
