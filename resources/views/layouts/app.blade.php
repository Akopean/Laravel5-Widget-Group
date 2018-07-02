<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <title>@yield('page_title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    @yield('css')
    <!-- App CSS -->
    <link rel="stylesheet" href="{{ widgets_asset('css/app.css') }}">
</head>

<body>

<div class="container-fluid">
    @yield('page_header')
<!-- START THE MAIN CONTENT HERE -->
    @yield('content')
    <?php app('WidgetGroup')->run('leftSidebar'); ?>
</div>
<script type="text/javascript" src="{{ widgets_asset('js/app.js') }}"></script>
@yield('javascript')
</body>
</html>
