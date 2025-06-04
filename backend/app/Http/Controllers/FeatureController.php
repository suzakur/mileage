<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravelcm\Subscriptions\Models\Feature;
use Laravelcm\Subscriptions\Models\Plan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;
use DataTables;

class FeatureController extends Controller
{
    private $page = 'features';
    private $module = 'subscriptions';

    private function rules ($id=0, $merge=[]) {
        return array_merge(
            [
                'plan_id' => 'required|integer',
                'name' => 'required|string',
                'slug' => 'required|string',
                'value' => 'required|string',
                'sort_order' => 'required|integer',
                'resettable_period' => 'nullable|integer',
                'resettable_interval' => 'nullable|string',
                'description' => 'nullable|string',
            ], 
            $merge);
    }

    public function table()
    {
        $data = Feature::all();
        return Datatables::of($data)
            ->addColumn('name', function($res){
                return $res->name;
            })
            ->addColumn('updated_at', function($res){
                return $res->updated_at;
            })
            ->addColumn('resettable', function($res){
            	if($res->resettable_period > 0) {
            		return $res->resettable_period.' '.$res->resettable_interval;
            	}
                return '-';
            })
            ->addColumn('action', function ($res) {
                return '<button class="btn btn-icon btn-active-light-warning w-30px h-30px me-3 editFeature" data-id="'.$res->id.'" data-name="'.$res->name.'" data-bs-toggle="modal" data-bs-target="#kt_modal_2"><i class="ki-outline ki-pencil fs-3"></i></button>
                        <button class="btn btn-icon btn-active-light-danger w-30px h-30px deleteFeature" data-id="'.$res->id.'" data-name="'.$res->name.'" data-kt-action="delete_row"><i class="ki-outline ki-trash fs-3"></i></button>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules());
        if ($validator->fails()) {
            return redirect('plans')->withErrors($validator)->withInput()->with(['type' => 'error','message' => 'error creating '.$this->page.'!']);
        }
 
        // Retrieve the validated input...
        $validated = $validator->validated();

        if($validated) {
            $plan = Plan::find($request->plan_id);
            if($plan) {
                $arr = [];
                array_push($arr, 'plan');
                if($request->resettable_period == 0) {
                   array_push($arr, 'resettable_period');
                   array_push($arr, 'resettable_interval');
                }
                $flag = $plan->features()->saveMany([new Feature($validator->safe()->except($arr))]);
                return redirect('plans')->with(['type' => 'success','message' => 'new '.$this->page.' connected!']);
            }
            return redirect('plans')->with(['type' => 'warning','message' => 'error finding plan!']);
        }
        return redirect('plans')->with(['type' => 'error','message' => 'error creating '.$this->page.'!']);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return Feature::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), $this->rules($id));
        if ($validator->fails()) {
            return redirect($this->page)->withErrors($validator)->withInput()->with(['type' => 'error','message' => 'error updating '.$this->page.'!']);
        }
        $validated = $validator->validated();
        if($validated) {
            $data = Feature::find($id);
            if($data) {
                $arr = [];
                array_push($arr, 'plan');
                if($request->resettable_period == 0) {
                   array_push($arr, 'resettable_period');
                   array_push($arr, 'resettable_interval');
                }
                $flag = $data->update($validator->safe()->except($arr));
                if($flag) {
                    return redirect('plans')->with(['type' => 'success','message' => $this->page.' updated!']);
                }
            }
        }
        return redirect('plans')->with(['type' => 'error','message' => 'error updating '.$this->page.'!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Feature::findOrFail($id);
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
