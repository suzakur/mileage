<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use jeremykenedy\LaravelLogger\App\Http\Traits\ActivityLogger;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Models\CardSpec;
use DataTables;

class SpecController extends Controller
{
    use ActivityLogger;

    private $page = 'specs';
    private $module = 'cards';

	public function __construct() {
    	$this->model = new CardSpec();
    }

    private function formFields($id = 0, $cards = [])
	{
	    if (empty($cards)) {
	        $cards = \App\Models\Card::all()->mapWithKeys(function ($card) {
	            return [$card->id => "{$card->name} ({$card->network} {$card->tier})"];
	        });
	    }

	    return [
	        'card_id' => [
	            'type'        => 'select',
	            'label'       => 'Card',
	            'placeholder' => 'Select card',
	            'options'     => $cards,
	            'rules'       => 'required|exists:cards,id'
	        ],
	        'annual_fee' => [
	            'type'        => 'text',  // Use text to allow masked input (thousands separator, prefix, etc.)
	            'label'       => 'Annual Fee',
	            'placeholder' => 'Enter annual fee',
	            'rules'       => 'required|integer|min:0',
	            'class'       => 'thousand',
	            'convert'     => 'integer' // Flag for conversion in controller
	        ],
	        'suplement_fee' => [
	            'type'        => 'text',
	            'label'       => 'Supplement Fee',
	            'placeholder' => 'Enter supplement fee',
	            'rules'       => 'required|integer|min:0',
	            'class'       => 'thousand',
	            'convert'     => 'integer'
	        ],
	        'rate' => [
	            'type'        => 'number',
	            'label'       => 'Rate',
	            'placeholder' => 'Enter rate',
	            'rules'       => 'required|numeric'
	        ],
	        'penalty_fee' => [
	            'type'        => 'text',
	            'label'       => 'Penalty Fee',
	            'placeholder' => 'Enter penalty fee',
	            'rules'       => 'required',
	            'class'       => 'thousand'
	        ],
	        'admin_fee' => [
	            'type'        => 'text',
	            'label'       => 'Admin Fee',
	            'placeholder' => 'Enter admin fee',
	            'rules'       => 'required'
	        ],
	        'advance_cash_fee' => [
	            'type'        => 'text',
	            'label'       => 'Advance Cash Fee',
	            'placeholder' => 'Enter advance cash fee',
	            'rules'       => 'required'
	        ],
	        'replacement_fee' => [
	            'type'        => 'text',
	            'label'       => 'Replacement Fee',
	            'placeholder' => 'Enter replacement fee',
	            'rules'       => 'required'
	        ],
	        'minimum_limit' => [
	            'type'        => 'text',
	            'label'       => 'Minimum Limit',
	            'placeholder' => 'Enter minimum limit',
	            'rules'       => 'required|integer|min:0',
	            'class'       => 'thousand',
	            'convert'     => 'integer'
	        ],
	        'minimum_salary' => [
	            'type'        => 'text',
	            'label'       => 'Minimum Salary',
	            'placeholder' => 'Enter minimum salary',
	            'rules'       => 'required|integer|min:0',
	            'class'       => 'thousand',
	            'convert'     => 'integer'
	        ],
	        'maximum_age' => [
	            'type'        => 'number',
	            'label'       => 'Maximum Age',
	            'placeholder' => 'Enter maximum age',
	            'rules'       => 'required|integer|min:0'
	        ],
	    ];
	}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = \App\Models\Bank::all()->mapWithKeys(fn($card) => [$card->id => "{$card->name} ({$card->network} {$card->tier})"]);
        $formFields = $this->formFields();
        return view($this->module.'.'.$this->page)->with(['page' => $this->page, 'module' => $this->module, 'formFields' => $formFields, 'data' => $data]);
    }

    public function table()
	{
	    $fields = $this->formFields();
	    // Eager load the 'card' relationship so that each row has the related card data.
	    $data = $this->model->with('card')->get();
	    $datatable = Datatables::of($data);

	    // Loop through dynamic fields and apply formatting for fields with 'thousand' class
	    foreach ($fields as $key => $field) {
	        if (isset($field['class']) && $field['class'] === 'thousand') {
	            $datatable->editColumn($key, function ($res) use ($key) {
	                return number_format($res->{$key}, 0, ',', '.');
	            });
	        }
	    }

	    $datatable->addColumn('card_id', function($res) {
	            // Now $res->card is available because of eager loading
	            return $res->card->name;
	        })
	        ->addColumn('image', function($res) {
	            return '<img src="' . asset('storage/' . $res->image) . '" style="max-width:200px">';
	        })
	        ->addColumn('link', function($res) {
	            return '<a href="'.$res->link.'" target="_blank">'.$res->link.'</a>';
	        })
	        ->addColumn('updated_at', function($res) {
	            return $res->updated_at;
	        })
	        ->addColumn('action', function ($res) {
	            return '<button class="btn btn-icon btn-active-light-warning w-30px h-30px me-3 edit" data-id="'.$res->id.'" data-name="'.$res->name.'" data-bs-toggle="modal" data-bs-target="#kt_modal_update"><i class="ki-outline ki-pencil fs-3"></i></button>
	                    <button class="btn btn-icon btn-active-light-danger w-30px h-30px delete" data-id="'.$res->id.'" data-name="'.$res->name.'" data-kt-action="delete_row"><i class="ki-outline ki-trash fs-3"></i></button>';
	        })
	        ->rawColumns(['link', 'image', 'action']);

	    return $datatable->make(true);
	}


	public function store(Request $request): RedirectResponse
	{
	    // Get dynamic field definitions
	    $fields = $this->formFields();

	    // Pre-clean the input values that use inputmask and need to be integers.
	    // This should be done before validation.
	    $input = $request->all();
	    foreach ($fields as $name => $field) {
	        if (isset($field['convert']) && $field['convert'] === 'integer' && isset($input[$name])) {
	            // Remove any character that is not a digit.
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
	    
	    // Optionally, cast these fields to integer explicitly.
	    foreach ($fields as $name => $field) {
	        if (isset($field['convert']) && $field['convert'] === 'integer' && isset($validated[$name])) {
	            $validated[$name] = (int) $validated[$name];
	        }
	    }
	    
	    // Create the record.
	    $created = $this->model->create($validated);
	    
	    if ($created) {
	        return redirect()->back()
	            ->with(['type' => 'success', 'message' => 'Card specification created successfully!']);
	    }
	    
	    return redirect()->back()
	        ->with(['type' => 'error', 'message' => 'Error creating card specification!']);
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
	    // Get dynamic field definitions (you can pass the $id if needed)
	    $fields = $this->formFields($id);

	    // Pre-clean the input values that use inputmask and need to be integers.
	    // This should be done before validation.
	    $input = $request->all();
	    foreach ($fields as $name => $field) {
	        if (isset($field['convert']) && $field['convert'] === 'integer' && isset($input[$name])) {
	            // Remove any character that is not a digit (e.g. "Rp 1.234.567" becomes "1234567")
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
	    
	    // Optionally, cast these fields to integer explicitly.
	    foreach ($fields as $name => $field) {
	        if (isset($field['convert']) && $field['convert'] === 'integer' && isset($validated[$name])) {
	            $validated[$name] = (int) $validated[$name];
	        }
	    }
	    
	    // Find the record and update it.
	    $cardSpec = CardSpec::findOrFail($id);
	    $updated = $cardSpec->update($validated);
	    
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
