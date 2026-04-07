<?php



namespace App\Http\Requests\Front;



use Auth;

use App\Http\Requests\Request;



class UserFrontRegisterFormRequest extends Request

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

            'first_name' => 'required|regex:/^[a-zA-Z]+$/u|max:80',

           // 'last_name' => 'alpha |max:80',

            'email' => 'required|unique:users,email|email|max:100',

            'password' => 'required|min:6|max:50',

            'password_confirmation' => 'required|same:password|min:6|max:50',

            'phone'     =>'required|numeric|digits:10',

            'nop_days'  => 'required',

             'resume'   => 'required|max:2048',

            'terms_of_use' => 'required',

             'immediate_last_date' => 'required_if:nop_days,1',
             'last_working_day'    => 'required_if:nop_days,2,3,4,5,6',
             
           //  'confirm_nop' => 'required_if:nop_days,1',

             'expect_ctc_lakhs'  => 'required',

             
             
             'expect_ctc_lakhs3' => 'required',

            

             'work_type'   => 'required',

             'latestcom' => 'required',

             'latestdesg'  => 'required',

             'totalexp' => 'required',

             'totalexpmonth' => 'required',

             'keyskills' => 'required|min:10',

             'current_city'  => 'required',

             'degree_title'  => 'required',

             'education_status' => 'required',

             'course'  => 'required_if:degree_title,2,3,4',

             'specilation'  => 'required_if:degree_title,2,3,4',

             'organization'  => 'required_if:degree_title,2,3,4',

             'work_option'  => 'required',
             
             'gender_id'  => 'required',

             'reason_moved' => 'required',

         

            // 'serve_last_date' => 'required_if:nop_days,2'

            //'g-recaptcha-response' => 'required|captcha',

        ];

    }



    public function messages()

    {

        return [

            'first_name.required' => __('First Name is required'),

 

            'last_name.required' => __('Last Name is required'),

            'email.required' => __('Email is required'),

            'email.email' => __('The email must be a valid email address'),

            'email.unique' => __('This Email has already been taken'),

            'password.required' => __('Password is required'),

            'password.min' => __('The password must be at least 6 characters.'),

            'password_confirmation.required' => __('Confirm Password is required'),

            'password_confirmation.min' => __('The password must be at least 6 characters.'),

            'password_confirmation.same' => __(' The password confirmation does not match.'),

            'phone.required'  => __('Phone Number is required'),

            'phone.numeric'    => __('Phone Number Must be an Number'),

            'nop_days.required'  => __(' Notice Period is required'),

            'resume.required'   => __('Resume is required'),

            'resume.mimes'      =>   __('Upload resume will accept only .pdf and .docx'),

            'resume.max'   =>   __(' Size should be lesser than 2 MB'),

            'terms_of_use.required' => __('Please accept Terms & Conditions'),

            'expect_ctc_lakhs.required'  => 'Current CTC Lakhs field is required',

           

            'expect_ctc_lakhs3.required'  => 'Expect CTC Lakhs field is required',

           
            
            'work_type.required'   => 'Work Type is required',
            
            'immediate_last_date.required_if'  => 'Last Working Date is required',
            'last_working_day.required_if'      => 'Last Working Date is required when serving notice',
            
           // 'confirm_nop.required_if' => 'Please confirm',

            'latestcom.required' => 'Latest Company is required',

            'latestdesg.required'  => 'Latest Designation is required',

            'totalexp.required'  => 'Total Experience Year is required',

            'totalexpmonth.required'  => 'Total Experience Month is required',

            'keyskills.required'  => 'Keyskills is required',
            
             'keyskills.min'  => 'Minimum 10 Keyskills is required',

            'current_city.required'  => 'Current City is required',

            'education_status.required' => 'Education staus is required',
            
            'degree_title.required'  => 'Education is required',

            'course.required'  => 'Course is required',

            'specilation.required'  => 'Specialization is required',

            'organization.required'  => 'University / College is required',

            'work_option.required'   => 'Preferred Mode is required',

            'gender_id.required'   => 'Gender is required',

           

            //'g-recaptcha-response.required' => __('Please verify that you are not a robot'),

            //'g-recaptcha-response.captcha' => __('Captcha error! try again later or contact site admin'),

        ];

    }



}

