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
}
