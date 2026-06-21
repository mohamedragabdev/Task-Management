<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdataTaskRequest extends FormRequest
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
            'user_id'=>'exists:users,id',
            'title'=>'sometimes|string|max:40',
            'description'=>'sometimes|nullable|string',
            "priority"=>'integer|min:1|max:5|sometimes',
            'status'=>'sometimes|in:pending,in progress,completed'
        ];
    }
    public function messages() :array
    {
        return [
            "title.string"=>"العنوان لازم يكون نص",
            "title.max"=>"بص يعمنا العنوان دا اخرو شاكب راكب 40 حرف مش مقالة هي!",
            "description.string"=>"الوصف لازم يكون نص",
            "priority.integer"=>"الأولوية لازم تكون رقم",
            "priority.min"=>"الأولوية لاقلها 1",
            "priority.max"=>"الأولوية  اخرها 5",
            "status.in"=>"الحالة لازم تكون واحدة من: pending, in progress, completed"

        ];
    }
    public function attributes(): array
    {        return [
            'title'=>'الاسم',
            'description'=>'الوصف',
            'priority'=>'الأولوية',
            'status'=>'الحالة'
        ];
    }
}
