<?php

namespace App\Services\Contracts;

interface Updatable
{
    public function updatedResource($repositoryKlass, $entity, array $values, $resourceKlass, $message='');
}
