<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;
use Laravelcm\Subscriptions\Models\Plan;
use Laravelcm\Subscriptions\Interval;
use jeremykenedy\LaravelLogger\App\Http\Traits\ActivityLogger;
use Auth;

class PlanController extends Controller 
{
    use ActivityLogger;

    private $page = 'plans';
    private $module = 'subscriptions';

    private function rules ($id=0, $merge=[]) {
        return array_merge(
            [
                'slug'  => 'required|min:3|unique:plans,slug' . ($id ? ",$id" : ''),
                'name' => 'required',
                'description' => 'nullable',
                'price' => 'required|integer|min:1',
                'signup_fee' => 'required|integer|min:0',
                'invoice_period' => 'required|integer|min:0',
                'invoice_interval' => 'required|string',
                'trial_period' => 'required|integer|min:0',
                'trial_interval' => 'required|string',
                'grace_period' => 'required|integer|min:0',
                'grace_interval' => 'required|string',
                'sort_order' => 'required|integer|min:0',
                'currency' => 'required|string|in:usd,idr',
            ], 
            $merge);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = $this->getData()->get();
        return view($this->module.'.'.$this->page)->with(['page' => $this->page, 'module' => $this->module, 'data' => $data]);
    }

    public function showPricing()
    {
        $data = $this->getData()->where('is_active', 1)->get();
        return view($this->module.'.'.$this->page)->with(['page' => $this->page, 'module' => $this->module, 'data' => $data]);
    }

    public function store(Request $request): RedirectResponse
    {   
        $validator = Validator::make($request->all(), $this->rules());
        if ($validator->fails()) {
            return redirect($this->page)->withErrors($validator)->withInput()->with(['type' => 'error','message' => 'error creating '.$this->page.'!']);
        }
        // Retrieve the validated input...
        $validated = $validator->validated();
        if($validated) {
            $flag = Plan::create($validated);
            if($flag){
                return redirect($this->page)->with(['type' => 'success','message' => 'new '.$this->page.' created!']);
            }
        }
        return redirect($this->page)->with(['type' => 'error','message' => 'error creating '.$this->page.'!']);
    }

    
    private function getData()
    {
        return Plan::orderBy('sort_order');
    }

     /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return Plan::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $validator = Validator::make($request->all(), $this->rules($id));
        if ($validator->fails()) {
            return redirect($this->page)->withErrors($validator)->withInput();
        }
        $validated = $validator->validated();
        if($validated) {
            $data = Plan::findOrFail($id);
            if($data) {
                $flag = $data->update($validated);
                if($flag) {
                    return redirect($this->page)->with(['type' => 'success','message' => $this->page.' updated!']);
                }
            }
        }
        return redirect($this->page)->with(['type' => 'error','message' => 'error updating '.$this->page.'!']);
    }

    public function updateStatus(Request $request)
    {
        $data = Plan::find($request->id);
        if($data) {
        	$stat = $data->is_active == 1 ? 0:1; 
            $flag = $data->update(['is_active' => $stat ]);
            if($flag) {
            	return response()->json([
                    'type' => 'success',
                    'message' => $this->page.' status updated!'
                ]);
            }
        }
        return response()->json([
            'status' => 'error',
            'message' => 'Error updating status '.$this->page
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
    	$message = [];
        $data = Plan::findOrFail($id);
        if($data) {
            $flag = $data->delete();
            if($flag) {
            	$message = [ 'type' => 'success', 'message' => $this->page.' deleted' ];
            	Log::info($message);
                return response()->json($message);
            }
        }
        Log::error($message);
        return response()->json($message);
    }
}
