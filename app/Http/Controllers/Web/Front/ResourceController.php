<?php

namespace App\Http\Controllers\Web\Front;

use App\Enums\Paginator;
use App\Http\Controllers\Controller;
use App\Models\Resource;
use App\Repositories\ResourceRepository;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use App\Enums\Storage as StorageDisks;

class ResourceController extends Controller
{
    /** @var ResourceRepository */
    private $resourceRepository;

    public function __construct(ResourceRepository $resourceRepository)
    {
        $this->resourceRepository = $resourceRepository;
    }

    public function index()
    {
        $resources = $this->resourceRepository->paginate(Paginator::ITEM_PER_PAGE);

        return view('web.front.resource.index', compact('resources'));
    }

    public function show(Resource $resource)
    {
        return view('web.front.resource.show', ['resource' => $resource->only(['resource_type', 'title', 'url', 'description', 'code_snippet', 'open_in_new_tab'])]);
    }

    public function download($fileName)
    {
        $file = Storage::disk(StorageDisks::ADMIN_UPLOADED_STORAGE)->get($fileName);;

        return (new Response($file, 200))
            ->header('Content-Type', 'application/pdf');
    }
}
