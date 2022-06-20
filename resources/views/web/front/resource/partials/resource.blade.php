<tr>
    <td scope="row">{{ $resource->id }}</td>
    <td>{{ $resource->resource_type->name }}</td>
    <td>{{ $resource->title }}</td>
    <td>
        <a href="{{ route('web.front.resources.show', ['resource' => $resource->id]) }}" class="btn btn-sm btn-primary">SHOW</a>
    </td>
</tr>
