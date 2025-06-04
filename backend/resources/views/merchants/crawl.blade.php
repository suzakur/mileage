@extends('layouts.child')

@section('beauty')
@parent
<style type="text/css">
    .dataTables_filter {
        display: block !important;
    }
    .select2-container {
        z-index: 99999 !important;
    }

    .select2-container--open {
        z-index: 99999 !important;
    }
    .select2-dropdown {
        position: absolute !important;
        top: 100% !important;
        left: 0 !important;
        z-index: 1051 !important; /* Ensure it's above the modal */
    }
</style>
@endsection
@section('content')
<div class="container">
    <h2>Crawl Places List</h2>
    <div class="card card-flush h-xl-100">
        <!--begin::Header-->
        <div class="card-header pt-7">
            <div class="card-title">
                <!--begin::Export buttons-->
                <div id="kt_datatable_example_1_export" class="d-none"></div>
                <!--end::Export buttons-->
            </div>
            <!--begin::Title-->
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bold text-gray-800">Crawl List</span>
            </h3>
            <!--end::Title-->
            <!--begin::Toolbar-->
            <div class="card-toolbar d-flex align-items-center gap-2">
                <a href="#" class="btn btn-success fw-semibold" data-bs-toggle="modal" data-bs-target="#kt_modal_create">Query</a>
                <button id="save-places" class="btn btn-primary">Save to Places</button>
                <button id="delete-places" class="btn btn-danger">Delete From Lists</button>
            </div>
            <!--end::Toolbar-->
        </div>
        <!--end::Header-->
        <!--begin::Body-->
        <div class="card-body">
            <!--begin::Table container-->
            <div class="table-responsive">
                <table id="places-table" class="table align-middle table-row-dashed fs-6 gy-5">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Rating</th>
                        <th>User Ratings</th>
                        <th>Opening Hours</th>
                        <th>Category</th>
                        <th>Place</th>
                    </tr>
                    </thead>
                    <tbody class="text-gray-600 fw-semibold">
                    </tbody>
                </table>
            </div>
            <!--end::Table-->
        </div>
        <!--end: Card Body-->
    </div>
</div>
@endsection

