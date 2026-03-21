<?php

namespace App\Http\Requests\Front;

use App\Http\Requests\Request;

class JobFrontFormRequest extends Request
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
        switch ($this->method()) {
            case 'PUT':
            case 'POST': {
                    $id = (int) $this->input('id', 0);

                    return [
                        'job_title' => 'required|max:255',
                        'work_mode' => 'required',
                        'job_type' => 'required',
                        'keyskills' => 'required',
                        'min_salary' => 'required|numeric',
                        'max_salary' => 'required|numeric',
                        'experience' => 'required',
                        'no_of_openings' => 'required|numeric',
                        'location' => 'required_if:work_mode,Work From Office,Hybrid,Temp WFH',
                        'job_description' => 'required',
                        'job_overview' => 'required',
                        'roles_responsibility' => 'required',
                    ];
                    
                }
            default:break;
        }
    }

    public function messages()
    {
        return [
            'job_title.required' => 'Please enter the Job title',
            'job_title.max' => 'The Job title should not exceed :max characters',
            'work_mode.required' => 'Please select the Mode of Work',
            'job_type.required' => 'Please select the Job type',
            'keyskills.required' => 'Please enter the Job skills',
            'min_salary.required' => 'Please enter the Minimum salary',
            'min_salary.numeric' => 'The Minimum salary should be a numeric value',
            'max_salary.required' => 'Please enter the Maximum salary',
            'max_salary.numeric' => 'The Maximum salary should be a numeric value',
            'experience.required' => 'Please enter the Experience',
            'experience.numeric' => 'The Experience should be a numeric value',
            'no_of_openings.required' => 'Please enter the Number of openings',
            'no_of_openings.numeric' => 'The Number of openings should be a numeric value',
            'location.required' => 'Please enter the Location',
            'job_description.required' => 'Please enter the Job description',
            'job_overview.required' => 'Please enter the Candidate Eligibility',
            'roles_responsibility.required' => 'Please enter the Roles & Responsibiliteis',
        ];
        
    }

}
