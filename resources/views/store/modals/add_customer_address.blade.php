<div class="modal fade" id="add-address" tabindex="-1" role="dialog" aria-hidden="true">
    @php
        $lang = app()->getLocale();
    @endphp
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('Add address') }}</h5>
                <button class="btn-close p-4 position-absolute top-0 end-0 z-index-20 shadow-0" type="button"
                    data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form name="add-form" action="{{route('customer.profile.address.store')}}" id="addCustomerAddressForm" method="POST">
                @csrf
                @method('put')
            <div class="modal-body">
                <div style="text-align: justify;" class="row gy-2 ">
                    <div class="col-lg-6">
                        <input value="{{auth()->id()}}" name="user_id"  type="hidden">
                        <input value="{{$address->first_name ?? old('first_name')}}" name="first_name" class="form-control form-control-lg" type="text" id="first_name"
                            placeholder="{{ __('Enter your first name') }}">
                        <small class="error text-danger" id="first_name_error">
                            @error('first_name')
                                {{ $message }}
                            @enderror
                        </small>
                    </div>
                    <div class="col-lg-6">
                        <input value="{{$address->last_name ?? old('last_name')}}" name="last_name" class="form-control form-control-lg" type="text" id="last_name"
                            placeholder="{{ __('Enter your last name') }}">
                        <small class="error text-danger" id="last_name_error">
                            @error('last_name')
                                {{ $message }}
                            @enderror
                        </small>
                    </div>
                    <div class="col-lg-6">
                        <input value="{{$address->email ?? old('email')}}" name="email" class="form-control form-control-lg" type="email" id="email"
                            placeholder="{{ __('Email') }}">
                        <small class="error text-danger" id="email_error">
                            @error('email')
                                {{ $message }}
                            @enderror
                        </small>
                    </div>
                    <div class="col-lg-6">
                        <input value="{{$address->mobile ?? old('mobile')}}" name="mobile" class="form-control form-control-lg" type="number" id="mobile"
                            placeholder="{{ __('Phone number') }}">
                        <small class="error text-danger" id="mobile_error">
                            @error('mobile')
                                {{ $message }}
                            @enderror
                        </small>
                    </div>
                    <div class="col-lg-12">
                        <input class="form-control form-control-lg" type="text" value="{{$address->address ?? old('address')}}" name="address" id="address"
                            placeholder="{{ __('Address') }}">
                        <small class="error text-danger" id="address_error">
                            @error('address')
                                {{ $message }}
                            @enderror
                        </small>

                    </div>
                    <div class="col-lg-12">
                        <input class="form-control form-control-lg" type="text" value="{{$address->address2 ?? old('address2')}}" name="address2" id="address2"
                            placeholder="{{ __('Address2') }}">
                        <small class="error text-danger" id="address2_error">
                            @error('address2')
                                {{ $message }}
                            @enderror
                        </small>
                    </div>
                    @livewire('cascading-dropdown', ['governorates' => $governorates, $address ?? null])
                    <div class="col-lg-6">
                        <input value="{{$address->zip_code ?? old('zip_code')}}" name="zip_code" class="form-control form-control-lg" type="number" id="zip_code"
                            placeholder="{{ __('Zip code') . __('Optional') }}">
                        <small class="error text-danger" id="zip_code_error">
                            @error('zip_code')
                                {{ $message }}
                            @enderror
                        </small>
                    </div>
                    <div class="col-lg-6">
                        <div class="mt-2">
                            <input class="form-check-input" name="default_address" type="checkbox" value="1"
                            @if(isset($address) && $address->default_address == 1) 'checked' @endif>
                            <label class="form-check-lable" for="flexCheckDefault">
                                {{__('Default')}}
                            </label>
                        </div>
                    </div>
                </div>

                <br>
            </div>
            <div class="modal-footer">
                <button id="close-modal" type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                    aria-label="Close">{{ __('Close') }}</button>
                <span onclick="submitAddAddressForm()" class="btn btn-primary">{{ __('Save') }} </span>
            </div>
            </form>
        </div>
    </div>
</div>
