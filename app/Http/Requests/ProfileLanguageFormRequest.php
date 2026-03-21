<?php



namespace App\Http\Requests;



use App\Http\Requests\Request;



class ProfileLanguageFormRequest extends Request

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

                        "language_type" => "required",

                        "language" =>"required|max:80",

                        "language_level" => "required",

                    ];

                }

            default:break;

        }

    }



    public function messages()

    {

        return [

            'language_type.required' => 'Language Type is required.',

            'language.required' => 'Language is required.',

            'language_level.required' => 'Language Level is required.',

        ];

    }



}

