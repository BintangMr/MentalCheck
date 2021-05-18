@extends('../layout/' . $layout)

@section('breadcrumb')
    <a href="{{ route('member') }}" class="breadcrumb--active">Dashboard</a>
@endsection

@section('subhead')
    <title>Halaman Member</title>
@endsection

@section('subcontent')
    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12 xxl:col-span-9">
            <div class="grid grid-cols-12 gap-6">
                <!-- BEGIN: General Report -->
                <div class="col-span-12 mt-8">
                    <div class="intro-y flex items-center h-10">
                        <h2 class="text-lg font-medium truncate mr-5">Dashboard</h2>
                    </div>

                </div>
                <!-- END: General Report -->

                <!-- END: Weekly Top Products -->
            </div>
        </div>
    </div>
@endsection

@push('js')
@endpush
