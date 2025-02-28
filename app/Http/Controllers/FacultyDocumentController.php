<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Traits\ImageTrait;
use Illuminate\Http\Request;

class FacultyDocumentController extends Controller
{
    use ImageTrait;

    public function index()
    {
        $page_title = 'Documents';
        $documents = Document::where('teacher_id', auth()->id())->latest()->paginate(10);
        return view('frontend.teacher.documents.index', compact('documents', 'page_title'));
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

        // Create the new document
        $document = Document::create([
            'teacher_id' => auth()->id(),
            'class' => $request->class,
            'file' => isset($filepath) ?  $filepath : null, // Store file URL
            'short_description' => $request->short_description,
        ]);

        // Return a JSON response
        return response()->json([
            'success' => true,
            'document' => $document
        ]);
    }




    public function edit(Document $document)
    {
        return view('teacher.documents.edit', compact('document'));
    }

    public function update(Request $request, Document $document)
    {
        $request->validate([
            'class' => 'required|string|max:255',
            'file' => 'nullable|mimes:jpg,jpeg,png,pdf,doc,docx',
            'short_description' => 'required|string|max:500',
        ]);

        if ($request->hasFile('file')) {
            $filepath =  $this->imageUpload($request->file('file'), 'file');;
        }

        $document->update([
          'teacher_id' => auth()->id(),
            'class' => $request->class,
            'file' => isset($filepath) ?  $filepath : null, // Store file URL
            'short_description' => $request->short_description,
        ]);

        return redirect()->route('documents.index')->with('success', 'Document updated successfully!');
    }

    public function destroy($id)
    {
        $document = Document::findOrFail($id);
        $document->delete();
        return redirect()->route('teacher.documents.index')->with('message', 'Document deleted successfully!');
    }
}
