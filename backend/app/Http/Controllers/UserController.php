<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use DataTables;

class UserController extends Controller
{
    private $page = 'users';
    private $module = 'users';

    private function rules ($id=0, $merge=[]) {
        return array_merge(
            [
                'name' => 'required|string',
                'city' => 'nullable',
                'email' => 'required|email:rfc,dns',
                'phone' => 'required|min:9|max:14',
                'avatar' => 'nullable|sometimes|image|max:1024',
            ], 
            $merge);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::all();
        return view($this->module.'.'.$this->page)->with(['page' => $this->page, 'module' => $this->module, 'roles' => $roles]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules());
        if ($validator->fails()) {
            return redirect($this->page)->withErrors($validator)->withInput()->with(['type' => 'error','message' => 'error creating '.$this->page.'!']);
        }
        // Retrieve the validated input...
        $validated = $validator->validated();
        if($validated) {
            $data = User::create($validated);
            if($data) {
                $data->assignRole();
                return redirect($this->page)->with(['type' => 'success','message' => 'new '.$this->page.' created!']);
            }
        }
        return redirect($this->page)->with(['type' => 'error','message' => 'error creating '.$this->page.'!']);
    }

    /**
     * Display the specified resource.
     */
    public function table()
    {
        $data = User::all();
        return Datatables::of($data)
            ->addColumn('name', function($res){
                return $res->name.' '.$res->lname;
            })
            ->addColumn('city', function($res){
                return $res->city;
            })
            ->addColumn('contacts', function($res){
                $html = '';
                if($res->email_verified_at) {
                    $html .= '<span class="badge badge-success">'.$res->email.'</span><br>';
                }
                else {
                    $html .= '<span class="badge badge-danger">'.$res->email.'</span><br>';
                }
                if($res->phone_verified_at) {
                    $html .= '<span class="badge badge-success">'.$res->phone.'</span>';
                }
                else {
                    $html .= '<span class="badge badge-danger">'.$res->phone.'</span>';
                }
                return $html;
            })
            ->addColumn('created_at', function($res){
                return $res->created_at;
            })
            ->addColumn('last_login_at', function($res){
                return $res->last_login_at;
            })
            ->rawColumns(['status', 'contacts', 'action', 'roles'])
            ->make(true);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = User::findOrFail($id);
        return ['user' => $data, 'roles' => $data->getRoleNames()];
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
            $data = User::findOrFail($id);
            if($data) {
                $flag = $data->update($validated);
                if($flag) {
                    $data->syncRoles($request->role);
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
        $data = User::findOrFail($id);
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
