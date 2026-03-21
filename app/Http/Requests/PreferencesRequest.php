<?php



namespace App\Http\Requests;



use Illuminate\Foundation\Http\FormRequest;



class PreferencesRequest extends FormRequest

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

            'shifts'  => 'required',

            'work_type' => 'required',

            'contract_type' => 'required',

            'work_option'  => 'required',

            'expecting_opportunities' => 'required|max:50',

            'expecting_payment' => 'required|numeric|max:10000000',

        ];

    }

    public function messages()

    {

    

    return [

    

        'shifts.required' => " Preferred Work Shift is required",

        'work_type.required' => "Preferred Work Type is required",

        'contract_type.required' => "work on contract is required",

        

        'work_option.required'=>"Work Flexibility is required",

        'expecting_opportunities.required'=>"Expecting job opportunities is required",

        'expecting_payment.required'=>"Expected Pay/Month is required",

    

    ];

    

    }

}

