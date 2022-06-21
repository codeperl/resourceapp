<?php

namespace App\Services\Contracts;

use Illuminate\Http\UploadedFile;

interface FileUploaderContract
{
    public function uploadFile($repository, UploadedFile $file);
}
