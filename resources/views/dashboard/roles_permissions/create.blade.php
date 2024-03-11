@extends('dashboard.layout.master')

@section('title')
    {{ __('Add roles and permissions') }}
@endsection
@section('content')
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
        <!-- Main Content -->
        <div id="content">
            <!-- Begin Page Content -->
            <div class="container-fluid">
                <!-- Page Heading -->
                <h1 class="h3 mb-2 text-gray-800">{{ __('Add roles and permissions') }}</h1>
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
                                            <form action="{{ route('admin.permission-role.store') }}" method="POST"
                                                class="user">
                                                @csrf
                                                <div class="form-group">
                                                    <input type="text" name="name" class="form-control form-control-user" placeholder="{{ __('Enter Role Name...') }}">
                                                    @error('name')
                                                    <span class="text-danger" role="alert">
                                                        <small>{{ $message }}</small>
                                                    </span>
                                                    @enderror
                                                </div>

                                                    <div class="form-group">
                                                        <h1 class="h3 mb-2 text-gray-800">{{ __('Permissions') }}</h1>
                                                        @error('permissions')
                                                    <span class="text-danger" role="alert">
                                                        <small>{{ $message }}</small>
                                                    </span><br>
                                                @enderror
                                                        @foreach ($permissions as $permission)
                                                            <div style="display: inline-block"
                                                                class="custom-control custom-checkbox small">
                                                                <input name="permissions[]" type="checkbox"
                                                                    class="custom-control-input" value="{{ $permission->name }}"
                                                                    id="customCheck{{ $loop->index }}">
                                                                <label class="custom-control-label"
                                                                    for="customCheck{{ $loop->index }}">{{ __($permission->name) }}</label>
                                                            </div>
                                                        @endforeach

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
