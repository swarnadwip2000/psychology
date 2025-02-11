<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $plans = Plan::orderBy('id', 'desc')->get();
        return view('admin.plans.list')->with(compact('plans'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.plans.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'plan_name' => 'required|string|max:255|unique:plans',
            'plan_price' => 'required|numeric|max:255',
            'plan_duration' => 'required|numeric|max:255',
            'session' => 'numeric|string|max:255',
            'free_tutorial' => 'required|boolean',
            'plan_description' => 'required|string',
        ]);

        $plan = new Plan();
        $plan->plan_name = $request->plan_name;
        $plan->plan_price = $request->plan_price;
        $plan->plan_duration = $request->plan_duration;
        $plan->session = $request->session;
        $plan->free_tutorial = $request->free_tutorial;
        $plan->plan_description = $request->plan_description;
        $plan->save();

        return redirect()->route('plans.index')->with('message', 'Plan has been added successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $plan = Plan::findOrFail($id);
        return view('admin.plans.edit')->with(compact('plan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'plan_name' => 'required|string|max:255|unique:plans,plan_name,'.$id,
            'plan_price' => 'required|numeric|max:255',
            'plan_duration' => 'required|numeric|max:255',
            'session' => 'numeric|string|max:255',
            'free_tutorial' => 'required|boolean',
            'plan_description' => 'required|string',
        ]);

        $plan = Plan::findOrFail($id);
        $plan->plan_name = $request->plan_name;
        $plan->plan_price = $request->plan_price;
        $plan->plan_duration = $request->plan_duration;
        $plan->session = $request->session;
        $plan->free_tutorial = $request->free_tutorial;
        $plan->plan_description = $request->plan_description;
        $plan->save();

        return redirect()->route('plans.index')->with('message', 'Plan has been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function delete($id)
    {
        $plan = Plan::findOrFail($id);
        $plan->delete();
        return redirect()->route('plans.index')->with('message', 'Plan has been deleted successfully');
    }
}
