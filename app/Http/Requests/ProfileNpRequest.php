<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileNpRequest extends FormRequest
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
            'nop_days' => 'required',
            //'middle_name' => 'required',
            'buyable_nop' => 'required',
            'last_working_day' => 'required',
         
            //'nop_status' => 'required',

        ];
    }

    public function messages()
    {
        return [
            'nop_days.required' => 'Notice Period is required',
            //'middle_name.required' => 'Middle Name is required',
            'buyable_nop.required' => 'Buyable Notice Period is required',
            'last_working_day.required' => 'Last working day is required',
           // 'nop_status.required' => 'Nop Status required.',

        ];
    }

}
