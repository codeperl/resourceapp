<?php


namespace App\Services\Contracts;


interface InitiableContract
{
    public function repositoryLocator($repositoryKlass);
}
