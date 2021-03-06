<?php

namespace App\Http\Controllers\API\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PdfResourceRequest;
use App\Http\Requests\PdfResourceUpdateRequest;
use App\Http\Resources\ResourceResource;
use App\Models\Resource;
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
        return $this->pdfResourceService->createdResource($request->validated(), ResourceResource::class,
            $request->file('url'), 'Pdf Resource created!');
    }

    public function update(PdfResourceUpdateRequest $request, Resource $pdf_resource)
    {
        return $this->pdfResourceService->updatedResource($pdf_resource, $request->validated(),
            ResourceResource::class, $request->file('url'), 'Pdf Resource updated!');
    }
}
