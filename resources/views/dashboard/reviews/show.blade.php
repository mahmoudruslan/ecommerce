@extends('dashboard.layout.master')

@section('title')
    {{ __('Show Review') }}
@endsection
@section('content')
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
        <!-- Main Content -->
        <div id="content">
            <!-- Begin Page Content -->
            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="card shadow mb-4">
                    <div style="display: block;width: 100%" class="card-header table-header py-3">
                        <h4 class="m-0 font-weight-bold text-primary">{{ __('Show Review') }} :
                            {{ $review->user->full_name }}</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th scope="row">{{ __("User") }}</th>
                                    <td>{{ $review->user->full_name }} ({{ $review->user->email }})</td>
                                </tr>
                                <tr>
                                    <th scope="row">{{ __("Product") }}</th>
                                    <td>Mark</td>
                                </tr>
                            
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    @endsection
