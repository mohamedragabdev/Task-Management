<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
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
            'title'=>'required|string|max:40',
            'description'=>'nullable|string',
            'priority'=>'required|in:low,medium,high',
            'status'=>'required|in:pending,in progress,completed'
        ];
    }
    public function messages() :array
    {
        return [
            "title.required"=>"العنوان مهم  ",
            "title.string"=>"العنوان لازم يكون نص",
            "title.max"=>"بص يعمنا العنوان دا اخرو شاكب راكب 40 حرف مش مقالة هي!",
            "description.string"=>"الوصف لازم يكون نص",
            "priority.required"=>"الأولوية مهمة يا معلم",
            "status.required"=>"الحالة مهمة يا معلم",
            "status.in"=>"الحالة لازم تكون واحدة من: pending, in progress, completed"

        ];
    }
    public function attributes(): array
    {
        return [
            'title'=>'الاسم',
            'description'=>'الوصف',
            'priority'=>'الأولوية',
            'status'=>'الحالة'
        ];
    }
}
