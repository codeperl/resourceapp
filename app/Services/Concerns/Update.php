<?php

namespace App\Services\Concerns;

trait Update
{
    public function updatedResource($repositoryKlass, $entity, array $values, $resourceKlass, $message='')
    {
        if ($this->repositoryLocator($repositoryKlass)->update($entity, $values)) {
            return (new $resourceKlass($entity->refresh()))
                ->additional($this->success($message));
        }
    }
}
