<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OffersRequest extends FormRequest
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
            'hold' => 'required',
            'expoff' => 'required',
            'repoff' => 'required',
            'ctcoff1' => 'required',
         
            'dateoff1' => 'required',
            
            'locoff1' => 'required',
            // 'ctcoff' => 'required',
         
            // 'dateoff' => 'required', 
            
            // 'locoff' => 'required',
           

        ];
    }

    public function messages()
    {
        return [
            'hold.required' => 'Number of Holds required',
            'expoff.required' => 'This Field is required',
            'repoff.required' => 'This field is required',
            'ctcoff1.required' => 'This field is required',
            'dateoff1.required' => 'This field is required.',
            'locoff1.required' => 'This field is required.',
            // 'ctcoff.required' => 'This field is required',
            // 'dateoff.required' => 'This field is required.',
            // 'locoff.required' => 'This field is required.',

        ];
    }
}
