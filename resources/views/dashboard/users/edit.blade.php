@extends('dashboard.layout.master')

@section('title')
    {{ __('Edit Users') }}
@endsection
@section('content')
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
        <!-- Main Content -->
        <div id="content">
            <!-- Begin Page Content -->
            <div class="container-fluid">
                <!-- Page Heading -->
                <h1 class="h3 mb-2 text-gray-800">{{ __('Edit User') }}</h1>
                <div class="row justify-content-center">
                    <div class="col-xl-10 col-lg-12 col-md-9">
                        <div class="card o-hidden border-0 shadow-lg my-4">
                            <div class="card-body p-0">
                                <!-- Nested Row within Card Body -->
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="p-5">
                                            <div class="text-center">
                                                <h1 class="h4 text-gray-900 mb-4">{{ __('Edit') }} : {{ __($user->fullName) }}</h1>
                                            </div>
                                            <form action="{{ route('admin.users.update', encrypt($user->id)) }}" method="POST" class="user"  enctype="multipart/form-data">
                                                @csrf
                                                @method('patch')
                                                <div class="form-group row">
                                                    <div class="col-md-6">
                                                        <input type="text" name="first_name" value="{{ $user->first_name }}" class="form-control form-control-user @error('first_name') is-invalid @enderror" placeholder="{{ __('Enter First Name') }}">
                                                        @error('first_name')
                                                        <span class="text-danger" role="alert">
                                                            <small>{{ $message }}</small>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="text" name="last_name" value="{{ $user->last_name }}" class="form-control form-control-user @error('last_name') is-invalid @enderror" placeholder="{{ __('Enter Last Name') }}">
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
                                                            <input type="text" name="username" value="{{ $user->username }}" class="form-control form-control-user @error('username') is-invalid @enderror" placeholder="   {{ __('Enter Username') }}">
                                                            @error('username')
                                                            <span class="text-danger" role="alert">
                                                                <small>{{ $message }}</small>
                                                            </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <input type="text" name="email" value="{{ $user->email }}" class="form-control form-control-user @error('email') is-invalid @enderror" placeholder="   {{ __('Enter Email') }}">
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
                                                        <input type="text" name="mobile" value="{{ $user->mobile }}" class="form-control form-control-user @error('mobile') is-invalid @enderror" placeholder="{{ __('Enter Phone Number') }}">
                                                        @error('mobile')
                                                        <span class="text-danger" role="alert">
                                                            <small>{{ $message }}</small>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="fileInput" class="form-control">{{ __('Choose Image') }}</label>
                                                        @error('image')
                                                        <span class="text-danger" role="alert">
                                                            <small>{{ $message }}</small>
                                                        </span>
                                                        @enderror
                                                        <input class="hidden" type="file" id="fileInput" name="image">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-6">
                                                        <input type="password" name="password" class="form-control form-control-user @error('password') is-invalid @enderror" placeholder="{{ __('Enter Password') }}">
                                                        @error('password')
                                                        <span class="text-danger" role="alert">
                                                            <small>{{ $message }}</small>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="password" name="password_confirmation" class="form-control form-control-user" placeholder="{{ __('Confirm Password') }}">
                                                        @error('confirm')
                                                        <span class="text-danger" role="alert">
                                                            <small>{{ $message }}</small>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="show-image-container">
                                                    <div class="show-image">
                                                        <span id="rmImage" onclick="deleteImage('{{ url('storage/'.$user->image) }}')" class="btn btn-danger btn-sm btn-rm-image hidden">
                                                            <i class="fas fa-trash"></i>
                                                        </span>
                                                        <img class="form-image" id="imageTag" src="{{ url('storage/'.$user->image) }}" alt="Your Logo"/>
                                                    </div>
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
