@extends('../layout/' . $layout)

@section('breadcrumb')
    <a href="{{ route('admin') }}">Dashboard</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i>
    <a href="{{ route('admin.question.category') }}">Kategori Soal</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i>
    <a href="{{ route('admin.question',$category_id) }}" class="breadcrumb--active">List Soal</a>
@endsection

@section('subhead')
    <title>Mental Check | Admin Soal Kategori : {{ $category_name }}</title>
@endsection

@section('subcontent')
    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">Soal Kategori : {{ $category_name }}</h2>
        <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
            <button class="btn btn-primary shadow-md mr-2" id="btn-create">Tambah Soal</button>
        </div>
    </div>
    <!-- BEGIN: HTML Table Data -->
    <div class="intro-y box p-5 mt-5">
        <div class="flex flex-col sm:flex-row sm:items-end xl:items-start">
            <form id="tabulator-html-filter-form" class="xl:flex sm:mr-auto">
                <div class="sm:flex items-center sm:mr-4">
                    <label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2">Field</label>
                    <select id="tabulator-html-filter-field"
                            class="form-select w-full sm:w-32 xxl:w-full mt-2 sm:mt-0 sm:w-auto">
                        <option value="question">Soal</option>
                    </select>
                </div>
                <div class="sm:flex items-center sm:mr-4 mt-2 xl:mt-0">
                    <label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2">Type</label>
                    <select id="tabulator-html-filter-type" class="form-select w-full mt-2 sm:mt-0 sm:w-auto">
                        <option value="like" selected>like</option>
                        <option value="=">=</option>
                        <option value="!=">!=</option>
                    </select>
                </div>
                <div class="sm:flex items-center sm:mr-4 mt-2 xl:mt-0">
                    <label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2">Value</label>
                    <input id="tabulator-html-filter-value" type="text"
                           class="form-control sm:w-40 xxl:w-full mt-2 sm:mt-0" placeholder="Cari...">
                </div>
                <div class="mt-2 xl:mt-0">
                    <button id="tabulator-html-filter-go" type="button" class="btn btn-primary w-full sm:w-16">Go
                    </button>
                    <button id="tabulator-html-filter-reset" type="button"
                            class="btn btn-secondary w-full sm:w-16 mt-2 sm:mt-0 sm:ml-1">Reset
                    </button>
                </div>
            </form>
            <div class="flex mt-5 sm:mt-0">
                <button id="tabulator-print" class="btn btn-outline-secondary w-1/2 sm:w-auto mr-2">
                    <i data-feather="printer" class="w-4 h-4 mr-2"></i> Print
                </button>
                <div class="dropdown w-1/2 sm:w-auto">
                    <button class="dropdown-toggle btn btn-outline-secondary w-full sm:w-auto" aria-expanded="false">
                        <i data-feather="file-text" class="w-4 h-4 mr-2"></i> Export <i data-feather="chevron-down"
                                                                                        class="w-4 h-4 ml-auto sm:ml-2"></i>
                    </button>
                    <div class="dropdown-menu w-40">
                        <div class="dropdown-menu__content box dark:bg-dark-1 p-2">
                            <a id="tabulator-export-csv" href="javascript:;"
                               class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">
                                <i data-feather="file-text" class="w-4 h-4 mr-2"></i> Export CSV
                            </a>
                            <a id="tabulator-export-json" href="javascript:;"
                               class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">
                                <i data-feather="file-text" class="w-4 h-4 mr-2"></i> Export JSON
                            </a>
                            <a id="tabulator-export-xlsx" href="javascript:;"
                               class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">
                                <i data-feather="file-text" class="w-4 h-4 mr-2"></i> Export XLSX
                            </a>
                            <a id="tabulator-export-html" href="javascript:;"
                               class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">
                                <i data-feather="file-text" class="w-4 h-4 mr-2"></i> Export HTML
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="overflow-x-auto scrollbar-hidden">
            <div id="soal-table" class="mt-5 table-report table-report--tabulator"></div>
        </div>
    </div>
    <!-- END: HTML Table Data -->
@endsection

@push('css')
    <style>
        a.disabled {
            pointer-events: none;
            cursor: default;
        }
    </style>
@endpush

