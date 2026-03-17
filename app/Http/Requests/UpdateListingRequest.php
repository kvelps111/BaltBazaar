<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateListingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'            => 'required|string|max:255',
            'description'      => 'required|string',
            'price'            => 'required|numeric|min:0',
            'school_id'        => 'required|exists:schools,id',
            'category_id'      => 'required|exists:categories,id',
            'photos'           => 'nullable|array|max:10',
            'photos.*'         => 'image|max:8192',
            'remove_photos'    => 'nullable|array',
            'remove_photos.*'  => 'integer|exists:listing_photos,id',
        ];
    }

    public function messages()
    {
        return [
            'school_id.required' => 'Lūdzu izvēlieties skolu',
            'photos.*.image'     => 'Katram failam jābūt attēlam (jpg, png).',
            'photos.*.max'       => 'Fails :attribute ir pārāk liels. Maksimālais izmērs ir 8MB.',
        ];
    }
}
