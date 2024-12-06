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
            {{-- <form action="" id="addAddressForm"> --}}
                <div class="modal-body">
                    <div class="row gy-2">
                        <h2 class="h5 text-uppercase m-0">{{ __('Contact') }}</h2>
                        <div class="col-md-12">
                            <input name="email" class="form-control form-control-lg" type="email" id="email"
                            placeholder="{{ __('Email') }}">
                        <small class="error text-danger" id="email_error">@error('email') {{$message}} @enderror</small>
                        </div>

                    </div>
                    <br>
                        <x-store.add-address-form :governorates="$governorates"></x-add-address-form>
                    <br>
                </div>
                <div class="modal-footer">
                    <button id="close-modal" type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        aria-label="Close">{{ __('Close') }}</button>
                    <span onclick="addOrderAddress()" class="btn btn-primary">{{ __('Save') }} </span>
                </div>
            {{-- </form> --}}
        </div>
    </div>
</div>
