<?php



namespace App\Http\Requests;



use App\Http\Requests\Request;



class MajorSubjectFormRequest extends Request

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

                 

                    return [

                    "keyskills"  => "required|max:180",

                   

                    ];

                }

            default:break;

        }

    }



    public function messages()

    {

        return [

            'keyskills.required' => 'Please enter key skills',

           

        ];

    }



}

