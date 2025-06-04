<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private $page = 'roles';
    private $module = 'users';

    // public function __construct()
    // {
    //     $this->middleware('permission:role-read|role-create|role-edit|role-delete', ['only' => ['index']]);
    //     $this->middleware('permission:role-create', ['only' => ['store']]);
    //     $this->middleware('permission:role-edit', ['only' => ['edit','update']]);
    //     $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    // }

    private function rules ($id=0, $merge=[]) {
        return array_merge(
            [
                'name'  => 'required|min:3|unique:roles,name' . ($id ? ",$id" : ''),
                'guard_name' => 'required',
                'permissions' => 'nullable|array',
                'permissions.*' => 'nullable|numeric',
            ], 
            $merge);
    }


    public function index()
    {
        $roles = Role::all();
        $permissions_by_group = [];
        foreach (Permission::all() ?? [] as $permission) {
            $permissions_by_group[$permission->group_name][] = $permission;
        }
        return view($this->module.'.'.$this->page)->with(['module'=>$this->module,'page'=>$this->page, 'roles' => $roles, 'permissions_by_group' => $permissions_by_group]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {   
        $validator = Validator::make($request->all(), $this->rules());
        if ($validator->fails()) {
            return redirect($this->page)->withErrors($validator)->withInput()->with(['type' => 'error','message' => 'error creating '.$this->page.'!']);
        }
 
        // Retrieve the validated input...
        $validated = $validator->validated();
        if($validated) {
            $flag = Role::create($validated);
            if($flag){
                $flag->syncPermissions($request->permissions);
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
        $role = Role::findOrFail($id);
        return ['role' => $role, 'checked' => $role->permissions->pluck('id')];
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $validator = Validator::make($request->all(), $this->rules($id));
        if ($validator->fails()) {
            return redirect($this->page)->withErrors($validator)->withInput()->with(['type' => 'error','message' => 'error updating '.$this->page.'!']);
        }
        $validated = $validator->validated();
        if($validated) {
            $data = Role::findOrFail($id);
            if($data) {
                $flag = $data->update($validator->safe()->only(['name', 'guard_name']));
                if($flag) {
                    $permissions = Permission::find($request->permissions);
                    $data->syncPermissions($permissions);
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
        $data = Role::findOrFail($id);
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
