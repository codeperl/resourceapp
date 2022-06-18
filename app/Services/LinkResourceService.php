<?php

namespace App\Services;

use App\Repositories\ResourceRepository;
use App\Services\Concerns\Create;
use App\Services\Concerns\InitiateKlass;
use App\Services\Concerns\Messages;
use App\Services\Concerns\Update;
use App\Services\Contracts\Creatable;
use App\Services\Contracts\InitiableContract;
use App\Services\Contracts\MessagableContract;
use App\Services\Contracts\Updatable;

class LinkResourceService implements Contracts\ResourceContract, InitiableContract, MessagableContract, Creatable,
    Updatable
{
    use InitiateKlass, Messages, Create, Update;

    /** @var ResourceRepository */
    private $resourceRepository;

    public function __construct(ResourceRepository $resourceRepository)
    {
        $this->resourceRepository = $resourceRepository;
    }
}
