<?php

namespace App\Services\Concerns;

trait InitiateKlass
{
    public function repositoryLocator($repositoryKlass)
    {
        return $this->getRepository($repositoryKlass);
    }

    protected function getConstructorArgs($repositoryKlass)
    {
        $parameters = ( new \ReflectionClass($repositoryKlass) )
            ->getConstructor()
            ->getParameters();

        $constructorArgs = [];

        if($parameters) {
            foreach($parameters as $parameter) {
                $constructorArgs[] = new ($parameter->getClass()->getName());
            }
        }

        return $constructorArgs;
    }

    protected function getRepository($repositoryKlass)
    {
        $constructorArgs = $this->getConstructorArgs($repositoryKlass);
        $klass = new \ReflectionClass($repositoryKlass);

        return $klass->newInstanceArgs($constructorArgs);
    }
}
