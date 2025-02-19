<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait ImageTrait
{
    /**
     * @param Request $request
     * @return $this|false|string
     */
    protected function imageUpload($file, $folder)
    {
        // Define the destination path (e.g., public/uploads/profile)
        $destinationPath = public_path('uploads/' . $folder);

        // Create the directory if it doesn't exist
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }

        // Generate a unique file name
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

        // Move the file to the destination path
        $file->move($destinationPath, $filename);

        // Return the relative path that you can store in the database
        return 'uploads/' . $folder . '/' . $filename;
    }
}
