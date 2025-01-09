<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

trait FileUploader
{
    protected function uploadFile($newImag, $path, $oldImag = null)
    {
        if (isset($newImag)) {
            $this->deleteFile($oldImag);
            $image_name = time() . '_' . $newImag->hashName();
            $newImag->move($path, $image_name);
            return $image_name;
        }
        return $oldImag;
    }

    protected function deleteFile($filePath): void
    {
        // Check if the file exists in the given path and then delete it
        if (isset($filePath) && File::exists(public_path($filePath))) {
            File::delete(public_path($filePath));
        }
    }
}
