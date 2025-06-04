<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use jeremykenedy\LaravelLogger\App\Http\Traits\ActivityLogger;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Models\Place;
use DataTables;

class PlaceController extends Controller
{
    use ActivityLogger;

    private $page = 'places';
    private $module = 'merchants';

	public function __construct() {
    	$this->model = new Place();
    }

    private function formFields($id = 0, $cities = [])
	{
	    return [
	        'name' => [
	            'type'        => 'text',
	            'label'       => 'Place Name',
	            'placeholder' => 'Enter place name',
	            'rules'       => 'required|string|max:255'
	        ],
	        'address' => [
	            'type'        => 'text',
	            'label'       => 'Address',
	            'placeholder' => 'Enter address',
	            'rules'       => 'nullable|string|max:255'
	        ],
	        'city_id' => [
	            'type'        => 'text',
	            'label'       => 'City',
	            'placeholder' => 'Enter City',
	            'rules'       => 'nullable|string|max:255'
	        ],
	        'postal_code' => [
	            'type'        => 'text',
	            'label'       => 'Postal',
	            'placeholder' => 'Enter Postal',
	            'rules'       => 'nullable|string|max:255'
	        ],
	        'latitude' => [
	            'type'        => 'text',
	            'label'       => 'Latitude',
	            'placeholder' => 'Enter latitude',
	            'rules'       => 'nullable|numeric'
	        ],
	        'longitude' => [
	            'type'        => 'text',
	            'label'       => 'Longitude',
	            'placeholder' => 'Enter longitude',
	            'rules'       => 'nullable|numeric'
	        ],
	        'google_place_id' => [
	            'type'        => 'text',
	            'label'       => 'Google Place ID',
	            'placeholder' => 'Enter Google Place ID',
	            'rules'       => 'nullable|unique:places,google_place_id' . ($id ? ",$id" : '')
	        ],
	        'raw_data' => [
	            'type'        => 'textarea',
	            'label'       => 'Raw Data',
	            'placeholder' => 'Enter raw JSON data',
	            'rules'       => 'nullable|json',
	            'class'		=> 'hidden'
	        ],
	    ];
	}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $formFields = $this->formFields();
        return view($this->module.'.'.$this->page)->with(['page' => $this->page, 'module' => $this->module, 'formFields' => $formFields]);
    }

    public function table()
    {
        $data = $this->model->get();
        return Datatables::of($data)
            ->addColumn('name', function ($res) {
			    return $res->name;
			})
			->addColumn('city_id', function ($res) {
			    return $res->city?->name ?? '';
			})
			->addColumn('merchants', function ($res) {
			    return $res->merchants->count();
			})
			->addColumn('raw_data', function ($res) {
			    return 'hidden';
			})
            ->addColumn('updated_at', function($res){
                return $res->updated_at;
            })
            ->addColumn('action', function ($res) {
                return '<button class="btn btn-icon btn-active-light-warning w-30px h-30px me-3 edit" data-id="'.$res->id.'" data-name="'.$res->name.'" data-bs-toggle="modal" data-bs-target="#kt_modal_update"><i class="ki-outline ki-pencil fs-3"></i></button>
                        <button class="btn btn-icon btn-active-light-danger w-30px h-30px delete" data-id="'.$res->id.'" data-name="'.$res->name.'" data-kt-action="delete_row"><i class="ki-outline ki-trash fs-3"></i></button>';
            })
            ->rawColumns([ 'action'])
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
	    if (!empty($validated['city_id'])) {
	        $cityName = $validated['city_id']; // City name from Google Maps
	        $city = \App\Models\City::where('name', $cityName)->first();
	        if ($city) {
	            $city_id = $city->id;
	        }
	        else {
	        	$city_id = null;
	        }
	        $validated['city_id'] = $city_id;
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
