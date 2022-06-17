<?php

namespace App\Services\Concerns;

trait Delete
{
    public function destroy($repositoryKlass, $entity, $resourceKlass, $message='')
    {
        if ($this->repositoryLocator($repositoryKlass)->delete($entity)) {
            return (new $resourceKlass(null))
                ->additional($this->success($message));
        }
    }
}
