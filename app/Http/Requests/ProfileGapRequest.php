<?php



namespace App\Http\Requests;



use Illuminate\Foundation\Http\FormRequest;



class ProfileGapRequest extends FormRequest

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

//        'gap_from_year'  => 'required',

//        'gap_from_month'  => 'required',

//        'gap_to_year'   => 'required',

//        'gap_to_month'   => 'required',

        'reason'   => 'required|max:256'

         

        ];

    }

    

    public function messages()

    {

        return [

        

//        'gap_from_year.required'  =>'Please enter the Gap From Year',

//        'gap_from_month.required'  =>  'Please enter the Gap From Month',

//        'gap_to_year.required'  =>  'Please enter the Gap To year',

//        'gap_to_month.required'  => 'Please enter the Gap to Month',

        'reason.required'   => 'Please enter the Reason'

        

        

        

        ];

    }

    

    

    

    

}

