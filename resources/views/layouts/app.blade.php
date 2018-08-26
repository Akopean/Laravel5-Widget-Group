<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <title>@yield('page_title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    @yield('css')
</head>

<body>

<div class="container-fluid">
    @yield('page_header')
<!-- START THE MAIN CONTENT HERE -->
    @yield('content')
</div>
@yield('javascript')
</body>
</html>
