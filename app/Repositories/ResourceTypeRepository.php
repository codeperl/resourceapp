<?php

namespace App\Repositories;

use App\Models\ResourceType;

/**
 * Class ResourceTypeRepository
 * @package App\Repositories
 */
class ResourceTypeRepository extends Repository
{
    /**
     * ResourceTypeRepository constructor.
     * @param ResourceType $resourceType
     */
    public function __construct(ResourceType $resourceType)
    {
        parent::__construct($resourceType);
    }

    public function isExists(string $name)
    {
        return $this->getModel()->where('name', $name)->exists();
    }
}
