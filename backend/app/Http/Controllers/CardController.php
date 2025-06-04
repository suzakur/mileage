<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use jeremykenedy\LaravelLogger\App\Http\Traits\ActivityLogger;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Models\Card;
use DataTables;
use Auth;

class CardController extends Controller
{
    use ActivityLogger;

    private $page = 'cards';
    private $module = 'cards';
    private $dir;

	public function __construct() {
    	$this->model = new Card();
     	$this->dir = 'public/images/' . $this->page ;
    }

    private function formFields($id = 0, $banks = [])
	{
	    if (empty($banks)) {
	        $banks = \App\Models\Bank::all()->mapWithKeys(function ($bank) {
	            return [$bank->id => "{$bank->name} ({$bank->fullname})"];
	        });
	    }
	    
	    return [
	        'name' => [
	            'type' => 'text',
	            'label' => 'Card Name',
	            'placeholder' => 'Enter card name',
	            'rules' => 'required|min:3|unique:cards,name' . ($id ? ",$id" : '')
	        ],
	        'bank_id' => [
	            'type' => 'select',
	            'label' => 'Bank',
	            'placeholder' => 'Select bank',
	            'options' => $banks, // Dynamic bank options
	            'rules' => 'required|exists:banks,id'
	        ],
	        'type' => [
	            'type' => 'select',
	            'label' => 'Card Type',
	            'placeholder' => 'Select card type',
	            'options' => [
	                'Debit'  => 'Debit', 
	                'Credit' => 'Credit', 
	                'Charge' => 'Charge', 
	                'QRIS'   => 'QRIS'
	            ],
	            'rules' => 'required|in:Debit,Credit,Charge,QRIS'
	        ],
	        'network' => [
	            'type' => 'select',
	            'label' => 'Network',
	            'placeholder' => 'Select network',
	            'options' => [
	                'Visa'      => 'Visa', 
	                'MasterCard'=> 'MasterCard', 
	                'Amex'      => 'Amex', 
	                'JCB'       => 'JCB', 
	                'UnionPay'  => 'UnionPay'
	            ],
	            'rules' => 'required|in:Visa,MasterCard,Amex,JCB,UnionPay'
	        ],
	        'tier' => [
	            'type' => 'select',
	            'label' => 'Tier',
	            'placeholder' => 'Select tier',
	            'options' => [
	                'Classic'       => 'Classic',
	                'Silver'        => 'Silver',
	                'Gold'          => 'Gold',
	                'Platinum'      => 'Platinum',
	                'Signature'     => 'Signature',
	                'Infinite'      => 'Infinite',
	                'Standard'      => 'Standard',
	                'World'         => 'World',
	                'World Elite'   => 'World Elite',
	                'Green'         => 'Green',
	                'The Class'     => 'The Class',
	                'International' => 'International'
	            ],
	            'rules' => 'required|in:Classic,Silver,Gold,Platinum,Signature,Infinite,Standard,World,World Elite,Green,The Class,International'
	        ],
	        'class' => [
	            'type' => 'select',
	            'label' => 'Card Class',
	            'placeholder' => 'Select card class',
	            'options' => [
	                'Starter' => 'Starter',
	                'Middle'  => 'Middle',
	                'Upper'   => 'Upper',
	                'Elite'   => 'Elite',
	                'Supreme' => 'Supreme'
	            ],
	            'rules' => 'required|in:Starter,Middle,Upper,Elite,Supreme'
	        ],
	        'card_number' => [
	            'type' => 'text',
	            'label' => 'Card Number (6-digit)',
	            'placeholder' => 'Enter 6-digit card number',
	            'rules' => 'required|digits:6|unique:cards,card_number' . ($id ? ",$id" : '')
	        ],
	        'link' => [
	            'type' => 'url',
	            'label' => 'Website',
	            'placeholder' => 'Enter link URL',
	            'rules' => 'nullable|url'
	        ],
	        'image' => [
	            'type' => 'file',
	            'label' => 'Card Image',
	            'rules' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
	        ],
	    ];
	}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $banks = \App\Models\Bank::all()->mapWithKeys(fn($bank) => [$bank->id => "{$bank->name} ({$bank->fullname})"]);
        $formFields = $this->formFields();
        return view($this->module.'.'.$this->page)->with(['page' => $this->page, 'module' => $this->module, 'formFields' => $formFields, 'banks' => $banks]);
    }

    public function table()
    {
        $data = $this->model->get();
        return Datatables::of($data)
			->addColumn('bank_id', function($res){
                return $res->bank->name;
            })
			->addColumn('image', function($res) {
        		return '<img src="' . asset('storage/' . $res->image) . '" style="max-width:200px">';
			})
            ->addColumn('link', function($res){
                return '<a href="'.$res->link.'" target="_blank">'.$res->link.'</a>';
            })
            ->addColumn('updated_at', function($res){
                return $res->updated_at;
            })
            ->addColumn('action', function ($res) {
                return '<button class="btn btn-icon btn-active-light-warning w-30px h-30px me-3 edit" data-id="'.$res->id.'" data-name="'.$res->name.'" data-bs-toggle="modal" data-bs-target="#kt_modal_update"><i class="ki-outline ki-pencil fs-3"></i></button>
                        <button class="btn btn-icon btn-active-light-danger w-30px h-30px delete" data-id="'.$res->id.'" data-name="'.$res->name.'" data-kt-action="delete_row"><i class="ki-outline ki-trash fs-3"></i></button>';
            })
            ->rawColumns(['link', 'image', 'action'])
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
	    // Handle file upload for "image"
	    if ($request->hasFile('image')) {
	        $file = $request->file('image');

	        if ($file->isValid()) {
	            $directory = storage_path('app/public/images/' . $this->page);

	            // Ensure the directory exists
	            if (!File::exists($directory)) {
	                File::makeDirectory($directory, 0777, true, true);
	            }
	            // Generate a unique filename
	            $fileName = time() . '_' . $file->getClientOriginalName();
	            $file->move($directory, $fileName);

	            // Save relative path to database under "image"
	            $validated['image'] = 'images/' . $this->page . '/' . $fileName;
	        } else {
	            return redirect()->route($this->page . '.index')
	                ->with(['type' => 'error', 'message' => "Error uploading image!"]);
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

	    // Handle file upload for "image"
	    if ($request->hasFile('image')) {
	        $file = $request->file('image');

	        if ($file->isValid()) {
	            $storageDir = 'images/' . $this->page; // Directory under the public disk
	            $originalName = $file->getClientOriginalName();
	            $fileName = time() . '_' . $originalName; // Build a unique file name

	            // Ensure the directory exists on the 'public' disk
	            Storage::disk('public')->makeDirectory($storageDir);

	            // Store file using storeAs on the public disk
	            $storedPath = $file->storeAs($storageDir, $fileName, 'public');
	            if ($storedPath) {
	                $validated['image'] = $storedPath;
	                
	                // Delete old image if it exists
	                if (!empty($data->image) && Storage::disk('public')->exists($data->image)) {
	                    Storage::disk('public')->delete($data->image);
	                }
	            } else {
	                return redirect()->route($this->page . '.index')
	                    ->with(['type' => 'error', 'message' => "Error storing image!"]);
	            }
	        } else {
	            return redirect()->route($this->page . '.index')
	                ->with(['type' => 'error', 'message' => "Invalid file upload!"]);
	        }
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
