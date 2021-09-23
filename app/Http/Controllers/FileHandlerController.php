<?php

namespace App\Http\Controllers;

use App\Models\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class FileHandlerController extends Controller
{
    public function download($file_name)
    {
        $file = Upload::where('filename', $file_name)->first();

        if ($file)
        {
            $stored_file = storage_path('app\uploaded_files' .'\\' . $file_name);
            return Response::download($stored_file, $file->orig_filename);
        }
    }
}
