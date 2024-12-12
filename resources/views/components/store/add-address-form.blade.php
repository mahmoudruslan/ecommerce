<div class="row gy-2">
    <h2 class="h5 text-uppercase m-0">{{ __('Delivery') }}</h2>
    <div class="col-lg-6">
        <input name="user_id" type="hidden" value="{{ auth()->id() }}">
        <input id="email" name="email" type="hidden" value="{{ auth()->user()->email }}">
        <small class="d-none" id="email_error"></small>
        <input name="first_name" class="form-control form-control-lg" type="text" id="first_name"
            placeholder="{{ __('Enter your first name') }}">
        <small class="error text-danger" id="first_name_error">@error('first_name') {{$message}} @enderror</small>
    </div>
    <div class="col-lg-6">
        <input name="last_name" class="form-control form-control-lg" type="text" id="last_name"
            placeholder="{{ __('Enter your last name') }}">
        <small class="error text-danger" id="last_name_error">@error('last_name') {{$message}} @enderror</small>
    </div>
    <div class="col-lg-12">
        <input class="form-control form-control-lg" type="text" name="address" id="address"
            placeholder="{{ __('Address') }}">
        <small class="error text-danger" id="address_error">@error('address') {{$message}} @enderror</small>

    </div>
    <div class="col-lg-6">
        <input name="mobile" class="form-control form-control-lg" type="number" id="mobile"
            placeholder="{{ __('Phone number') }}">
        <small class="error text-danger" id="mobile_error">@error('mobile') {{$message}} @enderror</small>

    </div>
    <div class="col-lg-6">
        <input name="zip_code" class="form-control form-control-lg" type="number" id="zip_code"
            placeholder="{{ __('Zip code') . __('Optional') }}">
        <small class="error text-danger" id="zip_code_error">@error('zip_code') {{$message}} @enderror</small>

    </div>
    @livewire('cascading-dropdown', ['governorates' => $governorates, null])
</div>
