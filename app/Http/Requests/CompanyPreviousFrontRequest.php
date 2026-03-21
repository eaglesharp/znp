<?php



namespace App\Http\Requests;



use Illuminate\Foundation\Http\FormRequest;



class CompanyPreviousFrontRequest extends FormRequest

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

                      

                        "previous_company" => "required|max:80",

                        "previous_desigination" => "required|max:80",

                        "previous_start_date" => "required",

                        "previous_till_date" => "required",

                        "previous_work_type" => "required",

                        "previous_responsibilities" => "required",

                     

                        "previous_project_details" => "required|numeric",

                        "previous_reason" => "required|max:80",

                     //   "previous_work_type" => "required",

                        "previous_ctc_start" => "required|numeric|max:100",

                        "previous_ctc_end" => "required|numeric|max:100",

                        // "is_active" => "required",

                        // "is_featured" => "required",

                        //"company_package_id"=>"required",

                    ];

          

       

    }



    public function messages()

    {

        return [

            

            'previous_company.required'=> 'Previous Company is required',

            'previous_desigination.required'=> 'Previous Designation is required',

            'previous_start_date.required'=> 'Start date is required',

            'previous_till_date.required'=> 'End date is required',

            'previous_responsibilities.required'=> 'Responsibilities is required',

            'previous_work_type.required'=> 'Type of Employment is required',

            'previous_project_details.required'=> 'IT Experience is required',

            'previous_project_details.max'  => 'IT Experience is may not be greater than 100',

            'previous_reason.required'=> 'Reason For job Change is required',
        

            'previous_ctc_start.required'=> 'This field is required',

            'previous_ctc_end.required'=> 'This field is required',

        ];

    }

}

