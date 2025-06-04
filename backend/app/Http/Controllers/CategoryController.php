<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use jeremykenedy\LaravelLogger\App\Http\Traits\ActivityLogger;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Models\Category;
use App\Enums\CategoryType;
use DataTables;

class CategoryController extends Controller
{
    use ActivityLogger;

    private $page = 'categories';
	public function __construct() {
    	$this->model = new Category();
    }

   private function formFields($id = 0, $categories = [])
	{
	    if (empty($categories)) {
	        $categories = \App\Models\Category::whereStatus('active')->get()->pluck('name', 'id')->toArray();
	    }

	    return [
	        'name' => [
	            'type'        => 'text',
	            'label'       => 'Category Name',
	            'placeholder' => 'Enter category name',
	            'rules'       => 'required|unique:categories,name' . ($id ? ",$id" : '')
	        ],
	        'type' => [
	            'type' => 'select',
	            'label' => 'Type',
	            'placeholder' => 'Select type',
	            'options' => collect(CategoryType::cases())->mapWithKeys(fn($e) => [$e->value => ucfirst($e->name)])->toArray(),
				'rules' => 'required|in:' . implode(',', array_column(CategoryType::cases(), 'value')),
	        ],
	    ];
	}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $formFields = $this->formFields();
        return view($this->page)->with(['page' => $this->page, 'formFields' => $formFields]);
    }

    public function table()
	{
	    $data = $this->model->get();

	    return Datatables::of($data)
	        ->addColumn('name_label', function($res) {
	            return $res->name;
	        })
	        ->addColumn('status', function($res) {
			    $checked = $res->status === 'active' ? 'checked' : '';
			    return '<label class="form-check form-switch form-check-custom form-check-solid">
			                <input class="form-check-input setStatus" type="checkbox" value="1" '.$checked.' data-id="'.$res->id.'" />
			                <span class="form-check-label fw-semibold text-muted">
			                    Save Card
			                </span>
			            </label>';
			})
	        ->addColumn('updated_at', function($res) {
	            return $res->updated_at;
	        })
	        ->addColumn('action', function ($res) {
	            return '<button class="btn btn-icon btn-active-light-warning w-30px h-30px me-3 edit" data-id="'.$res->id.'" data-name="'.$res->name.'" data-bs-toggle="modal" data-bs-target="#kt_modal_update"><i class="ki-outline ki-pencil fs-3"></i></button>
	                    <button class="btn btn-icon btn-active-light-danger w-30px h-30px delete" data-id="'.$res->id.'" data-name="'.$res->name.'" data-kt-action="delete_row"><i class="ki-outline ki-trash fs-3"></i></button>';
	        })
	        ->rawColumns(['status', 'action'])
	        ->make(true);
	}


	public function store(Request $request): RedirectResponse
	{
	    $rules = collect($this->formFields())->mapWithKeys(fn($field, $key) => [$key => $field['rules']])->toArray();
	    $validator = Validator::make($request->all(), $rules);

	    if ($validator->fails()) {
	        return redirect()->route($this->page . '.index')
	            ->withErrors($validator)
	            ->withInput()
	            ->with(['type' => 'error', 'message' => "Error creating {$this->page}!"]);
	    }

	    $validated = $validator->validated();
	    $created = $this->model->create($validated);

	    if ($created) {
	        return redirect()->route($this->page . '.index')
	            ->with(['type' => 'success', 'message' => "New {$this->page} created successfully!"]);
	    }

	    return redirect()->route($this->page . '.index')
	        ->with(['type' => 'error', 'message' => "Error creating {$this->page}!"]);
	}


    private function getData()
    {
        return $this->model->whereStatus('active')->orderBy('name');
    }

    public function getLists()
    {
        return $this->getData()->get();
    }

     /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return $this->model->findOrFail($id);
    }

    public function updateStatus(Request $request)
    {
        $data = $this->model->find($request->id);
        if($data) {
        	$stat = $data->status == 'active' ? 'inactive':'active';
            $flag = $data->update(['status' => $stat ]);
            if($flag) {
            	return response()->json([
                    'type' => 'success',
                    'message' => $this->page.' status updated!'
                ]);
            }
        }
        return response()->json([
            'status' => 'error',
            'message' => 'Error updating status '.$this->page
        ]);
    }

	public function update(Request $request, string $id): RedirectResponse
	{
	    $rules = collect($this->formFields($id))
	        ->mapWithKeys(fn($field, $key) => [$key => $field['rules']])
	        ->toArray();

	    $validator = Validator::make($request->all(), $rules);

	    if ($validator->fails()) {
	        return redirect()->route($this->page . '.index')
	            ->withErrors($validator)
	            ->withInput();
	    }

	    $validated = $validator->validated();
	    $data = $this->model->findOrFail($id);

	    if (!$data) {
	        return redirect()->route($this->page . '.index')
	            ->with(['type' => 'error', 'message' => "Record not found!"]);
	    }
	    // Update data with the validated fields
	    $flag = $data->update($validated);

	    if ($flag) {
	        return redirect()->route($this->page . '.index')
	            ->with(['type' => 'success', 'message' => "{$this->page} updated!"]);
	    }

	    return redirect()->route($this->page . '.index')
	        ->with(['type' => 'error', 'message' => "Error updating {$this->page}!"]);
	}

    public function destroy(string $id)
	{
	    $data = $this->model->findOrFail($id);
	    if ($data) {
	        $flag = $data->delete();

	        if ($flag) {
	            return response()->json(['type' => 'success', 'message' => "{$this->page} deleted"]);
	        }
	    }
	    return response()->json(['type' => 'error', 'message' => "Error deleting {$this->page}"]);
	}
}
