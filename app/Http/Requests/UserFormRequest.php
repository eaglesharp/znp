<?php



namespace App\Http\Requests;



use Auth;

use App\Http\Requests\Request;



class UserFormRequest extends Request

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

        $password = 'required|min:6';

        $id_str = '';

        if ($id > 0) {

            $id_str = ',' . $id;

            $password = '';

        }

        return [

            'first_name' => 'required',

            //'middle_name' => 'required',

            //'last_name' => 'required',

            'email' => 'required|unique:users,email' . $id_str . '|email',

            'password' => $password,

           // 'father_name' => 'required',

            'date_of_birth' => 'required',

           'gender_id' => 'required',

            'marital_status_id' => 'required',

            'physically_challenged'  => 'required',

            // 'nationality_id' => 'required',

            //'national_id_card_number' => 'required',

            'current_city' =>'required',

            'prefered_city'  => 'required',

            'current_location'  => 'required',

            'prefered_location'   => 'required',

          



        

            // 'country_id' => 'required',

            // 'state_id' => 'required',

            // 'city_id' => 'required',

            'phone' => 'required',

           // 'mobile_num' => 'required',

           // 'job_experience_id' => 'required',

           // 'career_level_id' => 'required',

            'industry' => 'required',

            // 'process' => 'required',

           // 'current_salary' => 'required',

            //'expected_salary' => 'required',

            //'salary_currency' => 'required',

            'street_address' => 'required|max:256',

            // 'image' => 'image',

            // 'resume'=>'required|mimes:pdf,docx|max:2048' ,

        ];

    }



    public function messages()

    {

        return [

            'first_name.required' => 'First Name is required',

            //'middle_name.required' => 'Middle Name is required',

            'last_name.required' => 'Last Name is required',

            'email.required' => 'Email is required',

            'email.email' => 'The email must be a valid email address.',

            'email.unique' => 'This Email has already been taken.',

            'password.required' => 'Password is required',

            'password.min' => 'The password should be more than 3 characters long.',

            //'father_name.r    equired' => 'Father Name is required',

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



             'phone.required' => 'Phone Number is required',



             'physically_challenged.required'  => 'Physically Challenged is required',



       



             'industry.required' => 'Industry is required',



    



              'street_address.required' => 'Address is required',

        ];

    }



}

