<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
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
                        "current_company" => "required",
                        "current_desigination" => "required",
                        "current_start_date" => "required",
                        "current_work_type" => "required",
                        "current_project_details" => "required",
                        "current_reason" => "required",
                        "current_responsibilities" => "required",
                        "current_ctc_start" => "required",
                        "current_ctc_end" => "required",
                        "previous_company" => "required",
                        "previous_desigination" => "required",
                        "previous_start_date" => "required",
                        "previous_till_date" => "required",
                        "previous_responsibilities" => "required",
                        "previous_work_type" => "required",
                        "previous_project_details" => "required",
                        "previous_reason" => "required",
                      
                        "previous_ctc_start" => "required",
                        "previous_ctc_end" => "required",
                        // "is_active" => "required",
                        // "is_featured" => "required",
                        //"company_package_id"=>"required",
                    ];
          
       
    }

    public function messages()
    {
        return [
            'current_company.required'=> 'Current Company is required',
            'current_desigination.required'=> ' designation is required',
            'current_start_date.required'=> 'Start date is required',
            'current_work_type.required'=> 'Work Type is required',
            'current_project_details.required'=> 'Current Project details is required',
            'current_reason.required'=> 'Current reason is required',
            'current_responsibilities.required'=> 'responsibilities is required',
            'current_ctc_start.required'=> 'This field is required',
            'current_ctc_end.required'=> 'This field is required',
            'previous_company.required'=> 'Previous Company is required',
            'previous_desigination.required'=> 'designation is required',
            'previous_start_date.required'=> 'Start date is required',
            'previous_till_date.required'=> 'This field is required',
            'previous_responsibilities.required'=> 'This field is required',
            'previous_work_type.required'=> 'Work Type is required',
            'previous_project_details.required'=> 'This field is required',
            'previous_reason.required'=> 'This field is required',
        
            'previous_ctc_start.required'=> 'This field is required',
            'previous_ctc_end.required'=> 'This field is required',
        ];
    }

}
