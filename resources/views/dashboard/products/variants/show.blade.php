@extends('dashboard.layout.master')
@section('style')
    <style>
        .image-card {
            position: relative;
            overflow: hidden;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            transition: transform 0.2s;
            margin-bottom: 25px;
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
    @php
        $lang = app()->getLocale();
    @endphp
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
        <!-- Main Content -->
        <div id="content">
            <!-- Begin Page Content -->
            <div class="container-fluid">
                <div class="card shadow mb-4">
                    <div style="display: block;width: 100%" class="card-header table-header py-3">
                        <h4 class="m-0 font-weight-bold text-primary">{{__('Product') . ': ' . $product['name_' . $lang]}}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th colspan="2">{{$variant->id}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <th scope="row">{{__('Product Name')}}</th>
                                        <td>{{$product['name_' . $lang]}}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">{{__('Price')}}</th>
                                        <td colspan="2">{{$variant->price}}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">{{__('Quantity')}}</th>
                                        <td colspan="2">{{$variant->quantity}}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">{{ $variant->primaryAttribute['name_' . app()->getLocale()] }}</th>
                                        <td colspan="2">{{ $variant->primaryAttributeValue['value_' . app()->getLocale()] }}</td>
                                    </tr>
                                   <tr>
                                        <th scope="row">{{ $variant->secondaryAttribute['name_' . app()->getLocale()] }}</th>
                                        <td colspan="2">{{ $variant->secondaryAttributeValue['value_' . app()->getLocale()] }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                            <br>
                            <div class="container py-5">
                                <div class="row g-4" id="gallery">
                                    @foreach($variant->media as $media)
                                        <!-- Sample Image Card -->
                                        <div class="col-md-4">
                                            <form id="imageForm{{$media->id}}" method="POST">
                                                <input type="hidden" name="token" value="{{csrf_token()}}">
                                                <div class="image-card">
                                                    <span class="btn btn-sm btn-danger delete-btn"
                                                          onclick="deleteMedia('{{route("admin.products.variants.remove-media", [$variant, $media])}}', this)">
                                                        <i class="fas fa-fw fa-trash"></i>
                                                    </span>
                                                    <img src="{{asset('storage/'. $media->file_name)}}" alt="Image">
                                                </div>
                                            </form>
                                        </div>
                                    @endforeach
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
            <script>
                function deleteMedia(url, button) {
                    let token = document.querySelector('input[name="token"]').value;

                    return fetch(url, {
                        method: 'POST',
                        headers: {
                            "x-csrf-token": token,
                            "accept": "application/json"
                        },
                        // body: formData
                    })
                        .then((response) => response.json())
                        .then((data) => {
                            if(data.errors){
                                let message = data.message;
                                alert(message);
                            }else{
                                button.closest('.col-md-4').remove();
                                return data;
                            }
                        })
                        .catch((error) => {
                            alert(error);
                        });
                }
            </script>
    @endpush
