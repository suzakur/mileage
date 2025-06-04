@extends('layouts.child')
 
@section('title', ucwords($page))

@section('content')
<div class=" container-fluid " id="kt_content_container">
    <div class="col-xl-12">
    	@if ($errors->any())
		    <div class="alert alert-danger">
		        <ul>
		            @foreach ($errors->all() as $error)
		                <li>{{ $error }}</li>
		            @endforeach
		        </ul>
		    </div>
		@endif
		<!--begin::Table widget 12-->
		<div class="card card-flush h-xl-100">
			<!--begin::Header-->
			<div class="card-header pt-7">
				<div class="card-title">
					<!--begin::Search-->
					<div class="d-flex align-items-center position-relative my-1">
						<input type="text" data-kt-filter="search" class="form-control form-control-solid w-250px ps-14" placeholder="search {{$page}}" />
					</div>
					<!--end::Search-->
					<!--begin::Export buttons-->
					<div id="kt_datatable_example_1_export" class="d-none"></div>
					<!--end::Export buttons-->
				</div>
				<!--begin::Title-->
				<h3 class="card-title align-items-start flex-column">
					<span class="card-label fw-bold text-gray-800">{{ucwords($page)}} List</span>
				</h3>
				<!--end::Title-->
				<!--begin::Toolbar-->
				<div class="card-toolbar">
					<a href="#" class="btn btn-success fw-semibold" data-bs-toggle="modal" data-bs-target="#kt_modal_create">New</a>
				</div>
				<!--end::Toolbar-->
			</div>
			<!--end::Header-->
			<!--begin::Body-->
			<div class="card-body">
				<!--begin::Table container-->
				<div class="table-responsive">
	                <table id="kt_datatable" class="table align-middle table-row-dashed fs-6 gy-5">
					    <thead>
					    <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
						 	@foreach ($formFields as $key => $field)
				                <th>{{ $field['label'] }}</th>
					        @endforeach
							<th>Category</th>
							<th>Locations</th>
							<th>Last Update</th>
							<th>Action</th>
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
		<!--end::Table widget 12-->
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
                <h2 class="fw-bold">Add {{ ucwords($page) }}</h2>
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
                <form id="createForm" class="form fv-plugins-bootstrap5 fv-plugins-framework" enctype="multipart/form-data" method="POST" action="{{ route($page.'.store') }}">
                    @csrf
                    <!--begin::Scroll-->
                    <div class="d-flex flex-column scroll-y px-5 px-lg-10" id="kt_modal_add_scroll" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_user_header" data-kt-scroll-wrappers="#kt_modal_add_scroll" data-kt-scroll-offset="300px" style="max-height: 83px;">
                        <!--begin::Input group-->
                      	@foreach ($formFields as $name => $field)
						    @continue($field['type'] === 'hidden') {{-- Skip hidden fields --}}

						    <div class="mb-3 fv-row">
						        <label for="{{ $name }}" class="form-label {{ str_contains($field['rules'], 'required') ? 'required' : '' }}">
						            {{ $field['label'] }}
						        </label>

						        @if ($field['type'] === 'select' && isset($field['options']))
						            <select name="{{ $name }}" id="{{ $name }}"
						                    class="form-control {{ $field['class'] ?? '' }} {{ $errors->has($name) ? 'is-invalid' : '' }}"
						                    {{ str_contains($field['rules'], 'required') ? 'required' : '' }}>
						                <option value="" disabled selected>{{ $field['placeholder'] ?? 'Select an option' }}</option>
						                @foreach ($field['options'] as $id => $label)
						                    <option value="{{ $id }}" {{ old($name) == $id ? 'selected' : '' }}>
						                        {{ $label }}
						                    </option>
						                @endforeach
						            </select>
						        @else
						            <input type="{{ $field['type'] }}"
						                   name="{{ $name }}"
						                   id="{{ $name }}"
						                   class="form-control {{ $field['class'] ?? '' }} {{ $errors->has($name) ? 'is-invalid' : '' }}"
						                   placeholder="{{ $field['placeholder'] ?? '' }}"
						                   value="{{ old($name) }}"
						                   {{ str_contains($field['rules'], 'required') ? 'required' : '' }}>
						        @endif

						        @error($name)
						            <div class="invalid-feedback">{{ $message }}</div>
						        @enderror
						    </div>
						@endforeach
						<div class="mb-3 fv-row">
							<label for="" class="form-label">Category</label>
		                    <select name="category_id" class="form-select form-select-solid" data-control="select2" data-dropdown-parent="#kt_modal_create" data-placeholder="Select an option" data-allow-clear="true">
		                        <option></option>
		                        @foreach($data as $d)
			                        <option value="{{$d->id}}">{{$d->name}}</option>
		                        @endforeach
		                    </select>
						</div>
						<div class="mb-3 fv-row">
							<label for="" class="form-label">Places</label>
		                    <select name="place_id" class="form-select form-select-solid" data-control="select2" data-dropdown-parent="#kt_modal_create" data-placeholder="Select an option" data-allow-clear="true">
		                        <option></option>
		                        @foreach($places as $place)
		                        	<option value="{{ $place->id }}">{{ $place->name }}</option>
		                        @endforeach
		                    </select>
						</div>
                    </div>
                    <!--begin::Actions-->
                    <div class="text-center pt-10">
                        <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal">Close</button>
                        <button id="create_submit" type="submit" class="btn btn-primary kt_button_indicator" data-kt-users-modal-action="submit">
                            <span class="indicator-label">Submit</span>
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

