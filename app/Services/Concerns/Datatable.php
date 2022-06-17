<?php
namespace App\Services\Concerns;

trait Datatable
{
    public function datatableSearchQuery($repositoryKlass, $sortBy, $orderBy, $searchValue)
    {
        return ($this->repositoryLocator($repositoryKlass))->eloquentQuery($sortBy, $orderBy, $searchValue);
    }
}
