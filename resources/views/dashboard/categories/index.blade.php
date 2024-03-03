@extends('dashboard.layout.master')
@section('content')



        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">{{__('Categories')}}</h1>
                    @if (Session::has('success'))
                        <div class="text-center alert alert-success">{{ Session::get('success') }}</div>
                    @endif
                        @if (Session::has('error'))
                        <div class="text-center alert alert-danger">{{ Session::get('error') }}</div>
                    @endif
                    {{-- <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
                        For more information about DataTables, please visit the <a target="_blank"
                            href="https://datatables.net">official DataTables documentation</a>.</p> --}}

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                            <a href="{{route('admin.categories.create')}}" class="btn btn-success">{{__('Add')}}</a>
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
{{-- <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">
<script src="https://cdn.datatables.net/buttons/1.0.3/js/dataTables.buttons.min.js"></script>
<script src="/vendor/datatables/buttons.server-side.js"></script> --}}
{{-- {!! $dataTable->scripts() !!} --}}
@endpush
