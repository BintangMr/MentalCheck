@extends('../layout/' . $layout)


@section('breadcrumb')
    <a href="{{ route('member') }}">Dashboard</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i>
    <a href="{{ route('member.history') }}" class="breadcrumb--active">History</a>
@endsection

@section('subhead')
    <title>Mental Check | Member Test</title>
@endsection

@section('subcontent')
    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12 xxl:col-span-9">
            <div class="grid grid-cols-12 gap-6">
                <!-- BEGIN: General Report -->
                <div class="col-span-12 mt-8">
                    <div class="intro-y flex items-center h-10">
                        <h2 class="text-lg font-medium truncate mr-5">History</h2>
                    </div>

                </div>
                <!-- END: General Report -->

                <!-- END: Weekly Top Products -->
            </div>
        </div>

        @foreach ($categories as $category)
            <div class="intro-y col-span-12 md:col-span-8 xl:col-span-6 box">
                <div class="p-5">
                    <div class="h-40 xxl:h-56 image-fit">
                        <img alt="Rubick Tailwind HTML Admin Template" class="rounded-md" src="{{ $category->image }}">
                    </div>
                    <a href="" class="block font-medium text-base mt-5">{{ $category->category }}</a>
                    <div class="text-gray-700 dark:text-gray-600 mt-2">{{ $category->description }}</div>
                </div>
                <div class="flex items-center px-5 py-2 border-t border-gray-200 dark:border-dark-5" style="border-bottom: none">
                    Progress :
                </div>
                <div class="flex items-center px-5 py-3 border-t border-gray-200 dark:border-dark-5"  style="border-top: none">
                        <div class="progress-bar w-full bg-theme-9 rounded" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                            100%</div>

                </div>
                <div class="flex items-center px-5 py-2 border-t border-gray-200 dark:border-dark-5">
                    KESIMPULAN : {{ $category->user->diagnosa }}
                </div>
                <div class="px-5 pt-3 pb-5 border-t border-gray-200 dark:border-dark-5">
                    <button class="btn btn-success btn-start" data-id="{{ $category->id }}" style="width: 100%;"> LIHAT</button>
                </div>
            </div>
        @endforeach
    </div>
@endsection

@push('js')
    <script>
        cash(function () {
            cash('.btn-start').on('click', function() {
                window.location.href = `{{ route('member.history.test',['']) }}/` + $(this).data('id');
            })
        })
    </script>
@endpush
