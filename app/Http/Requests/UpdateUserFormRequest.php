<?php



namespace App\Http\Requests;



use Illuminate\Foundation\Http\FormRequest;



class UpdateUserFormRequest extends FormRequest

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

           // 'last_name' => 'alpha |max:80',

            'email' => 'required|unique:users,email|email|max:100',

            'recruiter_email' => 'required|email|max:100',
            'recruiter_phone' => 'required|max:80',
       

            'phone'     =>'required|numeric|digits:10',

            'nop_days'  => 'required',

            // 'resume'   => 'required|max:2048',

        //     'terms_of_use' => 'required',

             'immediate_last_date' => 'required_if:nop_days,1',
             
        //    //  'confirm_nop' => 'required_if:nop_days,1',

             'expect_ctc_lakhs'  => 'required',

             'expect_ctc_thousand' => 'required',
             
             'expect_ctc_lakhs3' => 'required',

             'expect_ctc_thousand3'   => 'required',

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

             'gender_id'   => 'required',
             
             'year_of_completion'  => 'required', 
             
             'recruiter_comments'  => 'required',

             'prefered_city' => 'required|min:1',

        
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

            'phone.required'  => __('Phone Number is required'),

            'phone.numeric'    => __('Phone Number Must be an Number'),

            'nop_days.required'  => __(' Notice Period is required'),

          //  'resume.required'   => __('Resume is required'),

            'resume.mimes'        =>   __('Upload resume will accept only .pdf and .docx'),

            'resume.max'   =>   __(' Size should be lesser than 2 MB'),

            'terms_of_use.required' => __('Please accept Terms & Conditions'),

            'expect_ctc_lakhs.required'  => 'Current CTC Lakhs field is required',

            'expect_ctc_thousand.required'  => 'Current CTC Thousand field is required',

            'expect_ctc_lakhs3.required'  => 'Expect CTC Lakhs field is required',

            'expect_ctc_thousand3.required'  => 'Expect CTC Thousand field is required',
            
            'work_type.required'   => 'Work Type is required',
            
            'immediate_last_date.required_if'  => 'Last Working Date is required',
            
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

            'year_of_completion.required'  => 'Year of completion required', 
             
            'recruiter_comments.required'  => 'Recruiter comments required',

            'prefered_city.required'  => 'Prefered City is required',
            
            'prefered_city.min'  => 'Minimum 1 Prefered City is required',

        ];

    }

}

