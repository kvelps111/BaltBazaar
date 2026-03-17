<?php

namespace App\Http\Requests;

use App\Models\ListingPhoto;
use Illuminate\Foundation\Http\FormRequest;

class UpdateListingRequest extends FormRequest
{
    public function authorize(): bool
    {
        $listing = $this->route('listing');

        return $listing && $this->user()->can('update', $listing);
    }

    public function rules(): array
    {
        return [
            'title'            => 'required|string|max:255',
            'description'      => 'required|string',
            'price'            => 'required|numeric|min:0',
            'school_id'        => 'required|exists:schools,id',
            'category_id'      => 'required|exists:categories,id',
            'photos'           => 'nullable|array',
            'photos.*'         => 'image|max:8192',
            'remove_photos'    => 'nullable|array',
            'remove_photos.*'  => 'integer|exists:listing_photos,id',
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $listing     = $this->route('listing');
            $existing    = ListingPhoto::where('listing_id', $listing->id)->count();
            $removing    = count($this->input('remove_photos', []));
            $adding      = $this->hasFile('photos') ? count($this->file('photos')) : 0;
            $total       = $existing - $removing + $adding;

            if ($total > 10) {
                $validator->errors()->add('photos', "Kopējais attēlu skaits nedrīkst pārsniegt 10 (pašlaik: {$total}).");
            }
        });
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
