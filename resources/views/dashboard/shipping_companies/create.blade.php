@extends('dashboard.layout.master')

@section('title')
    {{ __('Add shipping companies') }}
@endsection
@section('content')
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
        <!-- Main Content -->
        <div id="content">
            <!-- Begin Page Content -->
            <div class="container-fluid">
                <!-- Page Heading -->
                <h1 class="h3 mb-2 text-gray-800">{{ __('Add shipping companies') }}</h1>
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
                                            <form action="{{ route('admin.shipping-companies.store') }}" method="POST"
                                                class="user" enctype="multipart/form-data">
                                                @csrf
                                                <div class="form-group row">
                                                    <div class="col-md-6">
                                                        <input type="text" name="name_ar" value="{{ old('name_ar') }}" class="form-control form-control-user @error('name_ar') is-invalid @enderror" placeholder="{{ __('Name in arabic') }}">
                                                        @error('name_ar')
                                                        <span class="text-danger" role="alert">
                                                            <small>{{ $message }}</small>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="text" name="name_en" value="{{ old('name_en') }}" class="form-control form-control-user @error('name_en') is-invalid @enderror" placeholder="{{ __('Name in english') }}">
                                                        @error('name_en')
                                                        <span class="text-danger" role="alert">
                                                            <small>{{ $message }}</small>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-6">
                                                        <input type="text" name="description_ar" value="{{ old('description_ar') }}" class="form-control form-control-user @error('description_ar') is-invalid @enderror" placeholder="{{ __('Description in arabic') }}">
                                                        @error('description_ar')
                                                        <span class="text-danger" role="alert">
                                                            <small>{{ $message }}</small>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="text" name="description_en" value="{{ old('description_en') }}" class="form-control form-control-user @error('description_en') is-invalid @enderror" placeholder="{{ __('Description in english') }}">
                                                        @error('description_en')
                                                        <span class="text-danger" role="alert">
                                                            <small>{{ $message }}</small>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                    <div class="form-group row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <input type="text" name="code" value="{{ old('code') }}" class="form-control form-control-user @error('code') is-invalid @enderror" placeholder="   {{ __('Code') }}">
                                                                @error('code')
                                                                <span class="text-danger" role="alert">
                                                                    <small>{{ $message }}</small>
                                                                </span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <input type="text" name="coast" value="{{ old('coast') }}" class="form-control form-control-user @error('coast') is-invalid @enderror" placeholder="   {{ __('Coast') }}">
                                                            @error('coast')
                                                            <span class="text-danger" role="alert">
                                                                <small>{{ $message }}</small>
                                                            </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-6">
                                                        <select name="fast" class="form-control select-radius 
                                                            @error('fast') is-invalid @enderror">
                                                            <option disabled selected>{{ __("Fast") }}?</option>
                                                            <option value="1" >{{ __('Fast') }}</option>
                                                            <option value="0" >{{ __('Normal') }}</option>
                                                        </select>
                                                        @error('fast')
                                                            <span class="text-danger" role="alert">
                                                                <small>{{ $message }}</small>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-6">
                                                        <select name="status" class="form-control select-radius 
                                                            @error('status') is-invalid @enderror">
                                                            <option selected disabled>{{ __('Status') }}</option>
                                                            <option value="1" >{{ __('Active') }}</option>
                                                            <option value="0" >{{ __('Inactive') }}</option>
                                                        </select>
                                                        @error('status')
                                                            <span class="text-danger" role="alert">
                                                                <small>{{ $message }}</small>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="row form-group">
                                                    <div class="col-md-6">
                                                        <select multiple name="governorates[]" class="form-control">
                                                            @foreach($governorates as $governorate)
                                                            <option value="{{ $governorate->id }}">{{ $governorate['name_'. App::currentLocale()] }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('governorates')
                                                        <span class="text-danger" role="alert">
                                                            <small>{{ $message }}</small>
                                                        </span>
                                                        @enderror
                                                    </div> 
                                                </div>
                                                <hr>
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
    </div>
@endsection
