<?php

namespace App\Services;

use App\Models\Todo;
use Illuminate\Http\UploadedFile;

class UploadService
{
    public function upload(UploadedFile $file): array
    {
        $fileNameWithExt = $file->getClientOriginalName();
        $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
        $ext = $file->getClientOriginalExtension();
        $fileNameToStore = sha1($fileName.time()).'.'.$ext;

        $file->storeAs('uploaded_files', $fileNameToStore);

        return ['orig_filename' => $fileNameWithExt, 'filename' => $fileNameToStore];
    }

    public function addUpload(Todo $todo, array $file): void
    {
        $todo->uploadedFiles()->create([
            'orig_filename' => $file['orig_filename'],
            'filename' => $file['filename']
        ]);
    }
}
