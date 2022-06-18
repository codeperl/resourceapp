<?php

namespace App\Http\Controllers\API\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PdfResourceRequest;
use App\Http\Resources\ResourceResource;
use App\Models\Resource;
use App\Repositories\ResourceRepository;
use App\Services\Contracts\ResourceContract;
use App\Services\PdfResourceService;

class PdfResourceController extends Controller
{
    /** @var PdfResourceService */
    private $pdfResourceService;

    public function __construct(ResourceContract $pdfResourceService)
    {
        $this->pdfResourceService = $pdfResourceService;
    }

    public function store(PdfResourceRequest $request)
    {
        return $this->pdfResourceService->createdResource(ResourceRepository::class, $request->validated(),
            ResourceResource::class, 'Pdf Resource created!');
    }

    public function update(PdfResourceRequest $request, Resource $resource)
    {
        return $this->pdfResourceService->updatedResource(ResourceRepository::class, $resource, $request->validated(),
            ResourceResource::class, 'Pdf Resource updated!');
    }
}
