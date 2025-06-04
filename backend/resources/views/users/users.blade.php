@extends('layouts.child')
 
@section('title', ucwords($page))

@section('content')
<div class=" container-fluid" id="kt_content_container">
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
			<div class="card-toolbar flex-row-fluid justify-content-end gap-5"> </div>
		</div>
		<!--end::Header-->
		<!--begin::Body-->
		<div class="card-body">
			<!--begin::Table container-->
			<div class="table-responsive">
				<table id="kt_datatable" class="table table-striped table-row-bordered gy-5 gs-7">
				    <thead>
				        <tr class="fw-semibold fs-6 text-gray-800">
				            <th>Name</th>
				            <th>City</th>
				            <th>Contacts</th>
				            <th>Joined</th>
				            <th>Last Login</th>
				        </tr>
				    </thead>
				</table>
			</div>
			<!--end::Table-->
		</div>
		<!--end: Card Body-->
	</div>
</div>
@endsection

@section('modals')
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
					<div class="d-flex flex-column scroll-y px-5 px-lg-10" id="kt_modal_add_user_scroll" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_create_header" data-kt-scroll-wrappers="#kt_modal_add_user_scroll" data-kt-scroll-offset="300px" style="max-height: 83px;">
						<!--begin::Input group-->
						<div class="form-group row mb-7 fv-plugins-icon-container">
                            <div class="col-lg-6">
                                <label class="required fw-semibold fs-6 mb-2">First Name</label>
                                <div class="input-group">
                                    <input type="text" name="name" class="form-control form-control-solid mb-3 mb-lg-0">
                                </div>
                                @error('name')
                                <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-lg-6">
                                <label class="fw-semibold fs-6 mb-2">Last Name</label>
                                <div class="input-group">
                                    <input type="text" name="lname" class="form-control form-control-solid mb-3 mb-lg-0">
                                </div>
                                @error('lname')
                                <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
						<!--end::Input group-->

						<!--begin::Input group-->
						<div class="fv-row mb-7 fv-plugins-icon-container">
							<!--begin::Label-->
							<label class="required fw-semibold fs-6 mb-2">Email</label>
							<!--end::Label-->
							<!--begin::Input-->
							<input type="email" name="email" class="form-control form-control-solid mb-3 mb-lg-0" readonly>
							<!--end::Input-->
							<div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
						</div>
						<!--end::Input group-->

						<!--begin::Input group-->
						<div class="fv-row mb-7 fv-plugins-icon-container">
							<!--begin::Label-->
							<label class="required fw-semibold fs-6 mb-2">Phone</label>
							<!--end::Label-->
							<!--begin::Input-->
							<input type="text" name="phone" class="form-control form-control-solid mb-3 mb-lg-0" readonly>
						<!--end::Input-->

						<!--begin::Input group-->
						<div class="fv-row mb-7 fv-plugins-icon-container">
							<!--begin::Label-->
							<label class="fw-semibold fs-6 mb-2">City</label>
							<!--end::Label-->
							<!--begin::Input-->
							<input type="text" name="city" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Jakarta">
							<!--end::Input-->

						<!--begin::Input group-->
						<div class="mb-5">
							<!--begin::Label-->
							<label class="required fw-semibold fs-6 mb-5">Role</label>
							<!--end::Label-->
							<!--begin::Roles-->
							<!--begin::Input row-->
							@foreach($roles as $role)
							<div class="d-flex fv-row">
								<!--begin::Radio-->
								<div class="form-check form-check-custom form-check-solid">
									<!--begin::Input-->
									<input class="form-check-input me-3" name="role" type="radio" value="{{$role->name}}" id="role_{{$role->name}}">
									<!--end::Input-->
									<!--begin::Label-->
									<label class="form-check-label" for="kt_modal_create_role">
										<div class="fw-bold text-gray-800">{{$role->name}}</div>
									</label>
									<!--end::Label-->
								</div>
								<!--end::Radio-->
							</div>
							<!--end::Input row-->
							<div class="separator separator-dashed my-5"></div>
							@endforeach
							<!--end::Roles-->
						</div>
						<!--end::Input group-->
					</div>
					<!--end::Scroll-->
					<!--begin::Actions-->
					<div class="text-center pt-10">
						<button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal">Discard</button>
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
		$( document ).ready(function() {
			var table = $("#kt_datatable").DataTable({
				processing:true,
	            serverSide:false,
	            searching: true,
	            ajax:{
	                url:"{{url('dt/'.$page)}}",
	                type:"POST",
	                 headers: {
			            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Add the CSRF token from the meta tag
			        }
	            },
	            columns:[
	                { data: 'name', name: 'name' },
	                { data: 'city', name: 'city' },
	                { data: 'contacts', name: 'contacts' },
	                { data: 'created_at', name: 'created_at' },
	                { data: 'last_login_at', name: 'last_login_at' },
	            ],
	            columnDefs: [
	                // { visible: false, targets: 0},
	                { orderable: false, targets: -1 },
	                { type: 'date-dd-mmm-yyyy', targets: [-1]},
					{
	                    targets: 0,
	                    render: function (data, type, row) {
	                        return `<img src="${row.avatar}" class="w-35px me-3" alt="${row.name}">` + data;
	                    }
	                },
	                {
	                    targets: -1,
	                    render: function (data, type, row) {
	                        return `<a href="https://iplocation.io/ip/${row.last_login_ip_address}" target="_blank" class="text-gray-900 fw-bold text-hover-primary mb-1 fs-6">${row.last_login_ip_address}</a><span class="text-muted fw-semibold d-block">${row.last_login_at}</span>`;
	                    }
	                },
	            ],
	            order: [[0, 'asc']]
			});

			 // Search Datatable --- official docs reference: https://datatables.net/reference/api/search()
	        const filterSearch = document.querySelector('[data-kt-filter="search"]');
	        filterSearch.addEventListener('keyup', function (e) {
	            table.search(e.target.value).draw();
	        });
		});
	</script>
@endsection