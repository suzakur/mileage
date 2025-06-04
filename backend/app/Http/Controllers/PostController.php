<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use jeremykenedy\LaravelLogger\App\Http\Traits\ActivityLogger;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Models\Post;
use DataTables;
use Auth;

class PostController extends CommonController
{
    use ActivityLogger;

    private $page = 'posts';
    private $module = 'posts';

	public function __construct() {
    	$this->model = new Post();
    }

    private function formFields($id = 0, $cards = [])
	{
	    if (empty($cards)) {
	        $cards = \App\Models\Card::all()->mapWithKeys(function ($card) {
	            return [$card->id => "{$card->name} ({$card->network} {$card->tier})"];
	        });
	    }

	    return [
	        'page_id' => [
	            'type'        => 'select',
	            'label'       => 'Page',
	            'placeholder' => 'Select Page',
	            'options'     => \App\Models\Page::whereStatus('active')->get()->pluck('name', 'id'),
	            'rules'       => 'required'
	        ],
	        'card_id' => [
	            'type'        => 'select',
	            'label'       => 'Card',
	            'placeholder' => 'Select card',
	            'options'     => $cards,
	            'rules'       => 'nullable'
	        ],
			'merchant_place_id' => [
			    'type'        => 'select',
			    'label'       => 'Merchants',
			    'placeholder' => 'Select Merchants',
			    'options'     => \App\Models\MerchantPlace::with(['merchant', 'place'])
			                      ->get()
			                      ->mapWithKeys(function ($merchantPlace) {
			                          // Combine merchant name and place name
			                          return [$merchantPlace->id => $merchantPlace->merchant->name . ' @' . $merchantPlace->place->name];
			                      }),
			    'rules'       => 'required'
			],
	        'title' => [
	            'type'        => 'text',
	            'label'       => 'Title',
	            'placeholder' => 'Enter post title',
	            'rules'       => 'required|string|max:255'
	        ],
	        'slug' => [
	            'type'        => 'text',
	            'label'       => 'Slug',
	            'placeholder' => 'Enter post slug',
	            'rules'       => 'required|string|unique:posts,slug,' . $id
	        ],
	        'excerpt' => [
	            'type'        => 'textarea',
	            'label'       => 'Excerpt',
	            'placeholder' => 'Enter post excerpt',
	            'rules'       => 'nullable|string'
	        ],
	        'content' => [
	            'type'        => 'ckeditor',
	            'label'       => 'Content',
	            'placeholder' => 'Enter post content',
	            'rules'       => 'required|string'
	        ],
	        'image' => [
	            'type'        => 'file',
	            'label'       => 'Image',
	            'rules'       => 'nullable|image|max:1024' // Max size 1MB
	        ],
	        'campaign' => [
	            'type'        => 'text',
	            'label'       => 'Campaign',
	            'placeholder' => 'Enter campaign name',
	            'rules'       => 'nullable|string|max:255'
	        ],
	        'published_at' => [
	            'type'        => 'date',
	            'label'       => 'Published At',
	            'placeholder' => 'Enter published date',
	            'rules'       => 'nullable|date'
	        ],
	        'seo_meta' => [
	            'type'        => 'textarea',
	            'label'       => 'SEO Meta',
	            'placeholder' => 'Enter SEO meta (JSON format)',
	            'rules'       => 'nullable|json'
	        ]
	    ];
	}

    public function index()
    {
        $formFields = $this->formFields();
        return view($this->module.'.'.$this->page)->with(['page' => $this->page, 'module' => $this->module, 'formFields' => $formFields]);
    }

    public function table()
	{
	    $fields = $this->formFields();
	    $data = $this->model->get();
	    $datatable = Datatables::of($data);

	    foreach ($fields as $key => $field) {
	        if (isset($field['class']) && $field['class'] === 'thousand') {
	            $datatable->editColumn($key, function ($res) use ($key) {
	                return number_format($res->{$key}, 0, ',', '.');
	            });
	        }
	    }
	    $datatable
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
	    	->addColumn('status', function($res) {
	            return $this->getStatus($res->status);
	        })
	        ->addColumn('page_id', function($res) {
	            return $res->page ? $res->page->name : '';
	        })
	        ->addColumn('card_id', function($res) {
	            return $res->card->name ?? '';
	        })
	        ->addColumn('merchant_place_id', function($res) {
	            return $res->merchantPlace->merchant->name . ' @' . $res->merchantPlace->place->name;
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
	        ->addColumn('creator', function ($res) {
			    return $res->creator?->name ?? '-';
			})
			->addColumn('editor', function ($res) {
			    return $res->editor?->name ?? '-';
			})
	        ->addColumn('action', function ($res) {
			    $nextStatus = match ($res->status) {
			        'draft' => 'published',
			        'published' => 'archived',
			        'archived' => 'draft',
			        default => 'draft',
			    };

			    $label = ucfirst($res->status); // Capitalize
			    $badgeClass = match ($res->status) {
			        'draft' => 'secondary',
			        'published' => 'success',
			        'archived' => 'warning',
			        default => 'light',
			    };

			    $statusButton = '
			        <button class="btn btn-sm btn-' . $badgeClass . ' shift-status"
			            data-id="' . $res->id . '"
			            data-next-status="' . $nextStatus . '"
			        >' . $label . '</button>';

			    return $statusButton . '
			        <button class="btn btn-icon btn-active-light-warning w-30px h-30px me-3 edit"
			            data-id="' . $res->id . '"
			            data-name="' . $res->name . '"
			            data-bs-toggle="modal"
			            data-bs-target="#kt_modal_update">
			            <i class="ki-outline ki-pencil fs-3"></i>
			        </button>
			        <button class="btn btn-icon btn-active-light-danger w-30px h-30px delete"
			            data-id="' . $res->id . '"
			            data-name="' . $res->name . '"
			            data-kt-action="delete_row">
			            <i class="ki-outline ki-trash fs-3"></i>
			        </button>';
			})
	        ->rawColumns(['content', 'status', 'seo_meta','link', 'image', 'action']);

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
	    $validated['user_id'] = auth()->id();
	    
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

    public function edit(string $id)
    {
        return $this->model->findOrFail($id);
    }

    public function updateStatus(Request $request)
	{
	    $data = $this->model->findOrFail($request->id);
	    $status = $request->status;
	    if (!in_array($status, ['draft', 'published', 'archived'])) {
	        return response()->json(['error' => 'Invalid status'], 400);
	    }
	    $data->status = $status;
	    $data->save();
	    return response()->json(['message' => 'Status shifted']);
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