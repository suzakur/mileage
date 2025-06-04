@extends('layouts.child')
 
@section('title', ucwords($page))

@section('content')
<div class=" container-fluid" id="kt_content_container">
	<div class="row">
		<div class="col-xl-12">
		<!--begin::Table widget 12-->
		<div class="card card-flush h-xl-100">
			<!--begin::Header-->
			<div class="card-header pt-7">
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
				<div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-5 g-xl-9">
			    @foreach($roles as $role)
			        <!--begin::Col-->
			        <div class="col-md-4">
			            <!--begin::Card-->
			            <div class="card card-flush h-md-100">
			                <!--begin::Card header-->
			                <div class="card-header">
			                    <!--begin::Card title-->
			                    <div class="card-title">
			                        <h2>{{ ucwords($role->name) }}</h2>
			                    </div>
			                    <!--end::Card title-->
			                </div>
			                <!--end::Card header-->
			                <!--begin::Card body-->
			                <div class="card-body pt-1">
			                    <!--begin::Users-->
			                    <div class="fw-bold text-gray-600 mb-5">Total users with this role: {{ $role->users->count() }}</div>
			                    <!--end::Users-->
			                    <!--begin::Permissions-->
			                    <div class="d-flex flex-column text-gray-600">
			                       @foreach($role->permissions->groupBy('group_name') as $groupName => $pgroup)
									    <div class="d-flex align-items-center py-2">
									        <span class="bullet bg-primary me-3"></span>
									        {{ ucfirst($groupName) }}
									    </div>
									    @foreach($pgroup as $permission)
									            {{ ucfirst(explode('-', $permission->name)[0]) }}, 
									    @endforeach
									@endforeach

			                        @if($role->permissions->count() ===0)
			                            <div class="d-flex align-items-center py-2">
			                                <span class='bullet bg-primary me-3'></span>
			                                <em>No permissions given...</em>
			                            </div>
			                        @endif
			                    </div>
			                    <!--end::Permissions-->
			                </div>
			                <!--end::Card body-->
			                <!--begin::Card footer-->
			                <div class="card-footer flex-wrap pt-0">
			                    <button type="button" class="btn btn-light btn-active-light-warning my-1 edit" data-id="{{ $role->id }}" data-name="{{ $role->name }}"  data-bs-toggle="modal" data-bs-target="#kt_modal_update">Edit {{ucwords($page)}}</button>
			                    <button type="button" class="btn btn-light btn-active-light-danger my-1 delete" data-id="{{ $role->id }}" data-name="{{ $role->name }}">Delete</button>
			                </div>
			                <!--end::Card footer-->
			            </div>
			            <!--end::Card-->
			        </div>
			        <!--end::Col-->
			    @endforeach
			</div>
			<!--end: Card Body-->
		</div>
		<!--end::Table widget 12-->
		</div>
		</div>
	</div>
</div>
@endsection

