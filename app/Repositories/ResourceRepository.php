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

    public function fileNameExists(string $fileName)
    {
        return $this->getModel()->where('url', $fileName)->exists();
    }

    public function fileNameNotExists(string $fileName)
    {
        return $this->getModel()->where('url', $fileName)->doesntExist();
    }
}
