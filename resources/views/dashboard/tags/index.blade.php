@extends('dashboard.layout.master')
@section('content')
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <div class="card shadow mb-4">
                        <div style="display: block;width: 100%" class="card-header table-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">{{__('Tags')}}</h6>
                            @can('store-tags')
                                <a  href="{{route('admin.tags.create')}}" class="btn btn-primary">
                                    {{__('Add Tags')}}
                                    <i class="fa fa-plus plus"></i>
                                </a>
                            @endcan

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
