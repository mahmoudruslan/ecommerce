@extends('dashboard.layout.master')

@section('title')
    {{ __('Add variants') }}
@endsection
@section('content')
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
        <!-- Main Content -->
        <div id="content">
            <!-- Begin Page Content -->
            <div class="container-fluid">
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
                                                <h1 class="h4 text-gray-900 mb-4">{{ __('Add variant for : '. $product['name_'. app()->getLocale()]) }}</h1>
                                            </div>
                                            <form action="{{ route('admin.products.variants.store', $product) }}" method="POST"
                                                  enctype="multipart/form-data" class="user" id="variant-form">
                                                @csrf
                                                <br>
                                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                <div class="variant-form card mb-3 shadow-sm">
                                                    <div class="card-body">
                                                        <div class="mb-3">
                                                            <h5 class="card-title mb-0">{{ __('New Variant') }}</h5>
                                                        </div>

                                                        <div class="row">
                                                            {{-- السعر --}}
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <input type="text" name="price"
                                                                           value="{{ old('price') }}"
                                                                           class="form-control form-control-user @error('price') is-invalid @enderror"
                                                                           placeholder="{{ __('Enter Price') }}">
                                                                    @error('price')
                                                                    <span class="text-danger" role="alert"><small>{{ $message }}</small></span>
                                                                    @enderror
                                                                </div>
                                                            </div>

                                                            {{-- الكمية --}}
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <input type="text" name="quantity"
                                                                           value="{{ old('quantity') }}"
                                                                           class="form-control form-control-user @error('quantity') is-invalid @enderror"
                                                                           placeholder="{{ __('Enter quantity') }}">
                                                                    @error('quantity')
                                                                    <span class="text-danger" role="alert"><small>{{ $message }}</small></span>
                                                                    @enderror
                                                                </div>
                                                            </div>

                                                            {{-- خصائص المنتج --}}
                                                            @foreach ($attributes as $attribute)
                                                                <div class="form-group col-md-6">
                                                                    <label>{{ $attribute['name_' . app()->getLocale()] }}</label>
                                                                    <select name="attributes[{{ $attribute->id }}]"
                                                                            class="form-control item @error('attributes.' . $attribute->id) is-invalid @enderror">
                                                                        <option selected disabled>{{ __('Select option') }}</option>
                                                                        @foreach ($attribute->values as $value)
                                                                            <option value="{{$value->id}}"
                                                                                {{ old('attributes.' . $attribute->id) == $value->id ? 'selected' : '' }}>
                                                                                {{ $value['value_' . app()->getLocale()] }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                    @error('attributes')
                                                                        <span class="text-danger" role="alert"><small>{{ $message }}</small></span>
                                                                    @enderror
                                                                </div>
                                                            @endforeach
                                                        </div>

                                                        {{-- الصور --}}
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <input multiple type="file" name="images[]" class="file"
                                                                       id="input-id" data-preview-file-type="text">
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
                    required: false,
                    showUpload: false,
                    showRemove:true,
                });
            </script>
    @endpush
