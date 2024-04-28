@extends('dashboard.layout.master')

@section('title')
    {{ __('Add governorates') }}
@endsection
@section('content')
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
        <!-- Main Content -->
        <div id="content">
            <!-- Begin Page Content -->
            <div class="container-fluid">
                <!-- Page Heading -->
                <h1 class="h3 mb-2 text-gray-800">{{ __('Add governorates') }}</h1>
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
                                            <form action="{{ route('admin.governorates.store') }}" method="POST" class="user">
                                                @csrf
                                                <div class="form-group">
                                                    <input type="text" name="name_ar" class="form-control form-control-user" placeholder="{{ __('Enter Name In Arabic') }}">
                                                    @error('name_ar')
                                                    <span class="text-danger" role="alert">
                                                        <small>{{ $message }}</small>
                                                    </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <input type="text" name="name_en" class="form-control form-control-user" placeholder="{{ __('Enter Name In English') }}">
                                                    @error('name_en')
                                                    <span class="text-danger" role="alert">
                                                        <small>{{ $message }}</small>
                                                    </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <div class="form-check">
                                                        <input value="1" class="form-check-input" type="radio" name="status" id="flexRadioDefault1" checked>
                                                        <label class="form-check-label" for="flexRadioDefault1">
                                                        {{ __("Active") }}
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input value="0" class="form-check-input" type="radio" name="status" id="flexRadioDefault2">
                                                        <label class="form-check-label" for="flexRadioDefault2">
                                                            {{ __("Inactive") }}
                                                        </label>
                                                    </div>
                                                    @error('status')
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
        @endsection