@section('modals')
<div class="modal fade" id="kt_modal_create" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-xl">
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
							<input type="text" name="name" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Full name">
						<!--end::Input-->
						<div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div></div>
						<!--end::Input group-->
						<!--begin::Input group-->
						<div class="fv-row mb-7 fv-plugins-icon-container">
							<!--begin::Label-->
							<label class="required fw-semibold fs-6 mb-2">Guard Name</label>
							<!--end::Label-->
							<!--begin::Input-->
							<input type="text" name="guard_name" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Guard name" value="web">
						<!--end::Input-->
						<div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div></div>
						<!--end::Input group-->
						<!--begin::Permissions-->
                        <div class="fv-row">
                            <!--begin::Label-->
                            <label class="fs-5 fw-bold form-label mb-2">Role Permissions</label>
                            <!--end::Label-->
                            <!--begin::Table wrapper-->
                            <div class="table-responsive">
                                <!--begin::Table-->
                                <table class="table align-middle table-row-dashed fs-6 gy-5">
                                    <!--begin::Table body-->
                                    <tbody class="text-gray-600 fw-semibold">
                                    <!--begin::Table row-->
                                    <tr>
                                        <td class="text-gray-800">Administrator Access
                                            <span class="ms-1" data-bs-toggle="tooltip" title="Allows a full access to the system">
                                            </span>
                                        </td>
                                        <td>
                                            <!--begin::Checkbox-->
                                            <label class="form-check form-check-sm form-check-custom form-check-solid me-9">
                                                <input class="form-check-input kt_select_all" type="checkbox"/>
                                                <span class="form-check-label" for="kt_select_all">Select all</span>
                                            </label>
                                            <!--end::Checkbox-->
                                        </td>
                                    </tr>
                                    <!--end::Table row-->
                                    @foreach($permissions_by_group as $group => $permissions)
                                        <!--begin::Table row-->
                                        <tr>
                                            <!--begin::Label-->
                                            <td class="text-gray-800">{{ ucwords($group) }}</td>
                                            <!--end::Label-->
                                            <!--begin::Input group-->
                                            @foreach($permissions as $permission)
                                                <td>
                                                    <!--begin::Wrapper-->
                                                    <div class="d-flex">
                                                        <!--begin::Checkbox-->
                                                        <label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                                            <input class="form-check-input" name="permissions[]" type="checkbox" value="{{ $permission->id }}"/>
                                                            <span class="form-check-label">{{ ucwords(Str::before($permission->name, '-')) }}</span>
                                                        </label>
                                                        <!--end::Checkbox-->
                                                    </div>
                                                    <!--end::Wrapper-->
                                                </td>
                                            @endforeach
                                            <!--end::Input group-->
                                        </tr>
                                        <!--end::Table row-->
                                    @endforeach
                                    <!--begin::Table row-->
                                    </tbody>
                                    <!--end::Table body-->
                                </table>
                                <!--end::Table-->
                            </div>
                            <!--end::Table wrapper-->
                        </div>
                        <!--end::Permissions-->
					</div>
					<!--end::Scroll-->
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
    <div class="modal-dialog modal-xl">
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
							<input type="text" name="name" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Full name">
						<!--end::Input-->
						<div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div></div>
						<!--end::Input group-->
						<!--begin::Input group-->
						<div class="fv-row mb-7 fv-plugins-icon-container">
							<!--begin::Label-->
							<label class="required fw-semibold fs-6 mb-2">Guard Name</label>
							<!--end::Label-->
							<!--begin::Input-->
							<input type="text" name="guard_name" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Guard name" value="web">
						<!--end::Input-->
						<div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div></div>
						<!--end::Input group-->
						<!--begin::Permissions-->
                        <div class="fv-row">
                            <!--begin::Label-->
                            <label class="fs-5 fw-bold form-label mb-2">Role Permissions</label>
                            <!--end::Label-->
                            <!--begin::Table wrapper-->
                            <div class="table-responsive">
                                <!--begin::Table-->
                                <table class="table align-middle table-row-dashed fs-6 gy-5">
                                    <!--begin::Table body-->
                                    <tbody class="text-gray-600 fw-semibold">
                                    <!--begin::Table row-->
                                    <tr>
                                        <td class="text-gray-800">Administrator Access
                                            <span class="ms-1" data-bs-toggle="tooltip" title="Allows a full access to the system">
                                            </span>
                                        </td>
                                        <td>
                                            <!--begin::Checkbox-->
                                            <label class="form-check form-check-sm form-check-custom form-check-solid me-9">
                                                <input class="form-check-input kt_select_all" type="checkbox"/>
                                                <span class="form-check-label" for="kt_select_all">Select all</span>
                                            </label>
                                            <!--end::Checkbox-->
                                        </td>
                                    </tr>
                                    <!--end::Table row-->
                                    @foreach($permissions_by_group as $group => $permissions)
                                        <!--begin::Table row-->
                                        <tr>
                                            <!--begin::Label-->
                                            <td class="text-gray-800">{{ ucwords($group) }}</td>
                                            <!--end::Label-->
                                            <!--begin::Input group-->
                                            @foreach($permissions as $permission)
                                                <td>
                                                    <!--begin::Wrapper-->
                                                    <div class="d-flex">
                                                        <!--begin::Checkbox-->
                                                        <label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                                            <input class="form-check-input" type="checkbox" name="permissions[]" id="p{{$permission->id}}" value="{{ $permission->id }}"/>
                                                            <span class="form-check-label">{{ ucwords(Str::before($permission->name, '-')) }}</span>
                                                        </label>
                                                        <!--end::Checkbox-->
                                                    </div>
                                                    <!--end::Wrapper-->
                                                </td>
                                            @endforeach
                                            <!--end::Input group-->
                                        </tr>
                                        <!--end::Table row-->
                                    @endforeach
                                    <!--begin::Table row-->
                                    </tbody>
                                    <!--end::Table body-->
                                </table>
                                <!--end::Table-->
                            </div>
                            <!--end::Table wrapper-->
                        </div>
                        <!--end::Permissions-->
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
<script type="text/javascript">
	$(document).on("click", ".kt_select_all", function () {
		console.log($(this).parents('table').find(':checkbox'));
	    $(this).parents('table').find(':checkbox').not(this).attr('checked', this.checked);
	});

	$(document).on("click", ".edit", function () {
		var modal = $("#kt_modal_update");
		var id = $(this).data("id");
		var name = $(this).data("name");

		modal.find('.form').first().attr('action', "{{ url($page) }}"+"/"+id);
        modal.find('#editName').html(name);
        modal.find(':checkbox').attr('checked', false);
  
        $.ajax({
           	url:"{{url($page)}}"+"/"+id+"/edit",
            type: 'GET',
            dataType: 'json',
            success: function(result) {
                if(result != null ) {
                	modal.find('[name="name"]').val(result.role.name);
                	modal.find('[name="guard_name"]').val(result.role.guard_name);
                	$.each( result.checked, function( key, value ) {
                		$("#p"+value).attr('checked','checked');
					});
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
		            },
		        });
            }
        });
    });
</script>
@endsection