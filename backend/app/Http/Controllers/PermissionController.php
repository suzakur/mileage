<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;
use App\DataTables\PermissionsDataTable;

class PermissionController extends Controller
{

    private $page = 'permissions';
    private $module = 'users';

    private function rules ($id=0, $merge=[]) {
        return array_merge(
            [
                'name'  => 'required|min:3|unique:permissions,name' . ($id ? ",$id" : ''),
                'guard_name' => 'required',
                'group_name' => 'nullable',
                'access' => 'required|array',
                 "access.*"  => "required|distinct|in:index,store,update,destroy,manage",
            ], 
            $merge);
    }

    public function index(PermissionsDataTable $dataTable)
    {
        $module = $this->module;
        $page = $this->page;
        return $dataTable->render($this->module.'.'.$this->page, compact('module', 'page'));
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
            foreach($request->access as $access) {
                Permission::create(['name' => $access.'-'.$request->name, 'guard_name' => $request->guard_name, 'group_name' => $request->group_name]);
            }
            return redirect($this->page)->with(['type' => 'success','message' => 'new '.$this->page.' created!']);
        }
        return redirect($this->page)->with(['type' => 'error','message' => 'error creating '.$this->page.'!']);
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return Permission::findOrFail($id);
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
            $data = Permission::findOrFail($id);
            if($data) {
                $flag = $data->update($validator->safe()->only(['name', 'guard_name', 'group_name']));
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
        $data = Permission::findOrFail($id);
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
