<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Boutique | Ecommerce bootstrap template</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- gLightbox gallery-->
    <link rel="stylesheet" href="{{ asset('store/vendor/glightbox/css/glightbox.min.css') }}">
    <!-- Range slider-->
    <link rel="stylesheet" href="{{ asset('store/vendor/nouislider/nouislider.min.css') }}">
    <!-- Choices CSS-->
    <link rel="stylesheet" href="{{ asset('store/vendor/choices.js/public/assets/styles/choices.min.css') }}">
    <!-- Swiper slider-->
    <link rel="stylesheet" href="{{ asset('store/vendor/swiper/swiper-bundle.min.css') }}">
    <!-- Google fonts-->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Libre+Franklin:wght@300;400;700&amp;display=swap">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Martel+Sans:wght@300;400;800&amp;display=swap">
    <!-- theme stylesheet-->

    @if (Config::get('app.locale') == 'ar')
        <link rel="stylesheet" href="{{ asset('store/css/style_ar.default.css') }}" id="theme-stylesheet">
    @else
        <link rel="stylesheet" href="{{ asset('store/css/style_en.default.css') }}" id="theme-stylesheet">
    @endif
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="{{ asset('store/css/custom-alert.css') }}">
    <link rel="stylesheet" href="{{ asset('store/css/custom-loading.css') }}">
    @yield('style')
    <style>
    </style>
    <!-- Favicon-->
    <link rel="shortcut icon" href="{{ asset('store/img/favicon.png') }}">
    @livewireStyles
</head>

<body @if (Config::get('app.locale') == 'ar') dir="rtl" @endif>
    {{-- <div id="loader" class="loader" style="background: url({{asset('store/icons/25.gif')}}) 50% 50% no-repeat
        rgba(255, 255, 255, 0.8);
    vertical-align: middle"></div> --}}
    <div style="display: none" class="loader">
        <div class="loadingio-spinner-spinner-nq4q5u6dq7r">
            <div class="ldio-x2uulkbinbj">
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>
    </div>

    <div class="page-holder">
        <div class="container m-auto">
