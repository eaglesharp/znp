<?php



namespace App\Http\Requests;



use Illuminate\Foundation\Http\FormRequest;



class CompensationRequest extends FormRequest

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

            'expect_ctc_lakhs'  =>'required|numeric|integer|max:100',

            'expect_ctc_thousand'  => 'required|numeric|integer|max:99',

            // 'expect_ctc_lakhs1'  => 'required|numeric|integer|min:1|max:100',

            // 'expect_ctc_thousand1'   => 'required|numeric|integer|min:1|max:99',

            // 'expect_ctc_lakhs2'  => 'required|numeric|integer|min:1|max:100',

            // 'expect_ctc_thousand2'  => 'required|numeric|integer|min:1|max:99',

            'expect_ctc_lakhs3'   => 'required|numeric|integer|max:100',

            'expect_ctc_thousand3' => 'required|numeric|integer|max:99'

         ];

    }

    public function messages()

    {

    

    return [

    

        'expect_ctc_lakhs.required'=>'This Field is required',

            'expect_ctc_thousand.required'=>'This Field is required',

            // 'expect_ctc_lakhs1.required'=>'This Field is required',

            // 'expect_ctc_thousand1.required'=>'This Field is required',

            // 'expect_ctc_lakhs2.required'=>'This Field is required',

            // 'expect_ctc_thousand2.required'=>'This Field is required',

            'expect_ctc_lakhs3.required'=>'This Field is required',

            'expect_ctc_thousand3.required'=>'This Field is required'

    

    

    ];

    

    }

}

