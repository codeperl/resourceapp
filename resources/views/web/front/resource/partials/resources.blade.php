@if($resources->count())
    <div class="table-responsive">
        <table class="table align-middle table-sm table-striped table-hover table-borderless">
            <thead class="table-dark">
                <tr>
                    <td scope="col">#</td>
                    <td scope="col">Title</td>
                    <td scope="col">Action</td>
                </tr>
            </thead>
            <tbody>
                @foreach($resources as $resource)
                    @include('web.front.resource.partials.resource', ['resource' => $resource])
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="col-lg-12 entries">
        <div class="row g-0">
            <div class="col d-flex justify-content-center">
                {!! $resources->links() !!}
            </div>
        </div>
    </div>
@else
    <article class="entry">
        <h5>No resource available!</h5>
    </article>
@endif
