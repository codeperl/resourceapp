<?php

namespace App\Services;

use App\Repositories\ResourceRepository;
use App\Services\Concerns\InitiateKlass;
use App\Services\Concerns\Messages;
use App\Services\Contracts\FileUploaderContract;
use App\Services\Contracts\InitiableContract;
use App\Services\Contracts\MessagableContract;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Enums\Storage as StorageDisks;

class PdfResourceService implements Contracts\ResourceContract, InitiableContract, MessagableContract
{
    use InitiateKlass, Messages;

    /** @var FileUploaderService */
    private $fileUploaderService;

    /** @var ResourceRepository */
    private $resourceRepository;

    public function __construct(FileUploaderContract $fileUploaderService, ResourceRepository $resourceRepository)
    {
        $this->fileUploaderService = $fileUploaderService;
        $this->resourceRepository = $resourceRepository;
    }

    public function createdResource(array $values, $resourceKlass, UploadedFile $file, $message='')
    {
        DB::beginTransaction();

        try {
            $newFileMeta = $this->fileUploaderService->uploadFile($this->resourceRepository, $file);

            if (!$newFileMeta['fileName'] || !$newFileMeta['extension'] || !$newFileMeta['mime_type']) {
                throw new \Exception('File name or extension is missing! Operation reverted!');
            }

            $values['url'] = $newFileMeta['fileName'];
            $object = $this->resourceRepository->create($values);

            DB::commit();

            return (new $resourceKlass($object))
                ->additional($this->success($message));
        } catch(\Exception $e) {
            DB::rollBack();

            return (new $resourceKlass(null))
                ->additional($this->failed(
                    $e->getMessage()
                ));
        }
    }

    public function updatedResource($entity, array $values, $resourceKlass, ?UploadedFile $file, $message='')
    {
        if(empty($values['url'])) {
            unset($values['url']);
        }

        DB::beginTransaction();
        try {
            $anotherFileSelected = !empty($file);
            $oldFileName = $entity->url;

            if ($anotherFileSelected) {
                $newFileMeta = $this->fileUploaderService->uploadFile($this->resourceRepository, $file);

                if (!$newFileMeta['fileName'] || !$newFileMeta['extension'] || !$newFileMeta['mime_type']) {
                    throw new \Exception('File name or extension is missing! Operation reverted!');
                }

                $values['url'] = $newFileMeta['fileName'];
            }

            $this->resourceRepository->update($entity, $values);

            if($anotherFileSelected && $oldFileName) {
                Storage::disk(StorageDisks::ADMIN_UPLOADED_STORAGE)->delete($oldFileName);
            }

            DB::commit();

            return (new $resourceKlass($entity->refresh()))
                ->additional($this->success($message));
        } catch(\Exception $e) {
            if ($anotherFileSelected && !empty($values['url'])) {
                Storage::disk(StorageDisks::ADMIN_UPLOADED_STORAGE)->delete($values['url']);
            }

            DB::rollBack();

            return (new $resourceKlass(null))
                ->additional($this->failed(
                    $e->getMessage()
                ));
        }
    }
}
