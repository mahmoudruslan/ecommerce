@extends('dashboard.layout.master')

@section('title')
    {{ __('Edit Products') }}
@endsection
@section('content')
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
        <!-- Main Content -->
        <div id="content">
            <!-- Begin Page Content -->
            <div class="container-fluid">
                <!-- Page Heading -->
                <h1 class="h3 mb-2 text-gray-800">{{ __('Edit Products') }}</h1>
                <div class="row justify-content-center">

                    <div class="col-xl-10 col-lg-12 col-md-9">

                        <div class="card o-hidden border-0 shadow-lg my-4">
                            <div class="card-body p-0">
                                <!-- Nested Row within Card Body -->
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="p-5">
                                            <div class="text-center">
                                                <h1 class="h4 text-gray-900 mb-4">{{ __('Edit') }}</h1>
                                            </div>
                                            <form action="{{ route('admin.products.update', $category->id) }}" method="POST"
                                                class="user">
                                                @method('patch')
                                                @csrf
                                                <input type="hidden" name="id" value="{{$category->id}}"><!--for validation request -->
                                                <div class="form-group">
                                                    <input value="{{$category->name_ar}}" type="text" name="name_ar" class="form-control form-control-user" placeholder="{{ __('Enter Name In Arabic') }}">
                                                    @error('name_ar')
                                                    <span class="text-danger" role="alert">
                                                        <small>{{ $message }}</small>
                                                    </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <input value="{{$category->name_en}}" type="text" name="name_en" class="form-control form-control-user" placeholder="{{ __('Enter Name In English') }}">
                                                    @error('name_en')
                                                    <span class="text-danger" role="alert">
                                                        <small>{{ $message }}</small>
                                                    </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label>{{ __('Choose Image') }}</label>
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                          <span class="input-group-text">Upload</span>
                                                        </div>
                                                        <div style="border: #eaecf4 1px solid" class="custom-file">
                                                          <input type="file" class="custom-file-input" id="inputGroupFile01">
                                                          <label style="left : 0" class="custom-file-label" for="inputGroupFile01">

                                                            {{-- <span>Choose file<span> --}}
                                                        </label>
                                                        </div>
                                                      </div>
                                                    @error('image')
                                                    <span class="text-danger" role="alert">
                                                        <small>{{ $message }}</small>
                                                    </span>
                                                    @enderror
                                                </div>



                                                    <button type="submit" class="btn btn-primary btn-user btn-block">
                                                        {{ __('Save') }}
                                                    </button>
                                                    <hr>

                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>


                </div>
            </div>
            <!-- Outer Row -->
        @endsection
