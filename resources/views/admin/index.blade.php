@extends('../layout/' . $layout)

@section('breadcrumb')
    <a href="{{ route('admin') }}" class="breadcrumb--active">Dashboard</a>
@endsection

@section('subhead')
    <title>Halaman Admin</title>
@endsection

@section('subcontent')
    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12">
            <div class="grid grid-cols-12 gap-6">
                <!-- BEGIN: General Report -->
                <div class="col-span-12 mt-8">
                    <div class="intro-y flex items-center h-10">
                        <h2 class="text-lg font-medium truncate mr-5">Dashboard</h2>
                        <a href="{{ route('admin') }}" class="ml-auto flex items-center text-theme-1 dark:text-theme-10">
                            <i data-feather="refresh-ccw" class="w-4 h-4 mr-3"></i> Reload Data
                        </a>
                    </div>
                    <div class="grid grid-cols-12 gap-6 mt-5">
                        <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                            <div class="report-box zoom-in">
                                <div class="box p-5" id="btn-team">
                                    <div class="flex">
                                        <i data-feather="star" class="report-box__icon text-theme-10"></i>
                                        <div class="ml-auto">
{{--                                            <div class="report-box__indicator bg-theme-9 tooltip cursor-pointer" title="33% Higher than last month">--}}
{{--                                                33% <i data-feather="chevron-up" class="w-4 h-4 ml-0.5"></i>--}}
{{--                                            </div>--}}
                                        </div>
                                    </div>
                                    <div class="text-3xl font-bold leading-8 mt-6">{{ number_format(count($data['teams'])) }}</div>
                                    <div class="text-base text-gray-600 mt-1">Teams</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                            <div class="report-box zoom-in">
                                <div class="box p-5" id="btn-soal">
                                    <div class="flex">
                                        <i data-feather="credit-card" class="report-box__icon text-theme-11"></i>
                                        <div class="ml-auto">
{{--                                            <div class="report-box__indicator bg-theme-6 tooltip cursor-pointer" title="2% Lower than last month">--}}
{{--                                                2% <i data-feather="chevron-down" class="w-4 h-4 ml-0.5"></i>--}}
{{--                                            </div>--}}
                                        </div>
                                    </div>
                                    <div class="text-3xl font-bold leading-8 mt-6">{{ number_format($data['soal']['total']['question']) }}</div>
                                    <div class="text-base text-gray-600 mt-1">Soal</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                            <div class="report-box zoom-in">
                                <div class="box p-5" id="btn-user">
                                    <div class="flex">
                                        <i data-feather="user" class="report-box__icon text-theme-9"></i>
                                        <div class="ml-auto">
                                        </div>
                                    </div>
                                    <div class="text-3xl font-bold leading-8 mt-6">{{ number_format($data['user']['member'] + $data['user']['admin']) }}</div>
                                    <div class="text-base text-gray-600 mt-1">User</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END: General Report -->
                <div class="col-span-12 mt-6">
                    <div class="intro-y block sm:flex items-center h-10">
                        <h2 class="text-lg font-medium truncate mr-5">Riwayat</h2>
                    </div>
                    <div class="intro-y overflow-auto lg:overflow-visible mt-8 sm:mt-0">
                        <table class="table table-report sm:mt-2">
                            <thead>
                            <tr>
                                <th class="whitespace-nowrap">Gambar</th>
                                <th class="whitespace-nowrap">Nama</th>
                                <th class="text-center whitespace-nowrap">Poin</th>
                                <th class="text-center whitespace-nowrap">Gejala</th>

                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($data['userTest']['user'] as $key => $value)
                                <tr class="intro-x">
                                    <td class="w-40">
                                        <div class="flex">
                                            <div class="w-10 h-10 image-fit zoom-in">
                                                <img alt="Rubick Tailwind HTML Admin Template" class="tooltip rounded-full" src="{{ $value->user->avatar  }}" title="Uploaded at {{ $value->user->update_at }}">
                                            </div>
                                            </div>
                                    </td>
                                    <td>
                                        <a href="" class="font-medium whitespace-nowrap">{{ $value->user->name }}</a>
                                        <div class="text-gray-600 text-xs whitespace-nowrap mt-0.5">{{ $value->user->email }}</div>
                                    </td>
                                    <td class="text-center">{{ $value->point }}</td>
                                    <td class="w-50">
                                        <div class="flex items-center justify-center text-theme-9">
                                            <i data-feather="check-square" class="w-4 h-4 mr-2"></i> {{ $value->diagnosa }}
                                        </div>
                                    </td>

                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- END: Weekly Top Products -->
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        cash("#btn-soal").on("click", function (event) {
            window.location.href = '{{ $data['soal']['url'] }}'
        });
        cash("#btn-user").on("click", function (event) {
            window.location.href = '#'
        });
    </script>
@endpush
