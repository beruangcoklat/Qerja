<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <script src="https://www.gstatic.com/firebasejs/4.12.1/firebase.js"></script>
    <script src="js/lib/jquery-3.3.1.min.js"></script>
    <script src="js/lib/vue.min.js"></script>
    <script src="js/util.js"></script>

    <link rel="icon" href="image/icon.jpg">
    <link rel="stylesheet" type="text/css" href="font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="css/general.css">
    <link rel="stylesheet" type="text/css" href="css/navbar.css">
    <link rel="stylesheet" type="text/css" href="css/modal.css">
    @yield('style')

    <title>@yield('title')</title>
</head>
<body>
    
    @include('navbar')
    @yield('content')

    <script src="js/component/component.js"></script>
    <script src="js/navbar.js"></script>
    <script src="js/modal.js"></script>
    @yield('script')
    
</body>
</html>
