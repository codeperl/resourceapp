@extends('layouts.web.front.layout.main')
@section('title')
    Resource Detail Page
@endsection
@section('meta')
    @parent
@endsection
@section('css')
    @parent
@endsection
@section('content')
    <!-- ======= Resource Section ======= -->
    <section class="resource">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 entries">
                    {{--{{ dd($resource) }}--}}
                    <table class="table align-middle table-sm table-striped table-hover table-borderless">
                        <thead class="table-dark">
                        <tr>
                            <td scope="col">Column</td>
                            <td scope="col">Data</td>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($resource as $column => $cell)
                                @if($cell)
                                <tr>
                                    <td>{{ humanize_dashed_column($column) }}</td>
                                    <td>
                                        @if(is_object($cell))
                                            {{ $cell->name }}
                                        @else
                                            {!! get_cell_data($resource, $column, $cell) !!}
                                        @endif
                                    </td>
                                </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section><!-- End Resource Section -->
@endsection
