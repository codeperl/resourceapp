<tr>
    <td scope="row">{{ $resource->id }}</td>
    <td>{{ $resource->resource_type->name }}</td>
    <td>{{ $resource->title }}</td>
    <td>
        <a href="{{ route('web.front.resources.show', ['resource' => $resource->id]) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i> VIEW DETAIL</a>
    </td>
</tr>
