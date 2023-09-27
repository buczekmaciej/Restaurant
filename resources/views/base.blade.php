<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta content="width=device-width, initial-scale=1" name="viewport">

        <title>@yield('title', 'Base') | Restaurant</title>
        @vite('resources/css/app.css')
    </head>

    <body class="@yield('class')">
        @yield('body')
    </body>

</html>
