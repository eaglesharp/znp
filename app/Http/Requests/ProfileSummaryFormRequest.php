<?php



namespace App\Http\Requests;



use App\Http\Requests\Request;



class ProfileSummaryFormRequest extends Request

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

                        "summary" => "required|max:1000",

                        "totalexp"  => "required",

                        "totalexpmonth"  => "required",

                        "latestcom" => 'required|max:80',

                        "latestdesg" => 'required|max:80',

                        "currentshift" => 'required',

                    ];

                }

            default:break;

        }

    }



    public function messages()

    {

        return [

            'summary.required' => 'Summary is required.',

            'totalexp.required'  => 'Total Experience Year is required',

            'totalexpmonth.required'  =>'Total Experience Month is required',

            'latestcom.required'  => 'Latest Company is required',

            'latestdesg.required'  => 'Latest Designation is required',

            'currentshift.required' => 'Current Shift is required'

        ];

    }



}

