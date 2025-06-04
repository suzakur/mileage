@extends('layouts.child')
 
@section('title', ucwords($page))

@section('content')
<div class=" container-fluid " id="kt_content_container">
	<div class="row">
		<div class="col-12">
			<div class="d-flex flex-stack mb-5">
			    <!--begin::Search-->
			    <div class="d-flex align-items-center position-relative my-1">
			        <i class="ki-duotone ki-magnifier fs-1 position-absolute ms-6"><span class="path1"></span><span class="path2"></span></i>
			        <input type="text" data-kt-filter="search" class="form-control form-control-solid w-250px ps-15" placeholder="Search Feature"/>
			    </div>
			    <!--end::Search-->
			    <!--begin::Toolbar-->
			    <div class="d-flex justify-content-end" data-kt-docs-table-toolbar="base">
			        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_1" data-bs-toggle="tooltip" title="New Feature">
			            <i class="ki-duotone ki-plus fs-2"></i>
			            Add Feature
			        </button>
			        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_3" data-bs-toggle="tooltip" title="New {{$page}}">
			            <i class="ki-duotone ki-plus fs-2"></i>
			            Add {{$page}}
			        </button>
			    </div>
			    <!--end::Toolbar-->
			</div>
			<!--end::Wrapper-->
			<!--begin::Datatable-->
			<table id="kt_datatable" class="table align-middle table-row-dashed fs-6 gy-5">
			    <thead>
			    <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
			        <th>Feature</th>
		            <th>Slug</th>
		            <th>Desc</th>
		            <th>Value</th>
		            <th>Resetable</th>
		            <th>Last Update</th>
		            <th>Action</th>
			    </tr>
			    </thead>
			    <tbody class="text-gray-600 fw-semibold">
			    </tbody>
			</table>
			<!--end::Datatable-->
		</div>
		<div class="col-12 mt-5">
			<div class="row">
				@foreach($data as $d)
				<div class="col-md-4">
		            <div class="card card-flush h-md-100">
		                <div class="card-header">
		                    <div class="card-title">
		                        <h2>{{ ucwords($d->name) }}</h2>
		                    </div>
		                     <div class="d-flex justify-content-end" data-kt-docs-table-toolbar="base">
		                     	 <label class="form-check form-switch form-check-custom form-check-solid">
		                     	 	@if($d->is_active)
							        <input class="form-check-input setStatus" type="checkbox"checked="checked" data-id="{{$d->id}}" />
							        @else
							        <input class="form-check-input setStatus" type="checkbox" data-id="{{$d->id}}" />
							        @endif
							    </label>
		                     </div>
		                </div>
		                <div class="card-body pt-1">
		                    <div class="d-flex flex-column text-gray-600">
		                        @foreach($d->features ?? [] as $feature)
		                            <div class="d-flex align-items-center py-2">
		                                <span class="bullet bg-primary me-3"></span>{{ ucfirst($feature->name) }}</div>
		                        @endforeach
		                        @if($d->features->count() ===0)
		                            <div class="d-flex align-items-center py-2">
		                                <span class='bullet bg-primary me-3'></span>
		                                <em>No Feature added...</em>
		                            </div>
		                        @endif
		                    </div>
		                </div>
		                <div class="card-footer flex-wrap pt-0">
		                    <button type="button" class="btn btn-light btn-active-light-warning my-1 edit" data-id="{{ $d->id }}" data-name="{{ $d->name }}"  data-bs-toggle="modal" data-bs-target="#kt_modal_4">Edit {{ucwords($page)}}</button>
		                    <button type="button" class="btn btn-light btn-active-light-danger my-1 delete" data-id="{{ $d->id }}" data-name="{{ $d->name }}">Delete</button>
		                </div>
		            </div>
		        </div>
		        @endforeach
			</div>
		</div>
	</div>
</div>
@endsection

