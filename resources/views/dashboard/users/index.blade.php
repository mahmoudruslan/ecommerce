@extends('dashboard.layout.master')
@section('content')

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Page Heading -->
                    @if (Session::has('success'))
                        <div class="text-center alert alert-success">{{ Session::get('success') }}</div>
                    @endif
                        @if (Session::has('error'))
                        <div class="text-center alert alert-danger">{{ Session::get('error') }}</div>
                    @endif
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div style="display: block;width: 100%" class="card-header table-header py-3">
                            <h4 class="m-0 font-weight-bold text-primary">{{__('Users')}}</h4>
                            <a  href="{{route('admin.users.create')}}" class="btn btn-primary">
                                {{__('Add Users')}}
                                <i class="fa fa-plus plus"></i>
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                {!! $dataTable->table() !!}
                                {!! $dataTable->scripts() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>


@endsection
@push('script')

@endpush
