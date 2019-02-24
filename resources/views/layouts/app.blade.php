<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" type="image/png" href="{{ asset('/images/icon.png')}}"/>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('fonts/Linearicons-Free-v1.0.0/icon-font.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/animate/animate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/css-hamburgers/hamburgers.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/animsition/css/animsition.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/select2/select2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/util.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/main.css') }}">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        .loader {
            position: fixed;
            left: 0px;
            top: 0px;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background: url("{{ asset('/images/3.gif')}}") 50% 50% no-repeat rgb(249,249,249) ;
            opacity: .8;
            background-size:120px 120px;
            }  
    </style>
</head>
<body>
    
        <div id = "myDiv" style="display:none;" class="loader">
        </div>
        @yield('content')
	    <script src="{{ asset('vendor/jquery/jquery-3.2.1.min.js') }}"></script>
        <script src="{{ asset('vendor/animsition/js/animsition.min.js') }}"></script>
        <script src="{{ asset('vendor/bootstrap/js/popper.js') }}"></script>
        <script src="{{ asset('vendor/bootstrap/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('vendor/select2/select2.min.js') }}"></script>
        <script src="{{ asset('vendor/daterangepicker/moment.min.js') }}"></script>
        <script src="{{ asset('vendor/daterangepicker/daterangepicker.js') }}"></script>
        <script src="{{ asset('vendor/countdowntime/countdowntime.js') }}"></script>
        <script src="{{ asset('js/main.js') }}"></script>
        <script>
        function show() {
            document.getElementById("myDiv").style.display="block";
        }
        </script>
    
</body>
</html>
