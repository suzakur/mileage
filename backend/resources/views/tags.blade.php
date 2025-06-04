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
						<input type="text" data-kt-filter="search" class="form-control form-control-solid w-250px ps-14" placeholder="search table" />
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
					        <th>Name</th>
				            <th>Slug</th>
				            <th>Type</th>
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
				<h2 class="fw-bold">Add {{ucwords($page)}}</h2>
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
				<form class="form fv-plugins-bootstrap5 fv-plugins-framework" method="POST" action="{{route($page.'.store')}}">
					@csrf
					<!--begin::Scroll-->
					<div class="d-flex flex-column scroll-y px-5 px-lg-10" id="kt_modal_add_user_scroll" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_user_header" data-kt-scroll-wrappers="#kt_modal_add_user_scroll" data-kt-scroll-offset="300px" style="max-height: 83px;">
						<!--begin::Input group-->
						<div class="fv-row mb-7 fv-plugins-icon-container">
							<!--begin::Label-->
							<label class="required fw-semibold fs-6 mb-2">{{ucwords($page)}} Name</label>
							<!--end::Label-->
							<!--begin::Input-->
							<input type="text" name="name" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="name">
							<!--end::Input-->
							<div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
						</div>
						<!--end::Input group-->
						<div class="fv-row mb-7 fv-plugins-icon-container">
							<!--begin::Label-->
							<label class="required fw-semibold fs-6 mb-2">Slug</label>
							<!--end::Label-->
							<!--begin::Input-->
							<input type="text" name="slug" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Slug">
							<!--end::Input-->
							<div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
						</div>
						<!--end::Input group-->
						<div class="fv-row mb-7 fv-plugins-icon-container">
							<!--begin::Label-->
							<label class="fw-semibold fs-6 mb-2">Type</label>
							<!--end::Label-->
							<!--begin::Input-->
							 <select id="type" name="type" class="form-select form-select-solid" data-control="select2" data-dropdown-parent="#kt_modal_create" data-placeholder="Select an option" data-allow-clear="true">
					            @foreach($data as $tag)
					                <option value="{{ $tag->type }}">{{ $tag->type }}</option>
					            @endforeach
					        </select>							<!--end::Input-->
							<div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
						</div>
						<!--end::Input group-->
					</div>
					<!--begin::Actions-->
					<div class="text-center pt-10">
						<button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary" data-kt-users-modal-action="submit">
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
				<form class="form fv-plugins-bootstrap5 fv-plugins-framework" method="POST" action="">
					@csrf
					@method('PUT')
					<input type="hidden" name="id">
					<!--begin::Scroll-->
					<div class="d-flex flex-column scroll-y px-5 px-lg-10" id="kt_modal_add_user_scroll" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_user_header" data-kt-scroll-wrappers="#kt_modal_add_user_scroll" data-kt-scroll-offset="300px" style="max-height: 83px;">
						<!--begin::Input group-->
						<div class="fv-row mb-7 fv-plugins-icon-container">
							<!--begin::Label-->
							<label class="required fw-semibold fs-6 mb-2">{{ucwords($page)}} Name</label>
							<!--end::Label-->
							<!--begin::Input-->
							<input type="text" name="name" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="name">
							<!--end::Input-->
							<div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
						</div>
						<!--end::Input group-->
						<div class="fv-row mb-7 fv-plugins-icon-container">
							<!--begin::Label-->
							<label class="required fw-semibold fs-6 mb-2">Slug</label>
							<!--end::Label-->
							<!--begin::Input-->
							<input type="text" name="slug" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Slug">
							<!--end::Input-->
							<div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
						</div>
						<!--end::Input group-->
						<div class="fv-row mb-7 fv-plugins-icon-container">
							<!--begin::Label-->
							<label class="fw-semibold fs-6 mb-2">Type</label>
							<!--end::Label-->
							<!--begin::Input-->
							<select id="type_edit" name="type" class="form-select form-select-solid" data-control="select2" data-dropdown-parent="#kt_modal_update" data-placeholder="Select an option" data-allow-clear="true">
					            @foreach($data as $tag)
					                <option value="{{ $tag->type }}">{{ $tag->type }}</option>
					            @endforeach
					        </select>							<!--end::Input-->
							<div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
						</div>
						<!--end::Input group-->
					<!--end::Scroll-->
					</div>
					<!--end::Scroll-->
					<!--begin::Actions-->
					<div class="text-center pt-10">
						<button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary" data-kt-modal-action="submit">
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
		$( document ).ready(function() {
			table = $("#kt_datatable").DataTable({
				processing:true,
	            serverSide:false,
	            searching: true,
	            ajax:{
	                url:"{{url('dt/'.$page)}}",
	                type:"POST",
	                headers: {
			            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			        }
	            },
	            columns:[
	                { data: 'name', name: 'name' },
	                { data: 'slug', name: 'slug' },
	                { data: 'type', name: 'type' },
	                { data: 'updated_at', name: 'updated_at' },
	                { data: 'action', name: 'action' },
	            ],
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

	        $("#type").select2({
			  	tags: true
			});
		});

		$(document).on("click", ".edit", function () {
			var modal = $("#kt_modal_update");
			var id = $(this).data("id");
			var name = $(this).data("name");
			modal.find('.form').first().attr('action', "{{ url($page) }}"+"/"+id);
	        modal.find('#editName').html(name);
	        $.ajax({
	           	url:"{{url($page)}}"+"/"+id+"/edit",
	            type: 'GET',
	            dataType: 'json',
	            success: function(result) {
	            	
	                if(result != 0 ) {
	                	modal.find('[name="name"]').val(result.name.en);
	                	modal.find('[name="slug"]').val(result.slug.en);
	                	$("#type_edit").select2({
				            dropdownParent: modal, // Ensures dropdown stays inside modal
				            tags: true, // Allows adding new values
				            placeholder: "Select or add type",
				            allowClear: true
				        }).val(result.type).trigger("change");
	                }
	            }
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
	</script>
@endsection