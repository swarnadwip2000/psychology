<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{

    public function index()
    {
        $countries = Country::get();
        return view('admin.country.list')->with(compact('countries'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:countries',
        ]);


        $country = new Country;
        $country->name = $request->name;
        $country->save();
        return response()->json(['message' => 'Country has been added successfully.', 'status' => 'success']);
    }

    public function edit($id)
    {
        $country = Country::where('id', $id)->first();
        $edit = true;
        return response()->json(['data' => view('admin.country.edit', compact('country', 'edit'))->render()]);
    }

    public function update(Request $request)
    {

        $request->validate([
            'edit_name' => 'required|unique:countries,name,' . $request->id,
        ]);

        $Country = Country::where('id', $request->id)->first();
        $Country->name =  $request->edit_name;
        $Country->save();
        session()->flash('message', 'Country has been updated successfully');
        return response()->json(['message' => 'Country account has been successfully updated.', 'status' => 'success']);
    }


    public function delete($id)
    {
        Country::findOrFail($id)->delete();
        return redirect()->back()->with('error', 'Country has been deleted!');
    }
}
