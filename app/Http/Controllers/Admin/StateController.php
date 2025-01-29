<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use Illuminate\Http\Request;

class StateController extends Controller
{
    public function index()
    {
        $states = City::get();
        $countries = Country::get();
        return view('admin.state.list')->with(compact('states', 'countries'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:cities',
            'country_id' => 'required|exists:countries,id'
        ]);

        $state = new City;
        $state->name = $request->name;
        $state->country_id = $request->country_id;
        $state->save();

        return response()->json(['message' => 'State has been added successfully.', 'status' => 'success']);
    }

    public function edit($id)
    {
        $countries = Country::get();
        $state = City::where('id', $id)->first();
        $edit = true;
        return response()->json(['data' => view('admin.state.edit', compact('state', 'edit', 'countries'))->render()]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'edit_name' => 'required|unique:cities,name,' . $request->id,
            'edit_country_id' => 'required|exists:countries,id'
        ]);



        $state = City::where('id', $request->id)->first();
        $state->name = $request->edit_name;
        $state->country_id = $request->edit_country_id;
        $state->save();
        session()->flash('message', 'State has been successfully updated');
        return response()->json(['message' => 'State has been successfully updated.', 'status' => 'success']);
    }

    public function delete($id)
    {
        City::findOrFail($id)->delete();
        return redirect()->back()->with('error', 'State has been deleted!');
    }
}
