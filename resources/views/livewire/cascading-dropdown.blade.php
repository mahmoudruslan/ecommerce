<div>
    <div class="form-group row">
        @php
        $edit_mode = false;
            if(isset($user_address)) $edit_mode = true
        @endphp
        <div class="col-md-6">
            <select name="governorate_id" wire:model="governorate_id" id="governorate_id"  class="form-control select-radius
            @error('governorate_id') is-invalid @enderror">
                <option value="{{$edit_mode ? $user_address->governorate->id : ''}}" >{{ $edit_mode ? $user_address->governorate->name_ar : __("Choose governorate") }}</option>
                @foreach($governorates as $item)
                    <option value="{{$item->id}}" >{{$item->name_ar}}</option>
                @endforeach
            </select>
            <span id="governorate_id_error" class="text-danger" role="alert">
            @error('governorate_id')
                <span class="text-danger" role="alert">
                    <small>{{ $message }}</small>
                </span>
            @enderror
        </div>
        <div class="col-md-6">
            <select name="city_id" wire:model="city_id" id="city_id" class="form-control select-radius
            @error('city_id') is-invalid @enderror">
                <option  value="{{$edit_mode && count($cities) < 1 ? $user_address->city->id : ''}}" >{{ $edit_mode && count($cities) < 1 ? $user_address->city->name_ar : __("Choose city") }}</option>
                @foreach($cities as $item)
                    <option value="{{$item->id}}" >{{$item->name_ar}}</option>
                @endforeach
            </select>
            <span id="city_id_error" class="text-danger" role="alert">
            </span>
            @error('city_id')
                <span class="text-danger" role="alert">
                    <small>{{ $message }}</small>
                </span>
            @enderror
        </div>
    </div>
</div>
