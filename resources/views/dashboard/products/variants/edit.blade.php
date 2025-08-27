@extends('dashboard.layout.master')

@section('title')
    {{ __('Edit variant') }}
@endsection
@section('style')
    <style>
        .variant-form {
            transition: all 0.3s ease-in-out;
        }

        .remove-variant:hover {
            background-color: #c53030;
        }

    </style>
@endsection
@section('content')
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
        <!-- Main Content -->
        <div id="content">
            <!-- Begin Page Content -->
            <div class="container-fluid">
                @php
                    //show all errors
                    if ($errors->any()) {
                        foreach ($errors->all() as $error) {
                            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    ' . $error . '
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>';
                        }
                    }
                @endphp
                <!-- Page Heading -->
                <h1 class="h3 mb-2 text-gray-800">{{ __('Add variants') }}</h1>
                <div class="row justify-content-center">
                    <div class="col-xl-10 col-lg-12 col-md-9">
                        <div class="card o-hidden border-0 shadow-lg my-4">
                            <div class="card-body p-0">
                                <!-- Nested Row within Card Body -->
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="p-5">
                                            <div class="text-center">
                                                <h1 class="h4 text-gray-900 mb-4">{{ __('Edit variant for : '. $product['name_'. app()->getLocale()]) }}</h1>
                                            </div>
                                            <form action="{{ route('admin.products.variants.update', [$product, $variant]) }}" method="POST"
                                                  enctype="multipart/form-data" class="user" id="variant-form">
                                                @csrf
                                                @method('patch')
                                                <br>

                                                <div class="variant-form card mb-3 shadow-sm">
                                                    <div class="card-body">
                                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                                            <h5 class="card-title mb-0">{{ __('Edit Variant') }}</h5>
                                                        </div>

                                                        <div class="row">
                                                            {{-- price --}}
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <input type="text" name="price"
                                                                           value="{{ old('price', $variant->price ?? '') }}"
                                                                           class="form-control form-control-user @error('price') is-invalid @enderror"
                                                                           placeholder="{{ __('Enter Price') }}">
                                                                    @error('price')
                                                                        <span class="text-danger" role="alert"><small>{{ $message }}</small></span>
                                                                    @enderror
                                                                </div>
                                                            </div>

                                                            {{-- quantity --}}
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <input type="text" name="quantity"
                                                                           value="{{ old('quantity', $variant->quantity ?? '') }}"
                                                                           class="form-control form-control-user @error('quantity') is-invalid @enderror"
                                                                           placeholder="{{ __('Enter quantity') }}">
                                                                    @error('quantity')
                                                                    <span class="text-danger" role="alert"><small>{{ $message }}</small></span>
                                                                    @enderror
                                                                </div>
                                                            </div>

                                                            @foreach ($attributes as $attribute)
                                                                <div class="form-group col-md-6">
                                                                    <label>{{ $attribute['name_' . app()->getLocale()] }}</label>
                                                                    <select name="attributes[{{ $attribute->id }}]"
                                                                            class="form-control item @error('attributes.' . $attribute->id) is-invalid @enderror">
                                                                        <option selected disabled>{{ __('Select option') }}</option>
                                                                        @foreach ($attribute->values as $value)
                                                                            <option value="{{ $value->id }}"
                                                                                {{ ($selectedValues[$attribute->id] ?? null) == $value->id ? 'selected' : '' }}>
                                                                                {{ $value['value_' . app()->getLocale()] }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                    @error('attributes.' . $attribute->id)
                                                                        <span class="text-danger" role="alert"><small>{{ $message }}</small></span>
                                                                    @enderror
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                        {{-- الصور --}}
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <input multiple type="file" name="images[]" class="file" id="input-id" data-preview-file-type="text">
                                                                <br>
                                                                @error('images')
                                                                    <span class="text-danger" role="alert"><small>{{ $message }}</small></span>
                                                                @enderror
                                                                @error('images.0')
                                                                    <span class="text-danger" role="alert"><small>{{ $message }}</small></span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

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
        @push('script')
            <script>
                $("#input-id").fileinput({
                    showUpload: false,
                    showRemove: false,
                    // required: true,
                    'initialPreview': [
                        @if ($variant->media()->count() > 0)
                            @foreach ($variant->media as $media)
                            "{{ asset('storage/' . $media->file_name) }}",
                        @endforeach
                        @endif

                    ],
                    'initialPreviewFileType': 'image',
                    'initialPreviewAsData': true,
                    'overviewInitial': false,
                    'initialPreviewConfig': [
                            @if ($variant->media()->count() > 0)
                                @foreach ($variant->media as $media)
                                    {
                                        size: '1111',
                                        width: '120px',
                                        url: "{{ route('admin.products.variants.remove-media', [$variant, $media, '_token' => csrf_token()]) }}"
                                    },
                                @endforeach
                            @endif
                    ],
                    allowedFileExtensions: ["jpg", "png", "gif", "jpeg"]
                });
            </script>
    @endpush
