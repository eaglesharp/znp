<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileInterviewRequest extends FormRequest
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
            'video_date_from'  => 'required',
            'video_date_to' => 'required',
            'video_time' => 'required',
        ];
    }
    public function messages()
    {
    
    return [
    
        'video_date_from.required' => " video date from required",
        'video_date_to.required' => "video date to required",
        'video_time.required' => "video time required",
    
    ];
    
    }
}
