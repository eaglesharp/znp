<?php



namespace App\Http\Requests;



use Illuminate\Foundation\Http\FormRequest;



class CertificateFormRequest extends Request

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

                    $certificate = ($id > 0) ? '' : 'required|';

                    return [

                        "certificate_name" => "required|max:80",

                        "certificate_agency" => "required|max:80",

                        "year_of_passing"  => "required",

                        "month_of_passing"  => "required",

                        "duration"   => "required"

                        

                    ];

                }

            default:break;

        }

    }



    public function messages()

    {

        return [

            'certificate_name.required' => 'Certification Name is required.',

            'certificate_agency.required' => 'Certification Agency / School is required',

            "year_of_passing.required" => 'Year of Certification is required',

            "month_of_passing.required" => 'Month of Certification is required',

            "duration.required" => 'Duration is required',

           

        ];

    }

}







