<?php

namespace App\Services;

use App\Enums\ResourceType;
use App\Enums\Storage as StorageDisks;
use App\Repositories\ResourceRepository;
use App\Services\Concerns\Datatable;
use App\Services\Concerns\Detail;
use App\Services\Concerns\InitiateKlass;
use App\Services\Concerns\Messages;
use App\Services\Contracts\DatatableContract;
use App\Services\Contracts\Deletable;
use App\Services\Contracts\Detailable;
use App\Services\Contracts\InitiableContract;
use App\Services\Contracts\MessagableContract;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ResourceService implements Contracts\ResourceContract, InitiableContract, DatatableContract, MessagableContract,
    Detailable, Deletable
{
    use InitiateKlass, Messages, Datatable, Detail;

    /** @var ResourceRepository */
    private $resourceRepository;

    public function __construct(ResourceRepository $resourceRepository)
    {
        $this->resourceRepository = $resourceRepository;
    }

    public function destroy($repositoryKlass, $entity, $resourceKlass, $message='')
    {
        DB::beginTransaction();

        try {
            $this->repositoryLocator($repositoryKlass)->delete($entity);
            if($entity->resource_type->name===ResourceType::PDF) {
                Storage::disk(StorageDisks::ADMIN_UPLOADED_STORAGE)->delete($entity->url);
            }

            DB::commit();

            return (new $resourceKlass(null))
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
