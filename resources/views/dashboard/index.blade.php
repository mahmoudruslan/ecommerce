@extends('dashboard.layout.master')
@section('content')

                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">{{__('Dashboard')}}</h1>
                        {{-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> {{__('Generate Report')}}</a> --}}
                    </div>
                    @livewire('dashboard.statistics')
                    @livewire('dashboard.charts')

                </div>
@endsection


