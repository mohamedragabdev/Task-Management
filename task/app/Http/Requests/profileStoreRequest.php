<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class profileStoreRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "phone"=>"string|max:16|nullable |required",
            "address"=>"string|nullable ",
            "dob"=>"date|nullable ",
            'bio'=>"string|nullable ",
            'img_profile'=>"image|required |mimes:png,jpg,gif"
        ];
    }

}
