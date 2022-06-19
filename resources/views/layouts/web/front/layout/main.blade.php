<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @section('meta')
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
    @show

    @section('css')
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Roboto:300,300i,400,400i,500,500i,700,700i&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Work+Sans&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Cutive&family=Special+Elite&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Signika:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        <!-- Styles -->
        <link href="{{ url('/css/web/front/fonts.css') }}" rel="stylesheet">
        <link href="{{ url('/css/web/front/app.css') }}" rel="stylesheet">
        <link href="{{ url('/css/web/front/style.css') }}" rel="stylesheet">
        <link href="{{ url('/css/web/front/front.css') }}" rel="stylesheet">
        <link href="{{ url('/css/web/front/contrast.css') }}" rel="stylesheet">
    @show
</head>
<body id="top">
    @include('layouts.web.front.layout.partials.header')

    <main id="main">
        @yield('content')
    </main><!-- End #main -->

    @include('layouts.web.front.layout.partials.footer')
    @section('js')
        <script src="{{ url('/js/web/front/app.js') }}" defer></script>
        <script src="{{ url('/js/web/front/main.js') }}" defer></script>
        <script src="{{ url('/js/web/front/custom.js') }}" defer></script>
    @show
</body>
</html>
