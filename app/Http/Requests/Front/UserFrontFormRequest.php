<?php

namespace App\Http\Requests\Front;

use Auth;
use App\Http\Requests\Request;

class UserFrontFormRequest extends Request
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
            'first_name' => 'required|max:80',
            //'middle_name' => 'required',
           // 'last_name' => 'required',
            // 'email' => 'required|unique:users,email' . $id_str . '|email',
            // 'password' => $password,
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
             'process' => 'required',
           // 'current_salary' => 'required',
            //'expected_salary' => 'required',
            //'salary_currency' => 'required',
            'street_address' => 'required|max:200',
            // 'image' => 'image',
        ];
    }

    public function messages()
    {
        return [
            'first_name.required' => 'First Name is required',
            //'middle_name.required' => 'Middle Name is required',
            'last_name.required' => 'Last Name is required',
            // 'email.required' => 'Email is required',
            // 'email.email' => 'The email must be a valid email address.',
            // 'email.unique' => 'This Email has already been taken.',
            // 'password.required' => 'Password is required',
            // 'password.min' => 'The password should be more than 3 characters long.',
            //'father_name.r    equired' => 'Father Name is required',
            'date_of_birth.required' => 'Date of birth is required',
            'gender_id.required' => 'Please select gender',
            'marital_status_id.required' => 'Please select marital status',
            'prefered_location.required' => 'Please select prefered location',
            //'national_id_card_number.required' => 'national ID card# required',
            'current_city.required' => 'Please select current city',
            'prefered_city.required' => 'Please select prefered city',
            'current_location.required' => 'Please select current location',
            'phone.required' => 'Please enter phone',
            'physically_challenged.required'  => 'Please Select',
           // 'mobile_num.required' => 'Please enter mobile number',
            //'job_experience_id.required' => 'Please select experience',
            //'career_level_id.required' => 'Please select career level',
            'industry.required' => 'Please select industry',
            'street_address.max'   =>   __(' Size should be lesser than 200 words'),
            'process.required' => 'Please select type of process',
            //'current_salary.required' => 'Please enter current salary',
            //'expected_salary.required' => 'Please enter expected salary',
            //'salary_currency.required' => 'Please select salary currency',
            'street_address.required' => 'Please enter street address',
            // 'image.image' => 'Only images can be uploaded.',
        ];
    }

}
