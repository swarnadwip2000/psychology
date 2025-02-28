<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Traits\ImageTrait;
use Illuminate\Http\Request;

class FacultyNotesController extends Controller
{
    use ImageTrait;

    public function index()
    {
        $page_title = 'Notes';
        $notes = Note::where('teacher_id', auth()->id())->latest()->paginate(10);
        return view('frontend.teacher.notes.index', compact('notes', 'page_title'));
    }

    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'class' => 'required|string|max:255',
            'file' => 'required|mimes:jpg,jpeg,png,pdf,doc,docx',
            'short_description' => 'required|string|max:500',
        ]);

        // Store the file in the "public/uploads" directory
        if ($request->hasFile('file')) {
            $filepath =  $this->imageUpload($request->file('file'), 'file');;
        }

        // Create the new note
        $note = Note::create([
            'teacher_id' => auth()->id(),
            'class' => $request->class,
            'file' => isset($filepath) ?  $filepath : null, // Store file URL
            'short_description' => $request->short_description,
        ]);

        // Return a JSON response
        return response()->json([
            'success' => true,
            'note' => $note
        ]);
    }




    public function edit(Note $note)
    {
        return view('teacher.notes.edit', compact('note'));
    }

    public function update(Request $request, Note $note)
    {
        $request->validate([
            'class' => 'required|string|max:255',
            'file' => 'nullable|mimes:jpg,jpeg,png,pdf,doc,docx',
            'short_description' => 'required|string|max:500',
        ]);

        if ($request->hasFile('file')) {
            $filepath =  $this->imageUpload($request->file('file'), 'file');;
        }

        $note->update([
          'teacher_id' => auth()->id(),
            'class' => $request->class,
            'file' => isset($filepath) ?  $filepath : null, // Store file URL
            'short_description' => $request->short_description,
        ]);

        return redirect()->route('notes.index')->with('success', 'Notes updated successfully!');
    }

    public function destroy($id)
    {
        $note = Note::findOrFail($id);
        $note->delete();
        return redirect()->route('teacher.notes.index')->with('message', 'Notes deleted successfully!');
    }
}
