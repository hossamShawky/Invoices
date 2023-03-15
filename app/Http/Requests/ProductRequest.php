<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'product_name'=>"required|string|unique:products|max:255",
            'description'=>'required|string|min:5', 
            'section_id'=>"required|integer|exists:sections,id"
         ];
    }

    public function messages()
    {
        return [
            'product_name.required'=>'يجب إدخال اسم المنتج',
            'product_name.unique'=>' المنتج موجود بالفعل',
            'description.string'=>'أسم المنتج يجب أن يكون 5 حروف علي الأقل', 
            'description.required'=>' يجب إدخال وصف المنتج  ',
            "section_id.required"=>"يجب تحديد اسم القسم",
            "section_id.exists"=>"هذا القسم غير موجود         ",
            
        ];
    }
}
