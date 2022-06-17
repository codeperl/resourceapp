<?php

namespace App\Services\Contracts;

interface Detailable
{
    public function detailResource($entity, $resourceKlass, $message='');
}
