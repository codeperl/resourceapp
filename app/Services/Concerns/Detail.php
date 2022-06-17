<?php

namespace App\Services\Concerns;

trait Detail
{
    public function detailResource($entity, $resourceKlass, $message='')
    {
        return (new $resourceKlass($entity))
            ->additional($this->success($message));
    }
}
