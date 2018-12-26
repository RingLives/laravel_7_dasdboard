<!DOCTYPE html>

<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=Edge">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <title>{{ config('app.name') }}</title>

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Favicon-->
        <link rel="icon" href="favicon.ico" type="image/x-icon">

        <!-- Bootstrap Core Css -->
        @section('css')
            <link rel="stylesheet" type="text/css" href="{{ asset('bsbmd/plugins/bootstrap/css/bootstrap.css') }}">
            <link rel="stylesheet" type="text/css" href="{{ asset('bsbmd/plugins/node-waves/waves.css') }}">
            <link rel="stylesheet" type="text/css" href="{{ asset('bsbmd/plugins/animate-css/animate.css') }}">
            <link rel="stylesheet" type="text/css" href="{{ asset('bsbmd/plugins/morrisjs/morris.css') }}">
            <link rel="stylesheet" type="text/css" href="{{ asset('bsbmd/css/style.css') }}">
            <link rel="stylesheet" type="text/css" href="{{ asset('bsbmd/css/themes/all-themes.css') }}">
             <!-- Google Fonts -->
            <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
            <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
        @show

        @yield('extra-css')

        <script>
            window.Laravel = {!! json_encode([
                'csrfToken' => csrf_token(),
            ]) !!};
        </script>
    </head>

    <body class="theme-red">
        @include('layouts.partials.loader')
            <div class="overlay"></div>
        @include('layouts.partials.header')
        @include('layouts.partials.sidebar')

        <section class="content">
            @yield('content')
        </section>

        @section('script')
            <script type="text/javascript" src="{{ asset('bsbmd/plugins/jquery/jquery.min.js') }}"></script>
            <script type="text/javascript" src="{{ asset('bsbmd/plugins/bootstrap/js/bootstrap.js') }}"></script>
            <script type="text/javascript" src="{{ asset('bsbmd/plugins/bootstrap-select/js/bootstrap-select.js') }}"></script>
            <script type="text/javascript" src="{{ asset('bsbmd/plugins/jquery-slimscroll/jquery.slimscroll.js') }}"></script>
            <script type="text/javascript" src="{{ asset('bsbmd/plugins/node-waves/waves.js') }}"></script>

        @show    
        @yield('extra-script')
        @section('script-bottom')
            <script type="text/javascript" src="{{ asset('bsbmd/js/admin.js') }}"></script>
            <script type="text/javascript" src="{{ asset('bsbmd/js/demo.js') }}"></script>
        @show
    </body>
</html>
