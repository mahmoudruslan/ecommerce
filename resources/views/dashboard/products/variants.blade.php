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
                               value="{{ old('variant_price') }}"
                               class="item form-control form-control-user @error('variant_price') is-invalid @enderror"
                               placeholder=" {{ __('Enter Price') }}">
                        @error('variant_price')
                        <span class="text-danger" role="alert">
                            <small>{{ $message }}</small>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <input type="text" name="variants[0][quantity]"
                               value="{{ old('quantity') }}"
                               class="item form-control form-control-user @error('quantity') is-invalid @enderror"
                               placeholder=" {{ __('Enter quantity') }}">
                        @error('quantity')
                        <span class="text-danger" role="alert">
                            <small>{{ $message }}</small>
                        </span>
                        @enderror
                    </div>
                </div>
                @foreach ($attributes as $attribute)
                    <div class="form-group col-md-6">
                        <label>{{ $attribute['name_' . app()->getLocale()] }}</label>
                        <select name="variants[0][attributes][{{ $attribute->id }}]" class="form-control item">
                            @foreach ($attribute->values as $value)
                                <option value="{{ $value->id }}">{{ $value['value_' . app()->getLocale()] }}</option>
                            @endforeach
                        </select>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<button type="button" id="add-variant" class="btn btn-primary">
    ➕ Add Variant
</button>
