<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use jeremykenedy\LaravelLogger\App\Http\Traits\ActivityLogger;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Models\CardPerk;
use DataTables;

class CardPerkController extends Controller
{
    use ActivityLogger;

    private $page = 'cardperks';
    private $module = 'cards';

	public function __construct() {
    	$this->model = new CardPerk();
    }

    private function formFields($id = 0, $cards = [], $perks = [])
	{
	    // Get dynamic options for cards if not provided.
	    if (empty($cards)) {
	        $cards = \App\Models\Card::all()->mapWithKeys(function ($card) {
	            // You can adjust the display text as needed.
	            return [$card->id => "{$card->name} ({$card->network} {$card->tier})"];
	        })->toArray();
	    }

	    // Get dynamic options for perks if not provided.
	    if (empty($perks)) {
	        $perks = \App\Models\Perk::all()->mapWithKeys(function ($perk) {
	            return [$perk->id => $perk->name];
	        })->toArray();
	    }

	    return [
	        'card_id' => [
	            'type'        => 'select',
	            'label'       => 'Card',
	            'placeholder' => 'Select card',
	            'options'     => $cards,
	            'rules'       => 'required|exists:cards,id'
	        ],
	        'perk_id' => [
	            'type'        => 'select',
	            'label'       => 'Perk',
	            'placeholder' => 'Select perk',
	            'options'     => $perks,
	            'rules'       => 'required|exists:perks,id'
	        ],
	        'formulas' => [
	            'type'        => 'textarea',
	            'label'       => 'Offer',
	            'placeholder' => 'Enter formulas details',
	            'rules'       => 'required'
	        ],
	        'start' => [
	            'type'        => 'date',
	            'label'       => 'Start Date',
	            'placeholder' => 'Select start date',
	            'rules'       => 'nullable|date'
	        ],
	        'end' => [
	            'type'        => 'date',
	            'label'       => 'End Date',
	            'placeholder' => 'Select end date',
	            'rules'       => 'nullable|date'
	        ],
	    ];
	}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $data = \App\Models\Bank::all()->mapWithKeys(fn($card) => [$card->id => "{$card->name} ({$card->network} {$card->tier})"]);
        $formFields = $this->formFields();
        return view($this->module.'.'.$this->page)->with(['page' => $this->page, 'module' => $this->module, 'formFields' => $formFields]);
    }

    public function table()
	{
	    $fields = $this->formFields();
	    // Eager load 'card' so that each $res->card is available.
	    $data = $this->model->with('card')->get();
	    $datatable = Datatables::of($data);

	    // Apply formatting to numeric fields with the 'thousand' class.
	    foreach ($fields as $key => $field) {
	        if (isset($field['class']) && $field['class'] === 'thousand') {
	            $datatable->editColumn($key, function ($res) use ($key) {
	                return number_format($res->{$key}, 0, ',', '.');
	            });
	        }
	    }
	    
	    $datatable->addColumn('card_id', function($res){
	            // Now $res->card is available because of eager loading
	            return $res->card->name;
	        })
	        ->addColumn('perk_id', function($res){
	            // Now $res->card is available because of eager loading
	            return $res->perk->name;
	        })
	        ->addColumn('updated_at', function($res) {
	            return $res->updated_at;
	        })
	        ->addColumn('action', function ($res) {
	            return '<button class="btn btn-icon btn-active-light-warning w-30px h-30px me-3 edit" data-id="'.$res->id.'" data-name="'.$res->name.'" data-bs-toggle="modal" data-bs-target="#kt_modal_update"><i class="ki-outline ki-pencil fs-3"></i></button>
	                    <button class="btn btn-icon btn-active-light-danger w-30px h-30px delete" data-id="'.$res->id.'" data-name="'.$res->name.'" data-kt-action="delete_row"><i class="ki-outline ki-trash fs-3"></i></button>';
	        })
	        ->rawColumns(['action']);

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
	    $data = $this->model->findOrFail($id);
	    $updated = $data->update($validated);
	    
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