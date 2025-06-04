<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use jeremykenedy\LaravelLogger\App\Http\Traits\ActivityLogger;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Models\Merchant;
use DataTables;

class MerchantController extends Controller
{
    use ActivityLogger;

    private $page = 'merchants';
    private $module = 'merchants';

	public function __construct() {
    	$this->model = new Merchant();
    }

    private function formFields($id = 0, $categories = [])
	{
	    return [
	        'name' => [
	            'type'        => 'text',
	            'label'       => 'Merchant Name',
	            'placeholder' => 'Enter merchant name',
	            'rules'       => 'required|string|max:255'
	        ],
	        'website' => [
	            'type'        => 'url',
	            'label'       => 'Website',
	            'placeholder' => 'Enter website URL',
	            'rules'       => 'nullable|url|max:255'
	        ],
	        'category_id' => [
	            'type'  => 'hidden', // Hidden input field
	            'label'  => 'category_id',
	            'rules' => 'required|exists:categories,id'
	        ]
	    ];
	}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = $categories = \App\Models\Category::whereStatus('active')->get();
        $places = $categories = \App\Models\Place::all();
        $formFields = $this->formFields();
        return view($this->module.'.'.$this->page)->with(['page' => $this->page, 'module' => $this->module, 'formFields' => $formFields, 'data' => $data, 'places' => $places]);
    }

    public function table()
	{
	    $fields = $this->formFields();
	    
	    // Eager load 'category' to optimize queries
	    $data = $this->model->with('category')->get();
	    $datatable = Datatables::of($data);

	    // Format numeric fields with 'thousand' class
	    foreach ($fields as $key => $field) {
	        if (isset($field['class']) && $field['class'] === 'thousand') {
	            $datatable->editColumn($key, function ($res) use ($key) {
	                return number_format($res->{$key}, 0, ',', '.');
	            });
	        }
	    }

	    $datatable->addColumn('category_id', function ($res) {
	            return optional($res->category)->name ?? '-'; // Handle null safely
	        })
	        ->addColumn('locations', function ($res) {
	            return $res->places->count();
	        })
	        ->addColumn('updated_at', function ($res) {
	            return $res->updated_at->format('Y-m-d H:i:s'); // Formatted date
	        })
	        ->addColumn('website', function($res){
                return '<a href="'.$res->website.'" target="_blank">'.$res->website.'</a>';
            })
	        ->addColumn('action', function ($res) {
	            return '<button class="btn btn-icon btn-active-light-warning w-30px h-30px me-3 edit" 
	                        data-id="'.$res->id.'" 
	                        data-name="'.$res->name.'" 
	                        data-bs-toggle="modal" 
	                        data-bs-target="#kt_modal_update">
	                        <i class="ki-outline ki-pencil fs-3"></i>
	                    </button>
	                    <button class="btn btn-icon btn-active-light-danger w-30px h-30px delete" 
	                        data-id="'.$res->id.'" 
	                        data-name="'.$res->name.'" 
	                        data-kt-action="delete_row">
	                        <i class="ki-outline ki-trash fs-3"></i>
	                    </button>';
	        })
	        ->rawColumns(['action', 'website']);

	    return $datatable->make(true);
	}


	public function store(Request $request): RedirectResponse
	{
	    $fields = $this->formFields();
	    $input = $request->all();
	    foreach ($fields as $name => $field) {
	        if (isset($field['convert']) && $field['convert'] === 'integer' && isset($input[$name])) {
	            $input[$name] = preg_replace('/[^\d]/', '', $input[$name]);
	        }
	    }
	    // Merge the cleaned data back into the request.
	    $request->merge($input);

	    // Build validation rules dynamically from the fields.
	    $rules = collect($fields)
	        ->mapWithKeys(fn($field, $key) => [$key => $field['rules']])
	        ->toArray();

	    $validator = Validator::make($request->all(), $rules);
	    if ($validator->fails()) {
	        return redirect()->back()
	            ->withErrors($validator)
	            ->withInput();
	    }

	    // Now validated input should be clean.
	    $validated = $validator->validated();
	    // Create the record.
	    $merchant = $this->model->create($validated);
	    
	    if ($merchant) {
	    	if (!empty($request->place_id)) {
		        $places = is_array($request->place_id) ? $request->place_id : [$request->place_id];
		        $merchant->places()->sync($places); // sync() prevents duplicates
		    }
	        return redirect()->back()->with(['type' => 'success', 'message' => 'Card specification created successfully!']);
	    }
	    return redirect()->back()->with(['type' => 'error', 'message' => 'Error creating card specification!']);
	}

    private function getData()
    {
        return $this->model->orderBy('name');
    }

     /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return $this->model->with('places')->findOrFail($id);
    }

	public function update(Request $request, string $id): RedirectResponse
	{
	    // Get dynamic field definitions (you can pass the $id if needed)
	    $fields = $this->formFields($id);

	    // Pre-clean the input values that use inputmask and need to be integers.
	    $input = $request->all();
	    foreach ($fields as $name => $field) {
	        if (isset($field['convert']) && $field['convert'] === 'integer' && isset($input[$name])) {
	            $input[$name] = preg_replace('/[^\d]/', '', $input[$name]); // Convert to plain integer
	        }
	    }
	    // Merge the cleaned data back into the request.
	    $request->merge($input);

	    // Build validation rules dynamically from the fields.
	    $rules = collect($fields)
	        ->mapWithKeys(fn($field, $key) => [$key => $field['rules']])
	        ->toArray();

	    $validator = Validator::make($request->all(), $rules);
	    if ($validator->fails()) {
	        return redirect()->back()
	            ->withErrors($validator)
	            ->withInput();
	    }

	    // Now validated input should be clean.
	    $validated = $validator->validated();
	    
	    // Optionally, cast integer fields explicitly
	    foreach ($fields as $name => $field) {
	        if (isset($field['convert']) && $field['convert'] === 'integer' && isset($validated[$name])) {
	            $validated[$name] = (int) $validated[$name];
	        }
	    }
	    
	    // Find the record and update it
	    $data = $this->model->findOrFail($id);
	    $updated = $data->update($validated);

	    // Sync places (Many-to-Many Relationship)
	    if ($request->has('place_id')) {
	        $data->places()->sync($request->place_id);
	    }

	    if ($updated) {
	        return redirect()->back()
	            ->with(['type' => 'success', 'message' => 'Card specification updated successfully!']);
	    }

	    return redirect()->back()
	        ->with(['type' => 'error', 'message' => 'Error updating card specification!']);
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
