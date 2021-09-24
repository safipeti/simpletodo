<?php

namespace App\Http\Controllers;

use App\Models\Upload;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class FileHandlerController extends Controller
{
    public function download(int $id): BinaryFileResponse
    {
        $file = Upload::query()->findOrFail($id);

        return Response::download(storage_path('app/uploaded_files/'.$file->filename), $file->orig_filename);
    }
}
