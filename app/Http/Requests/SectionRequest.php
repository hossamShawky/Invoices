<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SectionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
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
            'section_name'=>"required|string|unique:sections|max:255",
            'description'=>'required|string|min:5', 
         ];
    }

    public function messages()
    {
        return [
            'section_name.required'=>'يجب إدخال اسم القسم',
            'section_name.unique'=>' القسم موجود بالفعل',
            'description.string'=>'أسم  يجب أن يكون 5 حروف علي الأقل', 
            'description.required'=>' يجب إدخال وصف القسم  ',
        ];
    }
}
