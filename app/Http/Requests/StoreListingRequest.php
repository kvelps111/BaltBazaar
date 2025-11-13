<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreListingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'price'       => 'required|numeric|min:0',
            'school_id'   => 'required|exists:schools,id',
            'category_id' => 'required|exists:categories,id',
            'photos'      => 'required|array|max:10',
            'photos.*'    => 'image|max:8192',
        ];
    }


    public function messages()
    {
        return [
            'school_id.required' => 'Lūdzu izvēlieties skolu',
            'photos.required'   => 'Lūdzu pievienojiet vismaz vienu attēlu.',
            'photos.*.image'    => 'Katram failam jābūt attēlam (jpg, png).',
            'photos.*.max'      => 'Fails :attribute ir pārāk liels. Maksimālais izmērs ir 8MB.'
            
        ];
    }
}
