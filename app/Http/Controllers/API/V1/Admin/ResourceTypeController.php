<?php

namespace App\Http\Controllers\API\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ResourceTypeRequest;
use App\Http\Resources\ResourceTypeResource;
use App\Models\ResourceType;
use App\Repositories\ResourceTypeRepository;
use App\Services\Contracts\ResourceTypeContract;
use App\Services\ResourceTypeService;
use Illuminate\Http\Request;
use JamesDordoy\LaravelVueDatatable\Http\Resources\DataTableCollectionResource;

class ResourceTypeController extends Controller
{
    /** @var ResourceTypeService */
    private $resourceTypeService;

    /** @var ResourceTypeRepository */
    private $resourceTypeRepository;

    public function __construct(ResourceTypeContract $resourceTypeService, ResourceTypeRepository $resourceTypeRepository)
    {
        $this->resourceTypeService = $resourceTypeService;
        $this->resourceTypeRepository = $resourceTypeRepository;
    }

    public function index(Request $request)
    {
        $length = $request->input('length');
        $sortBy = $request->input('column');
        $orderBy = $request->input('dir');
        $searchValue = $request->input('search');

        $query = $this->resourceTypeService->datatableSearchQuery(ResourceTypeRepository::class, $sortBy, $orderBy, $searchValue);
        $data = $query->paginate($length);

        return new DataTableCollectionResource($data);
    }

    public function show(ResourceType $resourceType)
    {
        return $this->resourceTypeService->detailResource($resourceType, ResourceTypeResource::class,
            'Resource Type showed!');
    }

    public function store(ResourceTypeRequest $request)
    {
        return $this->resourceTypeService->createdResource(ResourceTypeRepository::class, $request->getParams(),
            ResourceTypeResource::class, 'Resource Type created!');
    }

    public function update(ResourceTypeRequest $request, ResourceType $resourceType)
    {
        return $this->resourceTypeService->updatedResource(ResourceTypeRepository::class, $resourceType, $request->getParams(),
            ResourceTypeResource::class, 'Resource Type updated!');
    }

    public function destroy(ResourceType $resourceType)
    {
        return $this->resourceTypeService->destroy(ResourceTypeRepository::class, $resourceType,
            ResourceTypeResource::class, 'Resource Type deleted!');
    }

    public function search()
    {
        $resourceTypes = $this->resourceTypeRepository->all();

        if(!$resourceTypes->count()) {
            return response()->json([
                'data' => []
            ]);
        }

        return response()->json([
            'data' => $resourceTypes
        ]);
    }
}
