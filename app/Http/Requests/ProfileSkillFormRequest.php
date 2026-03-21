<?php



namespace App\Http\Requests;



use App\Http\Requests\Request;



class ProfileSkillFormRequest extends Request

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

                    "project_title"  => "required|max:80",

                    "version"   =>"required|max:100",

                    "no_of_projects"   => "required|numeric|min:1|max:100",

                     "last_used_year"  => "required",

                    "job_experience"    => "required"

                        // "job_skill_id" => "required",

                        // "job_experience_id" => "required",

                    ];

                }

            default:break;

        }

    }



    public function messages()

    {

        return [

            'project_title.required' => 'IT Skill is required.',

            'version.required'   => 'Version is required.',

            'last_used_year.required'  => 'Last Used Year is required.',

            'no_of_projects.required'  => 'Number of Projects Completed is required.',

            'job_experience.required' => 'No.of Years of Experience is required.',

            

        ];

    }



}

