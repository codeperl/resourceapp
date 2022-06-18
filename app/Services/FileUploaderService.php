<?php

namespace App\Services;

use App\Enums\Storage as StorageDisks;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class FileUploaderService implements Contracts\FileUploaderContract
{
    public function uploadFile($repository, UploadedFile $file)
    {
        try {
            $extension = $file->extension();
            $mimeType = $file->getMimeType();
            $fileName = $this->getUniqueFileName($repository, $file);

            if (!$fileName || !$extension || !$mimeType) {
                throw new \Exception('File name or extension is missing! Operation reverted!');
            }

            $file->storePubliclyAs('', $fileName, ['disk' => StorageDisks::ADMIN_UPLOADED_STORAGE]);
        } catch(\Exception $e) {
            return [
                'fileName' => '',
                'mime_type' => '',
                'extension' => '',
            ];
        }

        return [
            'fileName' => $fileName,
            'mime_type' => $mimeType,
            'extension' => $extension,
        ];
    }

    private function getUniqueFileName($repository, UploadedFile $file)
    {
        do {
            $fileName = $file->getClientOriginalName();
            $slug = Str::slug($fileName);
            $extension = $file->extension();
            $guess = $slug.time().'.'.$extension;

        } while($repository->fileNameExists($guess));

        return $guess;
    }
}
