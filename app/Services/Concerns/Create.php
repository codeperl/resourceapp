<?php

namespace App\Services\Concerns;

trait Create
{
    public function createdResource($repositoryKlass, array $values, $resourceKlass, $message='')
    {
        return (new $resourceKlass($this->repositoryLocator($repositoryKlass)->create($values)))
            ->additional($this->success($message));
    }
}
