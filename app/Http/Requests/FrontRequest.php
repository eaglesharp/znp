<?php



namespace App\Http\Requests;



use Illuminate\Foundation\Http\FormRequest;



class FrontRequest extends FormRequest

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

        $id = (int) $this->input('id', 0);

        $password = 'required|min:8';

        $id_str = '';

        if ($id > 0) {

            $id_str = ',' . $id;

            $password = '';

        }

       

        return [

            'first_name' => 'required|regex:/^[a-zA-Z]+$/u|max:80', 

           // 'email' => 'required|unique:users|email',

          // 'middle_name'  => 'alpha |max:80',

          //  'last_name' => 'alpha |max:80',     

           // 'password' => $password,

             'date_of_birth' => 'required',

             'gender_id' => 'required',

             'marital_status_id' => 'required',

             'physically_challenged'  => 'required',

             'current_city' =>'required|max:80',

             //'prefered_city'  => 'required|max:80',

             'current_location'  => 'required|max:80',

             'prefered_location'   => 'required|max:80',  

            //  'resume'=>'required|mimes:pdf,docx|max:2048' ,

            // 'phone' => 'required',

            

             'industry' => 'required',

             'street_address' => 'required|max:200',

           

        ];

    }



    public function messages()

    {

        return [

            'first_name.required' => 'First Name is required',

            // 'email.required' => 'Email is required',

            // 'email.email' => 'The email must be a valid email address.',

            // 'email.unique' => 'This Email has already been taken.',

            // 'password.required' => 'Password is required',

            // 'password.min' => 'The password should be more than 3 characters long.',

          

            'last_name.required' => 'Last Name is required',

         

             'date_of_birth.required' => 'Date of birth is required',

            'gender_id.required' => 'Gender is required',

           'marital_status_id.required' => 'Marital Status is required',

             'prefered_location.required' => 'Preferred Location in city is required',

            //  'resume.required'    => 'Please Select file',

            //  'resume.mimes' => 'The file Supports only pdf,docx',

            //  'resume,max'   => 'The file Maximum size 2Mb',

         

             'current_city.required' => 'Current City is required',

             'prefered_city.required' => 'Preferred city is required',

             'current_location.required' => 'Current Location in city is required',

             //'phone.required' => 'Please enter phone',

             'physically_challenged.required'  => 'Physically Challenged is required',

       

             'industry.required' => 'Industry is required',

    

              'street_address.required' => 'Address is required',

            

        ];

    }

}

