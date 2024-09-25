<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Boutique | Ecommerce bootstrap template</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">
    <!-- gLightbox gallery-->
    <link rel="stylesheet" href="{{asset('store/vendor/glightbox/css/glightbox.min.css')}}">
    <!-- Range slider-->
    <link rel="stylesheet" href="{{asset('store/vendor/nouislider/nouislider.min.css')}}">
    <!-- Choices CSS-->
    <link rel="stylesheet" href="{{asset('store/vendor/choices.js/public/assets/styles/choices.min.css')}}">
    <!-- Swiper slider-->
    <link rel="stylesheet" href="{{asset('store/vendor/swiper/swiper-bundle.min.css')}}">
    <!-- Google fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Libre+Franklin:wght@300;400;700&amp;display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Martel+Sans:wght@300;400;800&amp;display=swap">
    <!-- theme stylesheet-->

    @if(Config::get('app.locale') == 'ar')
<link rel="stylesheet" href="{{asset('store/css/style_ar.default.css')}}" id="theme-stylesheet">

    @else
<link rel="stylesheet" href="{{asset('store/css/style_en.default.css')}}" id="theme-stylesheet">

    @endif
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="{{asset('store/css/custom.css')}}">
    <!-- Favicon-->
    <link rel="shortcut icon" href="{{asset('store/img/favicon.png')}}">
    @livewireStyles
  </head>
  <body @if(Config::get('app.locale') == 'ar') dir="rtl" @endif>
    <div class="page-holder">
    <div class="container m-auto">
