<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

<title>

    @yield('title')
</title>
    @livewireStyles
    <!-- Custom fonts for this template-->
    <link href="{{asset('dashboard/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    {{-- <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet"> --}}
{{--  datatables --}}
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.0/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="//cdn.datatables.net/2.0.0/css/dataTables.dataTables.min.css">

{{-- bootstrap file input package => show and delete image selected--}}
{{-- @if(Config::get('app.locale') == 'ar')
    <link rel="stylesheet" href="{{ asset("dashboard/vendor/bootstrap-file-input/css/fileinput-rtl.css") }}">
@else --}}

{{-- @endif --}}


<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    @if(Config::get('app.locale') == 'ar')
            <link href="{{asset('dashboard/css/sb-admin-2-ar.min.css')}}" rel="stylesheet">

    @else
        <link href="{{asset('dashboard/css/sb-admin-2-en.min.css')}}" rel="stylesheet">

    @endif
    <link rel="stylesheet" href="{{ asset("dashboard/vendor/bootstrap-file-input/css/fileinput.min.css") }}">
</head>

<body @if(Config::get('app.locale') == 'ar') dir="rtl" @endif id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">
