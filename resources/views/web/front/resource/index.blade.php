@extends('layouts.web.front.layout.main')
@section('title')
    Resource Listing Page
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
                    @include('web.front.resource.partials.resources', ['resources' => $resources])
                </div>
            </div>
        </div>
    </section><!-- End Resource Section -->
@endsection
