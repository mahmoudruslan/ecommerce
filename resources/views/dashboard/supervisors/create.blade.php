@extends('dashboard.layout.master')

@section('title')
    {{ __('Add Supervisor') }}
@endsection
@section('content')
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
        <!-- Main Content -->
        <div id="content">
            <!-- Begin Page Content -->
            <div class="container-fluid">
                <!-- Page Heading -->
                <h1 class="h3 mb-2 text-gray-800">{{ __('Add Supervisor') }}</h1>
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
                                            <form action="{{ route('admin.supervisors.store') }}" method="POST"
                                                class="user" enctype="multipart/form-data">
                                                @csrf
                                                <div class="form-group row">
                                                    <div class="col-md-6">
                                                        <input type="text" name="first_name"
                                                            value="{{ old('first_name') }}"
                                                            class="form-control form-control-user @error('first_name') is-invalid @enderror"
                                                            placeholder="{{ __('Enter First Name') }}">
                                                        @error('first_name')
                                                            <span class="text-danger" role="alert">
                                                                <small>{{ $message }}</small>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="text" name="last_name"
                                                            value="{{ old('last_name') }}"
                                                            class="form-control form-control-user @error('last_name') is-invalid @enderror"
                                                            placeholder="{{ __('Enter Last Name') }}">
                                                        @error('last_name')
                                                            <span class="text-danger" role="alert">
                                                                <small>{{ $message }}</small>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <input type="text" name="username"
                                                                value="{{ old('username') }}"
                                                                class="form-control form-control-user @error('username') is-invalid @enderror"
                                                                placeholder="   {{ __('Enter Username') }}">
                                                            @error('username')
                                                                <span class="text-danger" role="alert">
                                                                    <small>{{ $message }}</small>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <input type="text" name="email"
                                                                value="{{ old('email') }}"
                                                                class="form-control form-control-user @error('email') is-invalid @enderror"
                                                                placeholder="   {{ __('Enter Email') }}">
                                                            @error('email')
                                                                <span class="text-danger" role="alert">
                                                                    <small>{{ $message }}</small>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-6">
                                                        <input type="password" name="password"
                                                            class="form-control form-control-user @error('password') is-invalid @enderror"
                                                            placeholder="{{ __('Enter Password') }}">
                                                        @error('password')
                                                            <span class="text-danger" role="alert">
                                                                <small>{{ $message }}</small>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="password" name="password_confirmation"
                                                            class="form-control form-control-user"
                                                            placeholder="{{ __('Confirm Password') }}">
                                                        @error('confirm')
                                                            <span class="text-danger" role="alert">
                                                                <small>{{ $message }}</small>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-6">
                                                        <input type="text" name="mobile" value="{{ old('mobile') }}"
                                                            class="form-control form-control-user @error('mobile') is-invalid @enderror"
                                                            placeholder="{{ __('Enter Phone Number') }}">
                                                        @error('mobile')
                                                            <span class="text-danger" role="alert">
                                                                <small>{{ $message }}</small>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-6">
                                                        <select name="role" class="form-control" style="height: 100%">
                                                            <option selected disabled>{{ __('Choose Role') }}</option>
                                                            @foreach ($roles as $role)
                                                                <option value="{{ $role->name }}">{{ $role->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        @error('roles')
                                                            <span class="text-danger" role="alert">
                                                                <small>{{ $message }}</small>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-6">

                                                        <div class="col-md-6">
                                                            <div class="mt-3">
                                                                <input type="checkbox" name="status" value="1"
                                                                    placeholder="{{ __('Enter Name In English') }}">
                                                                <label>{{ __('Status') }}</label>
                                                            </div>
                                                            @error('status')
                                                                <span class="text-danger" role="alert">
                                                                    <small>{{ $message }}</small>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <input type="file" name="image" class="file" id="input-id"
                                                    data-preview-file-type="text">
                                                @error('image')
                                                    <span class="text-danger" role="alert">
                                                        <small>{{ $message }}</small>
                                                    </span>
                                                @enderror
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
    @push('script')
        <script>
            $("#input-id").fileinput({
                required: true,
                showUpload: false,
                showRemove: false,
            });
        </script>
    @endpush
