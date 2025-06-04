<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;
use Spatie\Tags\Tag;
use DataTables;

class TagController extends Controller
{
    private $page = 'tags';
    private $module = 'tags';
    private $model;

    public function __construct() {
    	$this->model = new Tag();
    }

    private function rules ($id=0, $merge=[]) {
        return array_merge(
            [
                'name'  => 'required|min:3|unique:'.$this->page.',name' . ($id ? ",$id" : ''),
                'slug' => 'required',
                'type' => 'nullable',
            ], 
            $merge);
    }

    public function index()
    {
        $module = $this->module;
        $page = $this->page;
        $data = $this->getData()->get();
        return view($this->page)->with([ 'page' => $this->page, 'module' => $this->module, 'data' => $data]);
    }

    private function getData()
    {
        return $this->model->orderBy('order_column');
    }

    public function table()
    {
        $data = $this->model->get();
        return Datatables::of($data)
            ->addColumn('name', function($res){
                return $res->name;
            })
            ->addColumn('slug', function($res){
                return $res->slug;
            })
            ->addColumn('updated_at', function($res){
                return $res->updated_at;
            })
            ->addColumn('action', function ($res) {
                return '<button class="btn btn-icon btn-active-light-warning w-30px h-30px me-3 edit" data-id="'.$res->id.'" data-name="'.$res->name.'" data-bs-toggle="modal" data-bs-target="#kt_modal_update"><i class="ki-outline ki-pencil fs-3"></i></button>
                        <button class="btn btn-icon btn-active-light-danger w-30px h-30px delete" data-id="'.$res->id.'" data-name="'.$res->name.'" data-kt-action="delete_row"><i class="ki-outline ki-trash fs-3"></i></button>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules());
        if ($validator->fails()) {
            return redirect($this->page)->withErrors($validator)->withInput()->with(['type' => 'error','message' => 'error creating '.$this->page.'!']);
        }
        // Retrieve the validated input...
        $validated = $validator->validated();

        if($validated) {
            $flag =  $this->model->create($validated);
            if($flag){
                return redirect($this->page)->with(['type' => 'success','message' => 'new '.$this->page.' created!']);
            }
        }
        return redirect($this->page)->with(['type' => 'error','message' => 'error creating '.$this->page.'!']);
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return $this->model->findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), $this->rules($id));
        if ($validator->fails()) {
            return redirect($this->page)->withErrors($validator)->withInput();
        }
        $validated = $validator->validated();
        if($validated) {
            $data = $this->model->findOrFail($id);
            if($data) {
                $flag = $data->update($validated);
                if($flag) {
                    return redirect($this->page)->with(['type' => 'success','message' => $this->page.' updated!']);
                }
            }
        }
        return redirect($this->page)->with(['type' => 'error','message' => 'error updating '.$this->page.'!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = $this->model->findOrFail($id);
        if($data) {
            $flag = $data->delete();
            if($flag) {
                return response()->json([
                    'type' => 'success',
                    'message' => $this->page.' deleted'
                ]);
            }
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Error deleting '.$this->page
        ]);
    }
}