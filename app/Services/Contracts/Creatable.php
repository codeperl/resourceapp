<?php

namespace App\Services\Contracts;

interface Creatable
{
    public function createdResource($repositoryKlass, array $values, $resourceKlass, $message='');
}
