@extends('dashboard.layout.master')

@section('title')
    {{ __('Add variants') }}
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

                                                <div id="variants-wrapper">
                                                    <div class="variant-form card mb-3 shadow-sm">
                                                        <div class="card-body">
                                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                                <h5 class="card-title mb-0">Variant 1</h5>
                                                                <button type="button" class="btn btn-sm btn-danger remove-variant d-none">Remove</button>
                                                            </div>

                                                            {{-- Loop through attributes --}}
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <input type="text" name="variants[0][variant_price]"
                                                                               value="{{ old('variants.0.variant_price') }}"
                                                                               class="item form-control form-control-user @error('variants.0.variant_price') is-invalid @enderror"
                                                                               placeholder=" {{ __('Enter Price') }}">
                                                                        @error('variants.0.variant_price')
                                                                        <span class="text-danger" role="alert">
                                                                            <small>{{ $message }}</small>
                                                                        </span>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <input type="text" name="variants[0][variant_quantity]"
                                                                               value="{{ old('variants.0.variant_quantity') }}"
                                                                               class="item form-control form-control-user
                                                                               @error('variants.0.variant_quantity') is-invalid @enderror"
                                                                               placeholder=" {{ __('Enter quantity') }}">
                                                                        @error('variants.0.variant_quantity')
                                                                        <span class="text-danger" role="alert">
                                                                        <small>{{ $message }}</small>
                                                                    </span>
                                                                        @enderror
                                                                    </div>
                                                                </div>

                                                                @foreach ($attributes as $attribute)
                                                                    <div class="form-group col-md-6">
                                                                        <label>{{ $attribute['name_' . app()->getLocale()] }}</label>
                                                                        <select name="variants[0][attributes][{{ $attribute->id }}]"
                                                                                class="form-control item @error('variants.0.attributes.' . $attribute->id) is-invalid @enderror">
                                                                            <option selected>{{ __('Select option') }}</option>
                                                                            @foreach ($attribute->values as $value)
                                                                                <option value="{{ $value->id }}">{{ $value['value_' . app()->getLocale()] }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                        @error('variants.0.attributes.' . $attribute->id)
                                                                        <span class="text-danger" role="alert">
                                                                            <small>{{ $message }}</small>
                                                                        </span>
                                                                        @enderror
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <input multiple type="file" name="images[]" class="file"
                                                                           id="input-id" data-preview-file-type="text">
                                                                    <br>
                                                                    @error('images')
                                                                    <span class="text-danger" role="alert">
                                                                    <small>{{ $message }}</small>
                                                                </span>
                                                                    @enderror
                                                                    @error('images.0')
                                                                    <span class="text-danger" role="alert">
                                                                    <small>{{ $message }}</small>
                                                                </span>
                                                                    @enderror
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <button type="button" id="add-variant" class="btn btn-primary">
                                                    ➕ Add Variant
                                                </button>

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
                    required: true,
                    showUpload: false,
                    showRemove: false,
                });
            </script>
            <script>
                let variantIndex = 1;
                const wrapper = document.getElementById('variants-wrapper');
                const container = document.getElementById('variants-container');
                const addBtn = document.getElementById('add-variant');

                addBtn.addEventListener('click', function () {
                    console.log('testtest');
                    const firstVariant = wrapper.querySelector('.variant-form');
                    const clone = firstVariant.cloneNode(true);

                    // Update title
                    clone.querySelector('.card-title').textContent = `Variant ${variantIndex + 1}`;

                    // Show remove button
                    clone.querySelector('.remove-variant').classList.remove('d-none');

                    // Update select names
                    const selects = clone.querySelectorAll('.item');
                    selects.forEach(select => {
                        const name = select.getAttribute('name');
                        const updatedName = name.replace(/\[\d+\]/, `[${variantIndex}]`);
                        select.setAttribute('name', updatedName);
                        select.selectedIndex = 0;
                    });

                    wrapper.appendChild(clone);
                    variantIndex++;
                });

                wrapper.addEventListener('click', function (e) {
                    if (e.target.classList.contains('remove-variant')) {
                        e.target.closest('.variant-form').remove();
                    }
                });
            </script>

    @endpush