@section('modals')
	<div class="modal fade" tabindex="-1" id="kt_modal_1">
	    <div class="modal-dialog modal-lg">
	        <div class="modal-content">
	            <div class="modal-header">
	                <h3 class="modal-title">New Features</h3>

	                <!--begin::Close-->
	                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
	                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
	                </div>
	                <!--end::Close-->
	            </div>
	            <form class="form fv-plugins-bootstrap5 fv-plugins-framework" method="POST" action="{{route('features.store')}}">
					@csrf
		            <div class="modal-body">
		            	<div class="row mb-10">
					        <label class="required fw-semibold fs-6 mb-2">Plan</label>
					        <select class="form-select" name="plan_id">
				        		@foreach($data as $d)
							    <option value="{{ $d->id }}">{{ ucwords($d->name) }} {{ ucwords($d->description) }}</option>
							    @endforeach
							</select>
							@error('plan_id')<span class="text-danger">{{ $message }}</span> @enderror
					    </div>
		            	<div class="row mb-10">
					        <label class="required fw-semibold fs-6 mb-2">Order</label>
					        <input type="number" name="sort_order" class="form-control form-control-solid mb-3 mb-lg-0" />
					        @error('sort_order')<span class="text-danger">{{ $message }}</span> @enderror
					    </div>
	                    <div class="row mb-10">
	                    	<div class="col-6">
	                    		<label class="required fw-semibold fs-6 mb-2">Name</label>
					        	<input type="text" name="name" class="form-control form-control-solid mb-3 mb-lg-0" />
					        	@error('name')<span class="text-danger">{{ $message }}</span> @enderror
	                    	</div>
	                    	<div class="col-6">
	                    		<label class="required fw-semibold fs-6 mb-2" required>Slug</label>
					        <input type="text" name="slug" class="form-control form-control-solid mb-3 mb-lg-0" />
	                    	</div>
					        @error('slug')<span class="text-danger">{{ $message }}</span> @enderror
					    </div>
					    <div class="row mb-10">
					        <label class="required fw-semibold fs-6 mb-2">Value</label>
					        <input type="text" name="value" class="form-control form-control-solid mb-3 mb-lg-0" value="1" />
					        @error('value')<span class="text-danger">{{ $message }}</span> @enderror
					    </div>
					    <div class="row mb-10">
					        <label class="fw-semibold fs-6 mb-2">Description</label>
					        <textarea name="description" class="form-control form-control-solid"></textarea>
					        @error('description')<span class="text-danger">{{ $message }}</span> @enderror
					    </div>
					    <div class="row mb-10">
					    	<div class="form-group col-md-9">
						      	<label for="inputEmail4">Resettable Period</label>
						      	<input type="number" name="resettable_period" class="form-control form-control-solid mb-3 mb-lg-0" />
						      	@error('resettable_period')<span class="text-danger">{{ $message }}</span> @enderror
						    </div>
						    <div class="form-group col-md-3">
								<select class="form-select" name="resettable_interval">
								    <option value="day">Day</option>
								    <option value="week">Week</option>
								    <option value="month">Month</option>
								    <option value="year">Year</option>
								</select>
								@error('resettable_interval')<span class="text-danger">{{ $message }}</span> @enderror
						    </div>
					    </div>
		            </div>
		            <div class="modal-footer">
		                <button type="submit" class="btn btn-primary kt_page_loading">Submit</button>
		            </div>
		        </form>
	        </div>
	    </div>
	</div>

	<div class="modal fade" tabindex="-1" id="kt_modal_2">
	    <div class="modal-dialog modal-lg">
	        <div class="modal-content">
	            <div class="modal-header">
	                <h3 class="modal-title">Update {{$page}} <span id="editName"></span></h3>

	                <!--begin::Close-->
	                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
	                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
	                </div>
	                <!--end::Close-->
	            </div>
	            <form class="form fv-plugins-bootstrap5 fv-plugins-framework" method="POST" action="">
					@csrf
					@method('PUT')
		            <div class="modal-body">
		            	<div class="row mb-10">
					        <label class="required fw-semibold fs-6 mb-2">Plan</label>
					        <select class="form-select" name="plan_id">
				        		@foreach($data as $d)
							    <option value="{{ $d->id }}">{{ ucwords($d->name) }} {{ ucwords($d->description) }}</option>
							    @endforeach
							</select>
							@error('plan_id')<span class="text-danger">{{ $message }}</span> @enderror
					    </div>
		            	<div class="row mb-10">
					        <label class="required fw-semibold fs-6 mb-2">Order</label>
					        <input type="number" name="sort_order" class="form-control form-control-solid mb-3 mb-lg-0" />
					        @error('sort_order')<span class="text-danger">{{ $message }}</span> @enderror
					    </div>
	                    <div class="row mb-10">
	                    	<div class="col-6">
	                    		<label class="required fw-semibold fs-6 mb-2">Name</label>
					        	<input type="text" name="name" class="form-control form-control-solid mb-3 mb-lg-0" />
					        	@error('name')<span class="text-danger">{{ $message }}</span> @enderror
	                    	</div>
	                    	<div class="col-6">
	                    		<label class="required fw-semibold fs-6 mb-2" required>Slug</label>
					        <input type="text" name="slug" class="form-control form-control-solid mb-3 mb-lg-0" />
	                    	</div>
					        @error('slug')<span class="text-danger">{{ $message }}</span> @enderror
					    </div>
					    <div class="row mb-10">
					        <label class="required fw-semibold fs-6 mb-2">Value</label>
					        <input type="text" name="value" class="form-control form-control-solid mb-3 mb-lg-0" value="1" />
					        @error('value')<span class="text-danger">{{ $message }}</span> @enderror
					    </div>
					    <div class="row mb-10">
					        <label class="fw-semibold fs-6 mb-2">Description</label>
					        <textarea name="description" class="form-control form-control-solid"></textarea>
					        @error('description')<span class="text-danger">{{ $message }}</span> @enderror
					    </div>
					    <div class="row mb-10">
					    	<div class="form-group col-md-9">
						      	<label for="inputEmail4">Resettable Period</label>
						      	<input type="number" name="resettable_period" class="form-control form-control-solid mb-3 mb-lg-0" />
						      	@error('resettable_period')<span class="text-danger">{{ $message }}</span> @enderror
						    </div>
						    <div class="form-group col-md-3">
								<select class="form-select" name="resettable_interval">
								    <option value="day">Day</option>
								    <option value="week">Week</option>
								    <option value="month">Month</option>
								    <option value="year">Year</option>
								</select>
								@error('resettable_interval')<span class="text-danger">{{ $message }}</span> @enderror
						    </div>
					    </div>
		            </div>
		            <div class="modal-footer">
		                <button type="submit" class="btn btn-warning kt_page_loading">Change</button>
		            </div>
		        </form>
	        </div>
	    </div>
	</div>

	<div class="modal fade" tabindex="-2" id="kt_modal_3">
	    <div class="modal-dialog modal-lg">
	        <div class="modal-content">
	            <div class="modal-header">
	                <h3 class="modal-title">New {{$page}}</h3>	

	                <!--begin::Close-->
	                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
	                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
	                </div>
	                <!--end::Close-->
	            </div>
	            <form class="form fv-plugins-bootstrap5 fv-plugins-framework" method="POST" action="{{route($page.'.store')}}">
					@csrf
		            <div class="modal-body">
	                    <div class="row mb-10">
	                    	<div class="form-group col-md-4">
						        <label class="required fw-semibold fs-6 mb-2">Order</label>
						        <input type="number" name="sort_order" class="form-control form-control-solid mb-3 mb-lg-0"/>
						    </div>
						    <div class="form-group col-md-4">
						        <label class="required fw-semibold fs-6 mb-2">Name</label>
						        <input type="text" name="name" class="form-control form-control-solid mb-3 mb-lg-0"/>
						    </div>
						    <div class="form-group col-md-4">
						        <label class="required fw-semibold fs-6 mb-2">Slug</label>
						        <input type="text" name="slug" class="form-control form-control-solid mb-3 mb-lg-0" />
						    </div>
					    </div>
					     <div class="fv-row mb-10">
					        <label class="fw-semibold fs-6 mb-2">Description</label>
					        <textarea name="description" class="form-control form-control-solid"></textarea>
					    </div>
					    <div class="row mb-10">
					    	<div class="form-group col-md-3">
						        <label class="required fw-semibold fs-6 mb-2">Price</label>
						        <input type="number" name="price" class="form-control form-control-solid mb-3 mb-lg-0"/>
						    </div>
						    <div class="form-group col-md-3">
						        <label class="required fw-semibold fs-6 mb-2">Signup Fee</label>
						        <input type="number" name="signup_fee" class="form-control form-control-solid mb-3 mb-lg-0" value="0"/>
						    </div>
						    <div class="form-group col-md-3">
						        <label class="fw-semibold fs-6 mb-2">Subs Limit</label>
						        <input type="number" name="active_subscribers_limit" class="form-control form-control-solid mb-3 mb-lg-0"/>
						    </div>
						    <div class="form-group col-md-3">
								<select class="form-select" name="currency">
								    <option value="idr" selected="selected">IDR</option>
								    <option value="usd">USD</option>
								</select>
						    </div>
					    </div>
					    <div class="row mb-10">
					    	<div class="form-group col-md-9">
						      	<label for="inputEmail4" class="required">Invoice Period</label>
						      	<input type="number" name="invoice_period" class="form-control form-control-solid mb-3 mb-lg-0" value="1"/>
						    </div>
						    <div class="form-group col-md-3">
								<select class="form-select" name="invoice_interval">
								    <option value="day">Day</option>
								    <option value="week">Week</option>
								    <option value="month">Month</option>
								    <option value="year">Year</option>
								</select>
							</div>
					    </div>

					    <div class="row mb-10">
					    	<div class="form-group col-md-9">
						      	<label for="inputEmail4" class="required">Trial Period</label>
						      	<input type="number" name="trial_period" class="form-control form-control-solid mb-3 mb-lg-0" value="0" />
						    </div>
						    <div class="form-group col-md-3">
								<select class="form-select" name="trial_interval">
								    <option value="day">Day</option>
								    <option value="week">Week</option>
								    <option value="month">Month</option>
								    <option value="year">Year</option>
								</select>
						    </div>
					    </div>

					    <div class="row mb-10">
					    	<div class="form-group col-md-9">
						      	<label for="inputEmail4" class="required">Grace Period</label>
						      	<input type="number" name="grace_period" class="form-control form-control-solid mb-3 mb-lg-0" value="0" />
						    </div>
						    <div class="form-group col-md-3">
								<select class="form-select" name="grace_interval">
								    <option value="day">Day</option>
								    <option value="week">Week</option>
								    <option value="month">Month</option>
								    <option value="year">Year</option>
								</select>
						    </div>
					    </div>
		            </div>
		            <div class="modal-footer">
		                <button type="submit" class="btn btn-primary kt_page_loading">Submit</button>
		            </div>
		        </form>
	        </div>
	    </div>
	</div>

	<div class="modal fade" tabindex="-3" id="kt_modal_4">
	    <div class="modal-dialog modal-lg">
	        <div class="modal-content">
	            <div class="modal-header">
	                <h3 class="modal-title">Update {{$page}} <span id="editName"></span></h3>	
	                <!--begin::Close-->
	                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
	                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
	                </div>
	                <!--end::Close-->
	            </div>
	            <form class="form fv-plugins-bootstrap5 fv-plugins-framework" method="POST" action="">
					@csrf
					@method('PUT')
		            <div class="modal-body">
	                    <div class="row mb-10">
	                    	<div class="form-group col-md-4">
						        <label class="required fw-semibold fs-6 mb-2">Order</label>
						        <input type="number" name="sort_order" class="form-control form-control-solid mb-3 mb-lg-0"/>
						    </div>
						    <div class="form-group col-md-4">
						        <label class="required fw-semibold fs-6 mb-2">Name</label>
						        <input type="text" name="name" class="form-control form-control-solid mb-3 mb-lg-0"/>
						    </div>
						    <div class="form-group col-md-4">
						        <label class="required fw-semibold fs-6 mb-2">Slug</label>
						        <input type="text" name="slug" class="form-control form-control-solid mb-3 mb-lg-0" />
						    </div>
					    </div>
					     <div class="fv-row mb-10">
					        <label class="fw-semibold fs-6 mb-2">Description</label>
					        <textarea name="description" class="form-control form-control-solid"></textarea>
					    </div>
					    <div class="row mb-10">
					    	<div class="form-group col-md-3">
						        <label class="required fw-semibold fs-6 mb-2">Price</label>
						        <input type="number" name="price" class="form-control form-control-solid mb-3 mb-lg-0"/>
						    </div>
						    <div class="form-group col-md-3">
						        <label class="required fw-semibold fs-6 mb-2">Signup Fee</label>
						        <input type="number" name="signup_fee" class="form-control form-control-solid mb-3 mb-lg-0" value="0"/>
						    </div>
						    <div class="form-group col-md-3">
						        <label class="fw-semibold fs-6 mb-2">Subs Limit</label>
						        <input type="number" name="active_subscribers_limit" class="form-control form-control-solid mb-3 mb-lg-0"/>
						    </div>
						    <div class="form-group col-md-3">
								<select class="form-select" name="currency">
								    <option value="idr" selected="selected">IDR</option>
								    <option value="usd">USD</option>
								</select>
						    </div>
					    </div>
					    <div class="row mb-10">
					    	<div class="form-group col-md-9">
						      	<label for="inputEmail4" class="required">Invoice Period</label>
						      	<input type="number" name="invoice_period" class="form-control form-control-solid mb-3 mb-lg-0" value="1"/>
						    </div>
						    <div class="form-group col-md-3">
						    	<select class="form-select" name="invoice_interval">
								    <option value="day">Day</option>
								    <option value="week">Week</option>
								    <option value="month">Month</option>
								    <option value="year">Year</option>
								</select>
						    </div>
					    </div>

					    <div class="row mb-10">
					    	<div class="form-group col-md-9">
						      	<label for="inputEmail4" class="required">Trial Period</label>
						      	<input type="number" name="trial_period" class="form-control form-control-solid mb-3 mb-lg-0" value="0" />
						    </div>
						    <div class="form-group col-md-3">
								<select class="form-select" name="trial_interval">
								    <option value="day">Day</option>
								    <option value="week">Week</option>
								    <option value="month">Month</option>
								    <option value="year">Year</option>
								</select>
						    </div>
					    </div>

					    <div class="row mb-10">
					    	<div class="form-group col-md-9">
						      	<label for="inputEmail4" class="required">Grace Period</label>
						      	<input type="number" name="grace_period" class="form-control form-control-solid mb-3 mb-lg-0" value="0" />
						    </div>
						    <div class="form-group col-md-3">
								<select class="form-select" name="grace_interval">
								    <option value="day">Day</option>
								    <option value="week">Week</option>
								    <option value="month">Month</option>
								    <option value="year">Year</option>
								</select>
						    </div>
					    </div>
		            </div>
		            <div class="modal-footer">
		                <button type="submit" class="btn btn-warning kt_page_loading">Change</button>
		            </div>
		        </form>
	        </div>
	    </div>
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
	                url:"{{url('dt/features')}}",
	                type:"POST",
	                headers: {
			            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			        }
	            },
	            columns:[
	                { data: 'name', name: 'name' },
	                { data: 'slug', name: 'slug' },
	                { data: 'description', name: 'description' },
	                { data: 'value', name: 'value' },
	                { data: 'resettable', name: 'resettable' },
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


		});

	$(document).on("click", ".edit", function () {
		var modal = $("#kt_modal_4");
		var id = $(this).data("id");
		var name = $(this).data("name");
		modal.find('.form').first().attr('action', "{{ url($page) }}/"+id);
        modal.find('#editName').html(name);
        $.ajax({
           	url:"{{url($page)}}"+"/"+id+"/edit",
            type: 'GET',
            dataType: 'json',
            success: function(result) {
                if(result != 0 ) {
                	modal.find('[name="slug"]').val(result.slug);
                	modal.find('[name="name"]').val(result.name);
                	modal.find('[name="price"]').val(result.price);
                	modal.find('[name="sort_order"]').val(result.sort_order);
                	modal.find('[name="active_subscribers_limit"]').val(result.active_subscribers_limit);
                	modal.find('[name="currency"]').val(result.currency);
                	modal.find('[name="invoice_period"]').val(result.invoice_period);
                	modal.find('[name="invoice_interval"]').val(result.invoice_interval);
                	modal.find('[name="trial_period"]').val(result.trial_period);
                	modal.find('[name="trial_interval"]').val(result.trial_interval);
                	modal.find('[name="grace_period"]').val(result.grace_period);
                	modal.find('[name="grace_interval"]').val(result.grace_interval);
                }
            }
        });
    });

	$(document).on("click", ".setStatus", function () {
        $.ajax({
	       	url:"{{url('')}}/status/{{$page}}",
	        type: 'POST',
	        dataType: 'json',
	        data:{
		        'id': $(this).data("id"),
		        '_token': '{{ csrf_token() }}',
		    },
	        success: function(result) {
	        	getToast(result.type, result.message);
	        },
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
		            	setTimeout( function() {
						    location.reload(true);
						  }, 1000);
		            	 
		            },
		        });
            }
        });
    });

    $(document).on("click", ".editFeature", function () {
		var modal = $("#kt_modal_2");
		var id = $(this).data("id");
		var name = $(this).data("name");
		modal.find('.form').first().attr('action', "features/"+id);
        modal.find('#editName').html(name);
        $.ajax({
           	url:"{{url('')}}"+"/features/"+id+"/edit",
            type: 'GET',
            dataType: 'json',
            success: function(result) {
                if(result != 0 ) {
                	modal.find('[name="slug"]').val(result.slug);
                	modal.find('[name="name"]').val(result.name);
                	modal.find('[name="value"]').val(result.value);
                	modal.find('[name="sort_order"]').val(result.sort_order);
                	modal.find('[name="resettable_period"]').val(result.resettable_period);
                	modal.find('[name="resettable_interval"]').val(result.resettable_interval);
                }
            }
        });
    });

    $(document).on("click", ".deleteFeature", function () {
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
		           	url:"{{url('')}}/features/"+id,
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