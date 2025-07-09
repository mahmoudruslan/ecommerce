<?php

namespace App\Http\Requests\Variants;

use App\Models\Product;
use App\Models\Variant;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class RemoveImageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * @return bool
     */
    public function authorize()
    {
        userAbility(['delete-variants']);
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'media_id' => 'required|string',
            'variant_id' => 'required|string'
        ];
    }

    public function passedValidation()
    {
        $variant = Variant::find($this->variant_id);
        $mediaCount = $variant->media()->count();
        $media = $variant?->media()->where('id', $this->media_id)->first();

        if (!$media) {
            throw ValidationException::withMessages([
                'media' => ['Media not found for this variant.']
            ]);
        }

        if ($mediaCount <= 1) {
            throw ValidationException::withMessages([
                'media' => ['Cannot delete the last image of this variant.']
            ]);
        }
        $this->merge([
            'media' => $media
        ]);
    }

}
