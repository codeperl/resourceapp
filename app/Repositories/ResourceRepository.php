<?php

namespace App\Repositories;

use App\Models\Resource;

class ResourceRepository extends Repository
{
    /**
     * ResourceRepository constructor.
     * @param Resource $resource
     */
    public function __construct(Resource $resource)
    {
        parent::__construct($resource);
    }
}
