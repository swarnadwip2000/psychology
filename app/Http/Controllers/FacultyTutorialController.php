<?php

namespace App\Http\Controllers;

use App\Models\Tutorial;
use Illuminate\Http\Request;

class FacultyTutorialController extends Controller
{
    public function index()
    {
        $page_title = 'Tutorials';
        $tutorials = Tutorial::where('teacher_id', auth()->id())->latest()->paginate(10);
        return view('frontend.teacher.tutorials.index', compact('tutorials','page_title'));
    }


    public function store(Request $request)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'class' => 'required|string|max:255',
            'url' => 'required|url',
            'short_description' => 'required|string|max:500',
        ]);

        // Create the new tutorial
        $tutorial = Tutorial::create([
            'teacher_id' => auth()->id(),
            'class' => $request->class,
            'url' => $request->url,
            'short_description' => $request->short_description,
        ]);

        // Return a JSON response
        return response()->json([
            'success' => true,
            'tutorial' => $tutorial
        ]);
    }


    public function edit(Tutorial $tutorial)
    {
        return view('teacher.tutorials.edit', compact('tutorial'));
    }

    public function update(Request $request, Tutorial $tutorial)
    {
        $request->validate([
            'class' => 'required|string|max:255',
            'url' => 'required|url',
            'short_description' => 'nullable|string|max:500',
        ]);

        $tutorial->update([
            'class' => $request->class,
            'url' => $request->url,
            'short_description' => $request->short_description,
        ]);

        return redirect()->route('tutorials.index')->with('success', 'Tutorial updated successfully!');
    }

    public function destroy($id)
    {
        $tutorial = Tutorial::findOrFail($id);
        $tutorial->delete();
        return redirect()->route('teacher.tutorials.index')->with('message', 'Tutorial deleted successfully!');
    }
}
