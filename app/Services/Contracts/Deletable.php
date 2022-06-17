<?php

namespace App\Services\Contracts;

interface Deletable
{
    public function destroy($repositoryKlass, $entity, $resourceKlass, $message='');
}
