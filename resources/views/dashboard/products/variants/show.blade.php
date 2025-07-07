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
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">{{$variant->id}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <th scope="row">{{__('Price')}}</th>
                                        <td>{{$variant->price}}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">{{__('Description')}}</th>
                                        <td>{{$variant['description_' . app()->getLocale()]}}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">{{__('Slug')}}</th>
                                        <td colspan="2">{{$variant->slug}}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">{{__('Price')}}</th>
                                        <td colspan="2">{{$variant->price}}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">{{__('Sub category')}}</th>
                                        <td colspan="2">{{$variant->category['name_' . app()->getLocale()]}}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">{{__('Category')}}</th>
                                        <td colspan="2">{{$variant->category->parent['name_' . app()->getLocale()]}}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">{{__('Video link')}}</th>
                                        <td colspan="2">
                                            <a target="_blank" href="{{$variant->video_link}}" >{{__('Show in youtub')}}</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">{{__('iframe')}}</th>
                                        <td colspan="2">{{ $variant->iframe }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">{{__('Featured')}}</th>
                                        <td colspan="2">{{$variant->featured}}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">{{__('Status')}}</th>
                                        <td colspan="2">{{$variant->status}}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">{{__('Has Variants')}}</th>
                                        <td colspan="2">{{$variant->has_variants}}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
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
