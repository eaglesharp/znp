<?php



namespace App\Http\Requests;



use App\Http\Requests\Request;



class ProfileEducationFormRequest extends Request

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

                        // "degree_level_id" => "required",

                        //"degree_type_id" => "required",

                        "degree_title" => "required",

                        "year_of_passing1" => "required",

                        'course'  => 'required_if:degree_title,2,3,4',

                        'specilation'  => 'required_if:degree_title,2,3,4',

                        'organization'  => 'required_if:degree_title,2,3,4',

                        "degree_result" => "required",

                        "grade_achieved1" => 'required_if:degree_result,1',

                        "grade_achieved2" => 'required_if:degree_result,2',

                        "grade_achieved3" => 'required_if:degree_result,3',

                        "grade_achieved4" => 'required_if:degree_result,4',

                       

                    ];

                }

            default:break;

        }

    }



    public function messages()

    {

        return [

            'degree_level_id.required' => 'Please select degree level.',

            'degree_type_id.required' => 'Please select degree type.',

            'degree_title.required' => 'Education is required.',

            'year_of_passing1.required'  => 'Year of Passing is required',

            'major_subjects.required' => 'Major Subject is required.',

            'country_id.required' => 'Please select country.',

            'state_id.required' => 'Please select state.',

            'city_id.required' => 'Please select city.',

            'course.required'  =>  'Course is required',

            'institution.required' => 'Please enter institution.',

            'organization.required'  => 'University / College is required',

            'specilation.required'    => 'Specialization is required',

            'date_completion.required' => 'Please set completion date.',

            'degree_result.required' => 'Grade is required.',

            'result_type_id.required' => 'Please select result type.',

            'grade_achieved1.required'  => 'Grade Achieved is required',

            'grade_achieved2.required'  => 'Grade Achieved is required',

            'grade_achieved3.required'  => 'Grade Achieved is required',

            'grade_achieved4.required'  => 'Grade Achieved is required'



        ];

    }



}

