@extends('dashboard.layout.master')
@section('style')
    <style>
        .image-card {
            position: relative;
            overflow: hidden;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            transition: transform 0.2s;
        }
        .image-card:hover {
            transform: scale(1.02);
        }
        .image-card img {
            width: 100%;
            height: 230px;
            object-fit: cover;
        }
        .delete-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            z-index: 10;
        }
    </style>
@stop
@section('content')
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
        <!-- Main Content -->
        <div id="content">
            <!-- Begin Page Content -->
            <div class="container-fluid">
                <div class="card shadow mb-4">
                    <div style="display: block;width: 100%" class="card-header table-header py-3">
                        <h4 class="m-0 font-weight-bold text-primary">{{__('Products') . ': ' . $product['name_' . app()->getLocale()]}}</h4>
                        @can('update-variants')
                            <a href="{{route('admin.products.variants.create', $product)}}" class="btn btn-primary">
                                {{__('Add variants')}}
                                <i class="fa fa-plus plus"></i>
                            </a>
                        @endcan
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">{{$product->id}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <th scope="row">{{__('Name')}}</th>
                                        <td>{{$product['name_' . app()->getLocale()]}}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">{{__('Description')}}</th>
                                        <td>{{$product['description_' . app()->getLocale()]}}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">{{__('Slug')}}</th>
                                        <td colspan="2">{{$product->slug}}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">{{__('Price')}}</th>
                                        <td colspan="2">{{$product->price}}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">{{__('Sub category')}}</th>
                                        <td colspan="2">{{$product->category['name_' . app()->getLocale()]}}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">{{__('Category')}}</th>
                                        <td colspan="2">{{$product->category->parent['name_' . app()->getLocale()]}}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">{{__('Video link')}}</th>
                                        <td colspan="2">
                                            <a target="_blank"
                                               href="{{$product->video_link}}">{{__('Show in youtub')}}</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">{{__('iframe')}}</th>
                                        <td colspan="2">{{ $product->iframe }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">{{__('Featured')}}</th>
                                        <td colspan="2">{{$product->featured}}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">{{__('Status')}}</th>
                                        <td colspan="2">{{$product->status}}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">{{__('Has Variants')}}</th>
                                        <td colspan="2">{{$product->has_variants}}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <br>
                        @if($product->has_variants)
                            <h4 class="m-0 font-weight-bold text-primary">{{__('Variants')}}</h4>
                            <br>
                            <div class="table-responsive">
                                {!! $dataTable->table() !!}
                                {!! $dataTable->scripts() !!}

                            </div>
                        @else
                            <div class="container py-5">
                                <div class="row g-4" id="gallery">
                                    @foreach($product->media as $media)
                                        <!-- Sample Image Card -->
                                    <form id="imageForm{{$media->id}}" method="POST">
                                        <input type="hidden" name="token" value="{{csrf_token()}}">
                                        <input type="hidden" name="media_id" value="{{$media->id}}">
                                        <input type="hidden" name="product_id" value="{{$product->id}}">
                                        <div class="col-md-4">
                                            <div class="image-card">
                                                <span class="btn btn-sm btn-danger delete-btn" onclick="deleteImage('{{route("admin.products.remove-image", $product->id)}}', {{$media->id}}, this)">
                                                    <i class="fas fa-fw fa-trash"></i>
                                                </span>
                                                <img src="{{asset('storage/'. $media->file_name)}}" alt="Image">
                                            </div>
                                        </div>
                                    </form>

                                    @endforeach
                                </div>
                            </div>
                        @endif
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
    <script>
        function deleteImage(url, mediaId, button) {
            let imageForm = document.getElementById("imageForm" + mediaId);
            let formData = new FormData(imageForm);
            let token = imageForm.querySelector('input[name="token"]').value;

            return fetch(url, {
                method: 'POST',
                headers: {
                    "x-csrf-token": token,
                    "accept": "application/json"
                },
                body: formData
            })
                .then((response) => response.json())
                .then((data) => {
                    if(data.errors){
                        console.log(data.errors.media);
                        let message = data.errors.media;
                        alert(message);
                    }
                        button.closest('.col-md-4').remove();
                        return data;
                })
                .catch((error) => {
                    alert(error);
                });
        }
    </script>
@endpush
