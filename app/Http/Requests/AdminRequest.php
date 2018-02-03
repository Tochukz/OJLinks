<?php

namespace Ojlinks\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
           'title'=>'required|max:60',
           'author'=>'required|max:80',
           'edition'=>'nullable|max:20',
           'pages'=>'nullable',
           'category'=>'required',
           'subcategory'=>'nullable',
           'language'=>'nullable',
           'details'=>'nullable',
           'price'=>'required|between:0, 99999.9'
        ];
    }
}
