<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use jeremykenedy\LaravelLogger\App\Http\Traits\ActivityLogger;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Models\Bank;
use DataTables;

class BankController extends Controller
{
    use ActivityLogger;

    private $page = 'banks';
    private $module = 'cards';
    private $dir;

	public function __construct() {
    	$this->model = new Bank();
     	$this->dir = 'public/images/' . $this->page . '/logos'; // ✅ Correct storage path
    }

    private function formFields($id=0)
    {
        return [
            'name' => [
                'type' => 'text',
                'label' => 'Bank Alias',
                'placeholder' => 'Enter bank alias',
                'rules' => 'required|min:3|unique:banks,name' . ($id ? ",$id" : '')
            ],
            'fullname' => [
                'type' => 'text',
                'label' => 'Full Name',
                'placeholder' => 'Enter full name',
                'rules' => 'required'
            ],
            'website' => [
                'type' => 'url',
                'label' => 'Website',
                'placeholder' => 'Enter website URL',
                'rules' => 'required|url'
            ],
            'phone' => [
                'type' => 'text',
                'label' => 'Phone',
                'placeholder' => 'Enter phone number',
                'rules' => 'required'
            ],
            'logo' => [
                'type' => 'file',
                'label' => 'Bank Logo',
                'rules' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
            ]
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $data = $this->getData()->get();
        $formFields = $this->formFields();
        return view($this->module.'.'.$this->page)->with(['page' => $this->page, 'module' => $this->module, 'formFields' => $formFields]);
    }

    public function table()
    {
        $data = $this->model->get();
        return Datatables::of($data)
            ->addColumn('name', function ($res) {
			    $logoUrl = asset('storage/' . $res->logo); // Use Laravel asset helper for public storage
			    return '<img src="' . $logoUrl . '" class="w-35px me-3" alt="' . e($res->name) . '" > ' . e($res->name);
			})
            ->addColumn('fullname', function($res){
                return $res->fullname;
            })
            ->addColumn('phone', function($res){
                return $res->phone;
            })
            ->addColumn('website', function($res){
                return '<a href="'.$res->website.'" target="_blank">'.$res->website.'</a>';
            })
            ->addColumn('updated_at', function($res){
                return $res->updated_at;
            })
            ->addColumn('action', function ($res) {
                return '<button class="btn btn-icon btn-active-light-warning w-30px h-30px me-3 edit" data-id="'.$res->id.'" data-name="'.$res->name.'" data-bs-toggle="modal" data-bs-target="#kt_modal_update"><i class="ki-outline ki-pencil fs-3"></i></button>
                        <button class="btn btn-icon btn-active-light-danger w-30px h-30px delete" data-id="'.$res->id.'" data-name="'.$res->name.'" data-kt-action="delete_row"><i class="ki-outline ki-trash fs-3"></i></button>';
            })
            ->rawColumns(['name', 'website', 'action'])
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

	    // Handle file upload
	    if ($request->hasFile('logo')) {
	        $file = $request->file('logo');

	        if ($file->isValid()) {
	            $directory = storage_path('app/public/images/' . $this->page . '/logos');

	            // Ensure the directory exists
	            if (!File::exists($directory)) {
	                File::makeDirectory($directory, 0777, true, true);
	            }
	            // Generate a unique filename
	            $fileName = time() . '_' . $file->getClientOriginalName();
	            $file->move($directory, $fileName);

	            // Save relative path to database
	            $validated['logo'] = 'images/' . $this->page . '/logos/' . $fileName;
	        } else {
	            return redirect()->route($this->page . '.index')
	                ->with(['type' => 'error', 'message' => "Error uploading logo!"]);
	        }
	    }

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
        return $this->model->orderBy('name');
    }

     /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return $this->model->findOrFail($id);
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
	    // Handle file upload
	    if ($request->hasFile('logo')) {
	        $file = $request->file('logo');

	        if ($file->isValid()) {
	            $storageDir = 'images/' . $this->page . '/logos'; // No 'public/' prefix
	            $fileName = time() . '_' . $file->getClientOriginalName();

	            // Ensure directory exists
	            Storage::disk('public')->makeDirectory($storageDir);

	            // Store file in 'public' disk
	            $filePath = $file->storeAs($storageDir, $fileName, 'public'); // FIXED
	            if ($filePath) {
	                $validated['logo'] = $filePath; // No need for str_replace

	                // Delete old logo if exists
	                if (!empty($data->logo) && Storage::disk('public')->exists($data->logo)) {
	                    Storage::disk('public')->delete($data->logo);
	                }
	            } else {
	                return redirect()->route($this->page . '.index')
	                    ->with(['type' => 'error', 'message' => "Error storing logo!"]);
	            }
	        } 
	        else {
	            return redirect()->route($this->page . '.index')
	                ->with(['type' => 'error', 'message' => "Invalid file upload!"]);
	        }
	    }

	    // Update data
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