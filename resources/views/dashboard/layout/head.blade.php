<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Dashboard</title>

    <!-- Custom fonts for this template-->
    <link href="{{asset('dashboard/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->

        @if(Config::get('app.locale') == 'ar')
<link href="{{asset('dashboard/css/sb-admin-2-ar.min.css')}}" rel="stylesheet">

    @else
<link href="{{asset('dashboard/css/sb-admin-2-en.min.css')}}" rel="stylesheet">

    @endif

</head>

<body @if(Config::get('app.locale') == 'ar') dir="rtl" @endif id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">
