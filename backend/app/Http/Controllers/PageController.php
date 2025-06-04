<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use jeremykenedy\LaravelLogger\App\Http\Traits\ActivityLogger;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Models\Page;
use DataTables;

class PageController extends Controller
{
     use ActivityLogger;

    private $page = 'pages';
    private $module = 'posts';

	public function __construct() {
    	$this->model = new Page();
    }

    private function formFields($id = 0)
	{
	    return [
	        'name' => [
	            'type'        => 'text',
	            'label'       => 'Page Name',
	            'placeholder' => 'Enter page name',
	            'rules'       => 'required|string|max:255|unique:pages,name,' . ($id ?: 'NULL') . ',id'
	        ],
	        'slug' => [
	            'type'        => 'text',
	            'label'       => 'Slug',
	            'placeholder' => 'Enter unique slug',
	            'rules'       => 'required|string|max:255|unique:pages,slug,' . ($id ?: 'NULL') . ',id'
	        ],
	        'content' => [
	            'type'        => 'ckeditor',
	            'label'       => 'Content',
	            'placeholder' => 'Enter page content',
	            'rules'       => 'nullable'
	        ],
	        'seo_meta' => [
	            'type'        => 'textarea',
	            'label'       => 'SEO Metadata (JSON)',
	            'placeholder' => 'Enter SEO metadata as JSON',
	            'rules'       => 'nullable|json'
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
        	->addColumn('seo_meta', function ($data) {
                $meta = ($data->seo_meta);
                if (!$meta) return '-';

                $parts = [];
                if (!empty($meta['title'])) {
                    $parts[] = "<strong>Title:</strong> " . e($meta['title']);
                }
                if (!empty($meta['description'])) {
                    $parts[] = "<strong>Description:</strong> " . e($meta['description']);
                }
                if (!empty($meta['keywords'])) {
                    $keywords = is_array($meta['keywords']) ? implode(', ', $meta['keywords']) : $meta['keywords'];
                    $parts[] = "<strong>Keywords:</strong> " . e($keywords);
                }
                return implode('<br>', $parts);
            })
            ->addColumn('updated_at', function($res){
                return $res->updated_at;
            })
            ->addColumn('action', function ($res) {
                return '<button class="btn btn-icon btn-active-light-warning w-30px h-30px me-3 edit" data-id="'.$res->id.'" data-name="'.$res->name.'" data-bs-toggle="modal" data-bs-target="#kt_modal_update"><i class="ki-outline ki-pencil fs-3"></i></button>
                        <button class="btn btn-icon btn-active-light-danger w-30px h-30px delete" data-id="'.$res->id.'" data-name="'.$res->name.'" data-kt-action="delete_row"><i class="ki-outline ki-trash fs-3"></i></button>';
            })
            ->rawColumns(['content', 'seo_meta', 'action'])
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
        return $this->model->orderBy('name');
    }

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
		if (isset($validated['seo_meta']) && is_string($validated['seo_meta'])) {
		    $decoded = json_decode($validated['seo_meta'], true);
		    if (json_last_error() === JSON_ERROR_NONE) {
		        $validated['seo_meta'] = $decoded;
		    }
		}
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
