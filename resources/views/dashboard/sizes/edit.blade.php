@extends('dashboard.layout.master')

@section('title')
    {{ __('Edit Sizes') }}
@endsection
@section('content')
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
        <!-- Main Content -->
        <div id="content">
            <!-- Begin Page Content -->
            <div class="container-fluid">
                <!-- Page Heading -->
                <h1 class="h3 mb-2 text-gray-800">{{ __('Edit Category') }}</h1>
                <div class="row justify-content-center">

                    <div class="col-xl-10 col-lg-12 col-md-9">

                        <div class="card o-hidden border-0 shadow-lg my-4">
                            <div class="card-body p-0">
                                <!-- Nested Row within Card Body -->
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="p-5">
                                            <div class="text-center">
                                                <h1 class="h4 text-gray-900 mb-4">{{ __('Edit') }} :
                                                    {{ __($size['name']) }}</h1>
                                            </div>
                                            <form action="{{ route('admin.sizes.update', $size->id) }}"
                                                method="POST" class="user">
                                                @method('patch')
                                                @csrf
                                                <div class="form-group">
                                                    <input value="{{ $size->name }}" type="text" name="name"
                                                        class="form-control form-control-user"
                                                        placeholder="{{ __('Enter Name') }}">
                                                    @error('name')
                                                        <span class="text-danger" role="alert">
                                                            <small>{{ $message }}</small>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <br>
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
        <!-- Outer Row -->
    @endsection

