<?php


namespace App\Services\Contracts;


interface DatatableContract
{
    public function datatableSearchQuery($repositoryKlass, $sortBy, $orderBy, $searchValue);
}
