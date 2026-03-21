<?php



namespace App\Http\Requests;



use App\Http\Requests\Request;



class ProfileProjectFormRequest extends Request

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

                        "name" => "required|max:50",

                        "role_in_project" =>"required|max:50",

                         "client" => "required|max:50",

                        "duration" => "required",

                         "project_type" => "required",

                        "tech_used" => "required|max:255",

                        

                        //"image" => "required",

                        //"url" => "required",

                         "domain" => "required|max:255",

                        // "date_end" => "required_if:is_on_going,0",

                        // "is_on_going" => "required",

                        "description" => "required",

                    ];

                }

            default:break;

        }

    }



    public function messages()

    {

        return [

            'name.required' => 'IT Project Name is required.',

            'role_in_project.required' => 'Role in the project is required',

             'client.required' => 'Client is required.',

            'project_type.required' => 'Project Type is required.',

            'duration.required' => 'Duration of the Project is required.',

            'tech_used.required' => 'Technologies Used in the Project is required.',

             'domain.required' => 'Domain is required',

            'description.required' => 'Project Description is required.',

        ];

    }



}