@section('modals')
<div class="modal fade" id="kt_modal_create" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <div class="modal-header" id="kt_modal_create_header">
                <!--begin::Modal title-->
                <h2 class="fw-bold">Query Crawl</h2>
                <!--end::Modal title-->
                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                    <i class="ki-outline ki-cross fs-1"></i>
                </div>
                <!--end::Close-->
            </div>
            <!--begin::Modal header-->
            <!--begin::Modal body-->
            <div class="modal-body px-5 my-7">
                <!--begin::Form-->
                <form id="crawl-form" class="form fv-plugins-bootstrap5 fv-plugins-framework">
                    @csrf
                    <!--begin::Scroll-->
                    <div class="d-flex flex-column scroll-y px-5 px-lg-10" id="kt_modal_add_scroll" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_user_header" data-kt-scroll-wrappers="#kt_modal_add_scroll" data-kt-scroll-offset="300px" style="max-height: 83px;">
                        <!--begin::Input group-->
                        <div class="mb-3 fv-row">
                            <select name="category" id="category" class="form-control">
                                <option value="">-- Select Category --</option>
                                @foreach(App\Models\Category::where('status', 'active')->get() as $category)
                                    <option value="{{ $category->name }}">{{ ucfirst($category->name) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3 fv-row">
                            <select name="place_id" id="place_id" class="form-control">
                                <option value="">-- Select Place --</option>
                                @foreach(App\Models\Place::all() as $place)
                                    <option value="{{ $place->name }}">{{ ucfirst($place->name) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <!--begin::Actions-->
                    <div class="text-center pt-10">
                        <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal">Close</button>
                        <button id="create_submit" type="submit" class="btn btn-primary kt_button_indicator" data-kt-users-modal-action="submit">
                            <span class="indicator-label">Query</span>
                            <span class="indicator-progress">Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>
                    </div>
                    <!--end::Actions-->
                </form>
                <!--end::Form-->
            </div>
            <!--end::Modal body-->
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>
@endsection

@section('compute')
@parent
<script>
    $(document).ready(function () {
        let selectedRows = new Set();
        let categories = [];
        let places = [];
        let table;

        // Initialize Select2 inside modal
        function initSelect2() {
            if (!$.fn.select2) return;
            $('#category, #place_id').select2({
                placeholder: "Select an option",
                allowClear: true,
                dropdownParent: $('#kt_modal_create .modal-content'),
                width: "100%",
                tags: true
            });
        }

        initSelect2();

        $('#kt_modal_create').on('shown.bs.modal', initSelect2);
        $('#kt_modal_create').on('hidden.bs.modal', function () {
            if ($.fn.select2) $('#category, #place_id').select2('destroy');
        });

        // Fetch categories & places before initializing DataTable
        $.when(
            $.get("{{ url('list/categories') }}", (data) => categories = Array.isArray(data) ? data : []),
            $.get("{{ url('list/places') }}", (data) => places = Array.isArray(data) ? data : [])
        ).done(initDataTable).fail(() => console.error("Error fetching categories or places."));

        function initDataTable() {
            table = $('#places-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ url('places/fetch') }}",
                    type: "POST",
                    dataSrc: "data"
                },
                columns: [
                    {
                        data: "id",
                        title: "<input type='checkbox' id='select-all'>",
                        orderable: false,
                        searchable: false,
                        render: (data, type, row) => {
                            let rowId = row.id || row.crawl_place_id || '';
                            if (!rowId) return `<input type="checkbox" class="row-checkbox" disabled>`;
                            return `<input type="checkbox" class="row-checkbox" data-id="${rowId}" ${selectedRows.has(rowId) ? "checked" : ""}>`;
                        }
                    },
                    { data: "name", title: "Name", defaultContent: "-" },
                    { data: "rating", title: "Rating", defaultContent: "No rating" },
                    { data: "user_ratings_total", title: "User Ratings", defaultContent: "No ratings yet" },
                    {
                        data: "opening_hours",
                        title: "Opening Hours",
                        render: (data) => Array.isArray(data) ? data.join(", ") : "N/A"
                    },
                    {
                        data: "category_id",
                        title: "Category",
                        defaultContent: "Unknown",
                        render: (data, type, row) => {
                            let selectedCategoryId = row.category_id ? row.category_id.toString() : '';
                            let options = categories.map(category =>
                                `<option value="${category.id}" ${category.id.toString() === selectedCategoryId ? "selected" : ""}>${category.name}</option>`
                            ).join('');
                            return `<select class="category-select form-control" data-id="${row.id}">${options}</select>`;
                        }
                    },
                    {
                        data: "place_id",
                        title: "Place",
                        defaultContent: "Unknown",
                        render: (data, type, row) => {
                            let selectedPlaceId = row.place_id ? row.place_id.toString() : '';
                            let options = places.map(place =>
                                `<option value="${place.id}" ${place.id.toString() === selectedPlaceId ? "selected" : ""}>${place.name}</option>`
                            ).join('');
                            return `<select class="place-select form-control" data-id="${row.id}">${options}</select>`;
                        }
                    }
                ],
                columnDefs: [
                    { width: "45%", targets: 1 },
                    { width: "15%", targets: [4, 5, 6] },
                    { width: "5%", targets: [2, 3] },
                    { className: "text-center", targets: [0, 2, 3, 4, 5, 6] }
                ],
                order: [[1, 'asc']],
                lengthMenu: [[25, 50, 100, -1], [25, 50, 100, "All"]],
                pageLength: 25,
                drawCallback: function () {
                    $('.row-checkbox').each(function () {
                        let rowId = $(this).data('id');
                        $(this).prop('checked', selectedRows.has(rowId));
                    });

                    $('#select-all').off('change').on('change', function () {
                        let isChecked = $(this).prop('checked');
                        $('.row-checkbox').each(function () {
                            let rowId = $(this).data('id');
                            $(this).prop('checked', isChecked);
                            isChecked ? selectedRows.add(rowId) : selectedRows.delete(rowId);
                        });
                    });

                    $('.row-checkbox').off('change').on('change', function () {
                        let rowId = $(this).data('id');
                        $(this).prop('checked') ? selectedRows.add(rowId) : selectedRows.delete(rowId);
                    });
                }
            });
        }

        $('#save-places').click(function () {
            let selectedIds = [...selectedRows];
            if (selectedIds.length === 0) return alert('Please select at least one place.');

            let placesData = table.rows().data().toArray().filter(row => selectedRows.has(row.id)).map(row => ({
                id: row.id,
                name: $(`input.editable[data-id='${row.id}']`).val() || row.name,
                category_id: $(`select.category-select[data-id='${row.id}']`).val() || row.category_id || null,
                place_id: $(`select.place-select[data-id='${row.id}']`).val() || row.place_id || null,
                rating: row.rating,
                user_ratings_total: row.user_ratings_total
            }));

            $.post("{{ url('places/save') }}", { _token: "{{ csrf_token() }}", places: placesData })
                .done(() => {
                    alert("Data saved successfully!");
                    table.ajax.reload(null, false);
                })
                .fail(() => alert("Error saving data. Please try again."));
        });

        $('#crawl-form').submit(function (event) {
            event.preventDefault();
            $('#loading').show();

            let category = $('#category').val();
            let query = $('#place_id').val();

            $.post("{{ url('places/crawl') }}", { _token: "{{ csrf_token() }}", query, category })
                .done(() => {
                    alert("Crawling started successfully. Data will be updated soon.");
                    setTimeout(() => table.ajax.reload(null, false), 5000);
                })
                .fail((xhr) => alert("Error: " + (xhr.responseJSON?.error || 'An error occurred.')));
        });

        $('#delete-places').click(function () {
            let selectedIds = [...selectedRows];
            if (selectedIds.length === 0) return alert('Please select at least one place to delete.');
            if (!confirm('Are you sure you want to delete the selected places?')) return;

            $.ajax({
                url: "{{ url('places/delete') }}",
                type: "POST",
                contentType: "application/json",
                data: JSON.stringify({ _token: "{{ csrf_token() }}", place_ids: selectedIds })
            }).done(() => {
                alert("Selected places deleted successfully!");
                table.ajax.reload(null, false);
            }).fail(() => alert("Error deleting places. Please try again."));
        });
    });

</script>
@endsection