<div class="modal fade" id="kt_modal_update" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <div class="modal-header" id="kt_modal_create_header">
				<!--begin::Modal title-->
				<h2 class="fw-bold">Update {{ucwords($page)}} <span id="editName"></span></h2>
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
				<form id="editForm" class="form fv-plugins-bootstrap5 fv-plugins-framework" enctype="multipart/form-data" method="POST" action="">
					@csrf
					@method('PUT')
					<input type="hidden" name="id">
					<!--begin::Scroll-->
					<div class="d-flex flex-column scroll-y px-5 px-lg-10" id="kt_modal_edit_scroll" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_edit_header" data-kt-scroll-wrappers="#kt_modal_edit_scroll" data-kt-scroll-offset="300px" style="max-height: 83px;">
						@foreach ($formFields as $name => $field)
						    @continue($field['type'] === 'hidden') {{-- Skip hidden fields --}}
						    <div class="mb-3 fv-row">
						        <label for="{{ $name }}" class="form-label {{ str_contains($field['rules'], 'required') ? 'required' : '' }}">
						            {{ $field['label'] }}
						        </label>

						        @if ($field['type'] === 'select' && isset($field['options']))
						            <select name="{{ $name }}" id="{{ $name }}"
						                    class="form-control {{ $field['class'] ?? '' }} {{ $errors->has($name) ? 'is-invalid' : '' }}"
						                    {{ str_contains($field['rules'], 'required') ? 'required' : '' }}>
						                <option value="" disabled selected>{{ $field['placeholder'] ?? 'Select an option' }}</option>
						                @foreach ($field['options'] as $id => $label)
						                    <option value="{{ $id }}" {{ old($name) == $id ? 'selected' : '' }}>
						                        {{ $label }}
						                    </option>
						                @endforeach
						            </select>
						        @else
						            <input type="{{ $field['type'] }}"
						                   name="{{ $name }}"
						                   id="{{ $name }}"
						                   class="form-control {{ $field['class'] ?? '' }} {{ $errors->has($name) ? 'is-invalid' : '' }}"
						                   placeholder="{{ $field['placeholder'] ?? '' }}"
						                   value="{{ old($name) }}"
						                   {{ str_contains($field['rules'], 'required') ? 'required' : '' }}>
						        @endif

						        @error($name)
						            <div class="invalid-feedback">{{ $message }}</div>
						        @enderror
						    </div>
						@endforeach
						<div class="mb-3 fv-row">
							<label for="" class="form-label">Category</label>
		                    <select id="category_id" name="category_id" class="form-select form-select-solid" >
		                        <option></option>
		                        @foreach($data as $d)
			                        <option value="{{$d->id}}">{{$d->name}}</option>
		                        @endforeach
		                    </select>
						</div>
						<div class="mb-3 fv-row">
							<label for="" class="form-label">Places</label>
		                    <select id="place_id" name="place_id" class="form-select form-select-solid" data-control="select2" data-dropdown-parent="#kt_modal_update" data-placeholder="Select an option" data-allow-clear="true">
		                        <option></option>
		                        @foreach($places as $place)
		                        	<option value="{{ $place->id }}">{{ $place->name }}</option>
		                        @endforeach
		                    </select>
						</div>
					<!--end::Scroll-->
					</div>
					<!--end::Scroll-->
					<!--begin::Actions-->
					<div class="text-center pt-10">
						<button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal">Close</button>
						<button id="edit_submit" type="submit" class="btn btn-primary kt_button_indicator" data-kt-modal-action="submit">
							<span class="indicator-label">Submit</span>
							<span class="indicator-progress">Please wait...
							<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
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
	<script type="text/javascript">
		var table;
		var columns = [
		    @foreach ($formFields as $key => $field)
		        { data: '{{ $key }}', name: '{{ $key }}' },
		    @endforeach
		    { data: 'category_id', name: 'category_id' },
		    { data: 'locations', name: 'locations' },
		    { data: 'updated_at', name: 'updated_at' },
		    { data: 'action', name: 'action', orderable: false, searchable: false }
		];

		$( document ).ready(function() {
			table = $("#kt_datatable").DataTable({
				processing:true,
	            serverSide:false,
	            searching: true,
	            pageLength: pageLength,
	            lengthMenu: lengthMenu,
	            columns: columns,
	            ajax:{
	                url:"{{url('dt/'.$page)}}",
	                type:"POST",
	                headers: {
			            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			        }
	            },
	            columnDefs: [
	                // { visible: false, targets: 0},
	                { orderable: false, targets: -1 },
	                { type: 'date-dd-mmm-yyyy', targets: [-1]},
	            ],
	            order: [[0, 'asc']],
			});

	        const filterSearch = document.querySelector('[data-kt-filter="search"]');
	        filterSearch.addEventListener('keyup', function (e) {
	            table.search(e.target.value).draw();
	        });
		});

	    $(document).on("click", ".delete", function () {
	    	var id = $(this).data("id");
			var name = $(this).data("name");

			Swal.fire({
	            text: 'Are you sure you want to remove '+name+'?',
	            icon: 'danger',
	            buttonsStyling: false,
	            showCancelButton: true,
	            confirmButtonText: 'Yes',
	            cancelButtonText: 'No',
	            customClass: {
	                confirmButton: 'btn btn-danger',
	                cancelButton: 'btn btn-secondary',
	            }
	        }).then((result) => {
	            if (result.isConfirmed) {
	                $.ajax({
			           	url:"{{url($page)}}/"+id,
			            type: 'DELETE',
			            dataType: 'json',
			            data:{
					        'id': id,
					        '_token': '{{ csrf_token() }}',
					    },
			            success: function(result) {
			            	getToast(result.type, result.message);
			            	table.ajax.reload(); 
			            },
			        });
	            }
	        });
	    });

		document.addEventListener("DOMContentLoaded", function () {
		    let validationInstances = {};

		    function initializeValidation(formId, submitButtonId, fields) {
		        const form = document.getElementById(formId);
		        const submitButton = document.getElementById(submitButtonId);

		        if (!form || !submitButton) {
		            console.error(`Form or submit button not found for ${formId}`);
		            return;
		        }

		        // Destroy previous validation instance if it exists
		        if (validationInstances[formId]) {
		            validationInstances[formId].destroy();
		        }

		        // Initialize new validation instance
		        validationInstances[formId] = FormValidation.formValidation(form, {
		            fields: fields,
		            plugins: {
		                trigger: new FormValidation.plugins.Trigger(),
		                bootstrap5: new FormValidation.plugins.Bootstrap5({
		                    rowSelector: ".mb-3",
		                    eleInvalidClass: "is-invalid",
		                    eleValidClass: "",
		                }),
		                submitButton: new FormValidation.plugins.SubmitButton(),
		            },
		        });

		        // Handle form submission
		        submitButton.addEventListener("click", function (e) {
		            e.preventDefault();

		            validationInstances[formId].validate().then(function (status) {
		                if (status === "Valid") {
		                    form.submit();
		                }
		            });
		        });
		    }

		    // Define fields dynamically from Laravel
		    const formFields = {
		        @foreach ($formFields as $name => $field)
		            "{{ $name }}": {
		                validators: {
		                    @if (str_contains($field['rules'], 'required'))
		                        notEmpty: {
		                            message: "{{ $field['label'] }} is required",
		                        },
		                    @endif
		                },
		            },
		        @endforeach
		    };

		    // Initialize validation for create modal
		    initializeValidation("createForm", "create_submit", formFields);

		    // Handle Edit Modal Initialization
		    $(document).on("click", ".edit", function () {
		        var modal = $("#kt_modal_update");
		        var id = $(this).data("id");
		        var name = $(this).data("name");

		        modal.find('form').first().attr('action', "{{ url($page) }}"+"/"+id);
		        modal.find('#editName').html(name);

		        $.ajax({
		            url: "{{url($page)}}" + "/" + id + "/edit",
		            type: 'GET',
		            dataType: 'json',
		            success: function(result) {
		                if (result) {
		                    Object.keys(result).forEach(function (key) {
			                    let input =	 modal.find(`[name="${key}"]`);
			                    
			                    if (input.length) {
			                        // Check if it's a select2 field
			                        if (input.hasClass("select2")) {
			                            input.val(result[key]).trigger("change");
			                        } 
			                        // Check if it's a checkbox
			                        else if (input.attr("type") === "checkbox") {
			                            input.prop("checked", result[key] ? true : false);
			                        } 
			                        // Check if it's a file input (Do not set value for security reasons)
			                        else if (input.attr("type") === "file") {
			                            input.val(""); // Clear file input
			                        } 
			                        // Regular text, number, email, etc.
			                        else {
			                            input.val(result[key]);
			                        }
			                    }
			                });

			                $("#category_id").select2({
			                    dropdownParent: modal,
			                    tags: true,
			                    placeholder: "Select or add category",
			                    allowClear: true
			                });
			                $("#category_id").val(result.category_id).trigger("change");

			                $("#place_id").select2({
			                    dropdownParent: modal,
			                    tags: true,
			                    placeholder: "Select or add places",
			                    allowClear: true
			                });
			                console.log(result.places);
			                if (result.places && Array.isArray(result.places)) {
							    let placeIds = result.places.map(place => place.id); // Extract IDs
							    $("#place_id").val(placeIds).trigger("change");
							}
		                    // Initialize validation after data is loaded
		                    initializeValidation("editForm", "edit_submit", formFields);
		                }
		            }
		        });
		        modal.modal('show');
		    });

		    // Reset validation when the edit modal is closed
		    $("#kt_modal_update").on("hidden.bs.modal", function () {
		        if (validationInstances["editForm"]) {
		            validationInstances["editForm"].resetForm(true);
		        }
		    });
		});
    </script>
@endsection