@push('js')
    <script>
        axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
        if (cash("#soal-table").length) {
            // Filter function
            var filterHTMLForm = function filterHTMLForm() {
                var field = cash("#tabulator-html-filter-field").val();
                var type = cash("#tabulator-html-filter-type").val();
                var value = cash("#tabulator-html-filter-value").val();
                table.setFilter(field, type, value);
            }; // On submit filter form


            // Setup Tabulator
            var table = new Tabulator.default("#soal-table", {
                ajaxURL: '{{ route('admin.question',$category_id) }}',
                ajaxFiltering: true,
                ajaxSorting: true,
                printAsHtml: true,
                printStyled: true,
                pagination: "remote",
                paginationSize: 10,
                paginationSizeSelector: [10, 20, 30, 40],
                layout: "fitColumns",
                responsiveLayout: "collapse",
                placeholder: "Tidak ada data soal yang sesuai",
                reactiveData: true, //enable reactive data
                columns: [{
                    formatter: "responsiveCollapse",
                    width: 40,
                    minWidth: 30,
                    align: "center",
                    resizable: false,
                    headerSort: false
                },  {
                    title: "Soal",
                    minWidth: 650,
                    field: "question",
                    hozAlign: "left",
                    vertAlign: "middle",
                    print: true,
                    download: true,
                    formatter: "textarea"
                }, {
                    title: "STATUS",
                    minWidth: 100,
                    field: "status",
                    hozAlign: "center",
                    vertAlign: "middle",
                    print: true,
                    download: true,
                    formatter: function formatter(cell, formatterParams) {
                        return "<div class=\"flex items-center lg:justify-center "
                            .concat(cell.getData().status ? "text-theme-9" : "text-theme-6", "\">\n " +
                                "<i data-feather=\"check-square\" class=\"w-4 h-4 mr-2\"></i> ")
                            .concat(cell.getData().status ? "Active" : "Inactive", "\n " +
                                " </div>");
                    }
                }, {
                    title: "ACTIONS",
                    minWidth: 10,
                    field: "actions",
                    responsive: 1,
                    hozAlign: "center",
                    vertAlign: "middle",
                    print: false,
                    download: false,
                    headerSort:false,
                    formatter: function formatter(cell, formatterParams) {
                        var a = cash("<div class=\"flex lg:justify-center items-center\">\n" +
                            "<a class=\"show flex items-center mr-3\" href=\"{{ route('admin.question.answer',[$category_id,'']) }}/"+cell.getData().id+"\">\n" +
                            "<i data-feather=\"eye\" class=\"w-4 h-4 mr-1\"></i> Jawaban\n" +
                            "</a>\n" +
                            "<a class=\"edit flex text-theme-11 items-center mr-3\" href=\"{{ route('admin.question.edit',[$category_id ,'']) }}/"+cell.getData().id+"\">\n" +
                            "<i data-feather=\"check-square\" class=\"w-4 h-4 mr-1\"></i> Edit\n" +
                            "</a>\n" +
                            "<a class=\"delete flex items-center text-theme-6\" data-id=\"" + cell.getData().id + "\" href=\"javascript:;\">\n" +
                            "<i data-feather=\"trash-2\" class=\"w-4 h-4 mr-1\"></i> Delete\n  " +
                            " </a>\n                        </div>");

                        cash(a).find(".delete").on("click", function () {
                            Swal.fire({
                                title: 'Apa anda yakin?',
                                text: "Anda akan menghapus data soal!",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonText: 'Ya, hapus!',
                                cancelButtonText: 'Tidak, batalkan!',
                                reverseButtons: true
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    axios.delete('{{ route('admin.question.delete', $category_id) }}', {
                                        params: {
                                            'id': cash(this).data("id")
                                        }
                                    })
                                        .then((response) => {
                                            Swal.fire(
                                                'Dihapus!',
                                                'Soal berhasil di hapus.',
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

                                } else if (
                                    /* Read more about handling dismissals below */
                                    result.dismiss === Swal.DismissReason.cancel
                                ) {
                                    Swal.fire(
                                        'Dibatalkan!',
                                        'Anda membatalkan penghapusan soal',
                                        'error'
                                    )
                                }
                            })
                        });
                        return a[0];
                    }
                },
                ],
                renderComplete: function renderComplete() {
                    Feather().replace({
                        "stroke-width": 1.5
                    });
                }
            }); // Redraw table onresize

            window.addEventListener("resize", function () {
                table.redraw();
                Feather().replace({
                    "stroke-width": 1.5
                });
            });
            cash("#tabulator-html-filter-form")[0].addEventListener("keypress", function (event) {
                var keycode = event.keyCode ? event.keyCode : event.which;

                if (keycode == "13") {
                    event.preventDefault();
                    filterHTMLForm();
                }
            }); // On click go button

            cash("#tabulator-html-filter-go").on("click", function (event) {
                filterHTMLForm();
            }); // On reset filter form

            cash("#tabulator-html-filter-reset").on("click", function (event) {
                cash("#tabulator-html-filter-field").val("soal");
                cash("#tabulator-html-filter-type").val("like");
                cash("#tabulator-html-filter-value").val("");
                filterHTMLForm();
            }); // Export

            cash("#tabulator-export-csv").on("click", function (event) {
                table.download("csv", "data.csv");
            });
            cash("#tabulator-export-json").on("click", function (event) {
                table.download("json", "data.json");
            });
            cash("#tabulator-export-xlsx").on("click", function (event) {
                window.XLSX = (TabulatorXls());
                table.download("xlsx", "data.xlsx", {
                    sheetName: "Soal"
                });
            });
            cash("#tabulator-export-html").on("click", function (event) {
                table.download("html", "data.html", {
                    style: true
                });
            }); // Print

            cash("#tabulator-print").on("click", function (event) {
                table.print();
            });
        }

        cash('#btn-create').on('click', function (event){
            window.location.href = '{{ route('admin.question.create',$category_id) }}';
        });
    </script>
@endpush


