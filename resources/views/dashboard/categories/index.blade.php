@extends('dashboard.layout.master')
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
                            <h4 class="m-0 font-weight-bold text-primary">{{__('Categories')}}</h4>
                            <a  href="{{route('admin.categories.create')}}" class="btn btn-primary">
                                {{__('Add Categories')}}
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

