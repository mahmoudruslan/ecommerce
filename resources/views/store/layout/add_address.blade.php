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
            <form action="" id="addAddressForm">
                <div class="modal-body">
                    {{-- <div class="row gy-4"> --}}
                        <x-store.add-address-form :governorates="$governorates"></x-add-address-form>


                        {{-- <div class="col-lg-6">
                            <input name="user_id" type="hidden" value="{{ auth()->id() }}">
                            <input name="first_name" class="form-control form-control-lg" type="text" id="first_name"
                                placeholder="{{ __('Enter your first name') }}">
                                <small class="error text-danger" id="first_name_error"></small>
                        </div>
                        <div class="col-lg-6">
                            <input name="last_name" class="form-control form-control-lg" type="text" id="last_name"
                                placeholder="{{ __('Enter your last name') }}">
                                <small class="error text-danger" id="last_name_error"></small>
                        </div>
                        <div class="col-lg-12">
                            <input class="form-control form-control-lg" type="text" name="address" id="address"
                                placeholder="{{ __('Address') }}">
                                <small class="error text-danger" id="address_error"></small>

                        </div>
                        <div class="col-lg-6">
                            <input name="mobile" class="form-control form-control-lg" type="text" id="mobile"
                                placeholder="{{ __('Phone number') }}">
                                <small class="error text-danger" id="mobile_error"></small>

                        </div>
                        <div class="col-lg-6">
                            <input name="zip_code" class="form-control form-control-lg" type="text" id="zip_code"
                                placeholder="{{ __('Zip code') . __('Optional') }}">
                                <small class="error text-danger" id="zip_code_error"></small>

                        </div>
                        @livewire('cascading-dropdown', ['governorates' => $governorates, null]) --}}
                    {{-- </div> --}}
                    <br>
                </div>
                <div class="modal-footer">
                    <button id="close-modal" type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        aria-label="Close">{{ __('Close') }}</button>
                    <span onclick="addAddress()" class="btn btn-primary">{{ __('Save') }} </span>
                </div>
            </form>
        </div>
    </div>
</div>
