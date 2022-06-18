<?php

namespace App\Http\Controllers\API\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\ResourceResource;
use App\Models\Resource;
use App\Repositories\ResourceRepository;
use App\Services\Contracts\ResourceContract;
use App\Services\ResourceService;
use Illuminate\Http\Request;
use JamesDordoy\LaravelVueDatatable\Http\Resources\DataTableCollectionResource;

class ResourceController extends Controller
{
    /** @var ResourceService */
    private $resourceService;

    public function __construct(ResourceContract $resourceService)
    {
        $this->resourceService = $resourceService;
    }

    public function index(Request $request)
    {
        $length = $request->input('length');
        $sortBy = $request->input('column');
        $orderBy = $request->input('dir');
        $searchValue = $request->input('search');

        $query = $this->resourceService->datatableSearchQuery(ResourceRepository::class, $sortBy, $orderBy, $searchValue);
        $data = $query->paginate($length);

        return new DataTableCollectionResource($data);
    }

    public function show(Resource $resource)
    {
        return $this->resourceService->detailResource($resource, ResourceResource::class,
            'Resource showed!');
    }

    public function destroy(Resource $resource)
    {
        return $this->resourceService->destroy(ResourceRepository::class, $resource,
            ResourceResource::class, 'Resource deleted!');
    }
}
