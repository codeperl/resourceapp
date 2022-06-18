<?php

namespace App\Http\Controllers\API\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\HtmlResourceRequest;
use App\Http\Resources\ResourceResource;
use App\Models\Resource;
use App\Repositories\ResourceRepository;
use App\Services\Contracts\ResourceContract;
use App\Services\HtmlResourceService;

class HtmlResourceController extends Controller
{
    /** @var HtmlResourceService */
    private $htmlResourceService;

    public function __construct(ResourceContract $htmlResourceService)
    {
        $this->htmlResourceService = $htmlResourceService;
    }

    public function store(HtmlResourceRequest $request)
    {
        return $this->htmlResourceService->createdResource(ResourceRepository::class, $request->validated(),
            ResourceResource::class, 'HTML Resource created!');
    }

    public function update(HtmlResourceRequest $request, Resource $resource)
    {
        return $this->htmlResourceService->updatedResource(ResourceRepository::class, $resource,
            $request->validated(), ResourceResource::class, 'HTML Resource updated!');
    }
}
