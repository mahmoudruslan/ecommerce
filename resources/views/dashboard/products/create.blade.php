@extends('dashboard.layout.master')

@section('title')
    {{ __('Add Products') }}
@endsection
@section('content')
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
        <!-- Main Content -->
        <div id="content">
            <!-- Begin Page Content -->
            <div class="container-fluid">
                <!-- Page Heading -->
                <h1 class="h3 mb-2 text-gray-800">{{ __('Add Products') }}</h1>
                <div class="row justify-content-center">
                    <div class="col-xl-10 col-lg-12 col-md-9">
                        <div class="card o-hidden border-0 shadow-lg my-4">
                            <div class="card-body p-0">
                                <!-- Nested Row within Card Body -->
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="p-5">
                                            <div class="text-center">
                                                <h1 class="h4 text-gray-900 mb-4">{{ __('Add') }}</h1>
                                            </div>
                                            <form action="{{ route('admin.products.store') }}" method="POST" class="user">
                                                @csrf
                                                <div class="form-group row">
                                                    <div class="col-md-6">
                                                        <input type="text" name="name_ar" value="{{ old('name_ar') }}" class="form-control form-control-user @error('name_ar') is-invalid @enderror" placeholder="    {{ __('Enter Name In Arabic') }}">
                                                        @error('name_ar')
                                                        <span class="text-danger" role="alert">
                                                            <small>{{ $message }}</small>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="text" name="name_en" value="{{ old('name_en') }}" class="form-control form-control-user @error('name_en') is-invalid @enderror" placeholder="    {{  __('Enter Name In English') }}">
                                                        @error('name_en')
                                                        <span class="text-danger" role="alert">
                                                            <small>{{ $message }}</small>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <input type="text" name="price" value="{{ old('price') }}" class="form-control form-control-user @error('price') is-invalid @enderror" placeholder="    {{ __('Enter Price') }}">
                                                            @error('price')
                                                            <span class="text-danger" role="alert">
                                                                <small>{{ $message }}</small>
                                                            </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <input type="text" name="quantity" value="{{ old('quantity') }}" class="form-control form-control-user @error('quantity') is-invalid @enderror" placeholder="    {{ __('Enter Quantity') }}">
                                                            @error('quantity')
                                                            <span class="text-danger" role="alert">
                                                                <small>{{ $message }}</small>
                                                            </span>
                                                            @enderror

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-6">
                                                        <input type="text" name="featured" class="form-control form-control-user @error('featured') is-invalid @enderror" placeholder="    {{ __('Enter Featured') }}">
                                                        @error('featured')
                                                        <span class="text-danger" role="alert">
                                                            <small>{{ $message }}</small>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <label>{{ __('Choose Image') }}</label>
                                                                @error('image')
                                                                <span class="text-danger" role="alert">
                                                                    <small>{{ $message }}</small>
                                                                </span>
                                                                @enderror
                                                            </div>
                                                            <div class="col-md-8">
                                                                <input type="file" id="inputGroupFile01" name="category_id">
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-6">
                                                        <textarea style="background-position: top calc(0.375em + 2.1875rem) right calc(0.375em + 0.1875rem);" type="text" name="description_ar" value="{{ old('description_ar') }}" class="form-control form-control-user
                                                        @error('description_ar') is-invalid @enderror" placeholder="   {{ __('Enter Description In Arabic') }}"></textarea>
                                                        @error('description_ar')
                                                        <span class="text-danger" role="alert">
                                                            <small>{{ $message }}</small>
                                                        </span>
                                                        @enderror
                                                    </div>

                                                    <div class="col-md-6">
                                                        <textarea  style="background-position: top calc(0.375em + 2.1875rem) right calc(0.375em + 0.1875rem);" type="text" name="description_en" value="{{ old('description_en') }}" class="form-control form-control-user
                                                        @error('description_en') is-invalid @enderror" placeholder="   {{ __('Enter Description In English') }}"></textarea>
                                                        @error('description_en')
                                                        <span class="text-danger" role="alert">
                                                            <small>{{ $message }}</small>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-6">
                                                        {{-- <input type="text" name="category_id"  placeholder="{{ __('Category') }}"> --}}
                                                        <select name="category_id" style="border-radius: 10rem;height:100%" class="form-control">
                                                            <option disabled selected>{{ __('Choose Category') }}</option>
                                                            @foreach($categories as $category)
                                                            <option value="{{ $category->id }}">{{ $category->parent['name_'. App::currentLocale()] }} | {{ $category['name_'. App::currentLocale()] }}</option>
                                                            @endforeach

                                                        </select>
                                                        @error('category_id')
                                                        <span class="text-danger" role="alert">
                                                            <small>{{ $message }}</small>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="text" name="status" class="form-control form-control-user" placeholder="{{ __('Status') }}">
                                                        @error('status')
                                                        <span class="text-danger" role="alert">
                                                            <small>{{ $message }}</small>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <br>
                                                <hr>

                                                    <button type="submit" class="btn btn-primary btn-user btn-block">
                                                        {{ __('Save') }}
                                                    </button>
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
