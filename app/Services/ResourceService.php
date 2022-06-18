<?php

namespace App\Services;

use App\Repositories\ResourceRepository;
use App\Services\Concerns\Datatable;
use App\Services\Concerns\Delete;
use App\Services\Concerns\Detail;
use App\Services\Concerns\InitiateKlass;
use App\Services\Concerns\Messages;
use App\Services\Contracts\DatatableContract;
use App\Services\Contracts\Deletable;
use App\Services\Contracts\Detailable;
use App\Services\Contracts\InitiableContract;
use App\Services\Contracts\MessagableContract;

class ResourceService implements Contracts\ResourceContract, InitiableContract, DatatableContract, MessagableContract,
    Detailable, Deletable
{
    use InitiateKlass, Messages, Datatable, Detail, Delete;

    /** @var ResourceRepository */
    private $resourceRepository;

    public function __construct(ResourceRepository $resourceRepository)
    {
        $this->resourceRepository = $resourceRepository;
    }
}
