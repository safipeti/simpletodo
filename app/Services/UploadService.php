<?php

namespace App\Services;

use App\Models\Todo;

class UploadService
{

    public function upload($file)
    {
        $fileNameWithExt = $file->getClientOriginalName();

        $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);

        $ext = $file->getClientOriginalExtension();

        $fileNameToStore = sha1($fileName.time()).'.'.$ext;

        $path = $file->storeAs('uploaded_files', $fileNameToStore);

        return ['orig_filename' => $fileNameWithExt, 'filename' => $fileNameToStore];
    }

    public function addUpload(Todo $todo, $file)
    {
        $file = $todo->uploadedFiles()->create([
            'orig_filename' => $file['orig_filename'],
            'filename' => $file['filename']
        ]);
    }
}
