<?php

namespace App\Http\Controllers\API\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\LinkResourceRequest;
use App\Http\Resources\ResourceResource;
use App\Models\Resource;
use App\Repositories\ResourceRepository;
use App\Services\Contracts\ResourceContract;
use App\Services\LinkResourceService;

class LinkResourceController extends Controller
{
    /** @var LinkResourceService */
    private $linkResourceService;

    public function __construct(ResourceContract $linkResourceService)
    {
        $this->linkResourceService = $linkResourceService;
    }

    public function store(LinkResourceRequest $request)
    {
        return $this->linkResourceService->createdResource(ResourceRepository::class, $request->validated(),
            ResourceResource::class, 'Link Resource created!');
    }

    public function update(LinkResourceRequest $request, Resource $resource)
    {
        return $this->linkResourceService->updatedResource(ResourceRepository::class, $resource, $request->validated(),
            ResourceResource::class, 'Link Resource updated!');
    }
}
