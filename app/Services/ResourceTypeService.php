<?php

namespace App\Services;

use App\Repositories\ResourceTypeRepository;
use App\Services\Concerns\Create;
use App\Services\Concerns\Datatable;
use App\Services\Concerns\Delete;
use App\Services\Concerns\Detail;
use App\Services\Concerns\InitiateKlass;
use App\Services\Concerns\Messages;
use App\Services\Concerns\Update;
use App\Services\Contracts\Creatable;
use App\Services\Contracts\DatatableContract;
use App\Services\Contracts\Deletable;
use App\Services\Contracts\Detailable;
use App\Services\Contracts\InitiableContract;
use App\Services\Contracts\MessagableContract;
use App\Services\Contracts\Updatable;

class ResourceTypeService implements InitiableContract, Contracts\ResourceTypeContract, DatatableContract, MessagableContract,
    Creatable, Detailable, Updatable, Deletable
{
    use InitiateKlass, Messages, Datatable, Create, Detail, Update, Delete;

    /** @var ResourceTypeRepository */
    private $resourceTypeRepository;

    public function __construct(ResourceTypeRepository $resourceTypeRepository)
    {
        $this->resourceTypeRepository = $resourceTypeRepository;
    }
}
