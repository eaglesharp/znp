@extends('layouts.app')



@section('content')
    <!-- Header start -->

    @include('includes.header')


    
    <style>
        .savelocation ,.searchvalue {
            height: 55px;
            border: 1px solid #cbcbcb;
            background-image: none !important;
        }

        #ui-id-1 :is(li.ui-menu-item:hover, li.ui-menu-item.active) {
            background-color: #e3eaf2;
        }
        #ui-id-2 :is(li.ui-menu-item:hover, li.ui-menu-item.active) {
            background-color: #e3eaf2;
        }

        .notice-period .dropdown-menu {
            height: 96px !important;

        }

        .serach-icon .tokenfield {
            width: 455px !important;
            min-height: 55px !important;
        }

        .location_cus .tokenfield .token {
            border-radius: 30px !important;
            background-color: #f6faff !important;
            padding: 0px 10px;
            height: 26px !important;
        }

        .notice-period .btn-group {
            width: 100% !important;

        }


        .notice-period button.multiselect.dropdown-toggle.btn.btn-default {
            padding: 7px 35px 5px 15px !important;
            height: 36px !important;
        }


        .date-in {
            height: 36px !important;
        }

        .location_cus .tokenfield {
            min-height: 55px;
        }

        #search_data {
            background-image: unset !important;
            min-height: 55px !important;
            border: 1px solid #ced4da;
        }

        .tokenfield .token .close {
            line-height: 1.1em !important;

        }



        .boxing {

            padding: 5px 20px 20px 30px !important;

        }

        .sign_head {

            position: relative;

        }

        .sign_head.v-icon.stick_label {

            font-size: 12px;
            background: #59a2f3;
            color: #fff;
            font-family: 'Proximanova-Regular';
            padding: 3px 10px;
            border-radius: 30px;


        }

        .sign_head.research {

            font-size: 12px;
            /*background: #197ff3;*/
            color: #0642a9;
            font-family: 'Proximanova-Regular';
            padding: 3px 10px;
            border-radius: 30px;
            border: 2px solid #0642a9;

        }

        .joblist {
            position: absolute;
            right: -5px;
            top: -7px;
        }


        .list-inline-item-1.layoff-cv {
            background-color: #197ff3;
            color: #fff !important;
            padding: 2px 7px;
            border-radius: 0 5px 0 10px;
            line-height: 19px;
            font-size: 13px;
            display: inline-block;
        }

        .select_input_cus input.email_checkbox.mail_send-box.text-left {

            top: 19px;

            left: -15px;

        }

        @media (max-width: 575px) {
            .sign_head.v-icon.stick_label::after {
                top: 30px;
                left: 0px;
                right: unset;
            }
        }

        .default-size {
            font-size: 15px !important;
        }

        .candidate_title-head {
            font-size: 20px;

        }

        .candidate_text {
            font-size: 20px;

        }

        #more-button {
            background: transparent;
            border: none;
            text-decoration: underline;
            color: blue;
        }

        .recruiter-comments {
            font-size: 15px !important;
            color: #696969 !important;
            font-family: "proximanova-regular" !important;
        }

        .docx-wrapper>section.docx {
            box-shadow: 0 0 2px rgb(0 0 0 / 50%) !important;
            width: 100% !important;
        }
        .searchvalue-tokenfield{
            margin-top:10px;
        }
        
        .down-btn {
            background-color: #0642a9;
            padding: 13px 20px 13px 20px !important;
            border-radius: 5px;
            border: 2px solid #0642a9;
            transition: 1s ease;
            cursor: pointer;
        }

        .down-btn {
            background-color: #0642a9;
            padding: 13px 20px 13px 20px !important;
            border-radius: 5px;
            border: 2px solid #0642a9;
            transition: 1s ease;
            cursor: pointer;
        }

        .docx-wrapper {
            background: #fff !important;
        }

        .docx-wrapper>section.docx {
            box-shadow: 0 0 2px rgb(0 0 0 / 50%) !important;
            width: 100% !important;

        }

        #rendermodal.modal.show .modal-dialog ,#docrendermodal.modal.show .modal-dialog{
            display: flex;
            justify-content: center;
        }

        #rendermodal.modal.fade .modal-dialog,#docrendermodal.modal.fade .modal-dialog {
            display: flex;
            justify-content: center;
        }

        canvas {
            max-width: -webkit-fill-available;
        }
    </style>


    @php
        // Define the selected values

        if (isset($locations_vals)) {
            $selected = $locations_vals;
        }
        if (isset($search_vals)) {
            $searchselected = $search_vals;
        }

    @endphp


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tagify/4.32.1/tagify.css"/>
    <style>
        .savelocation ,.searchvalue {
            height: 55px;
            border: 1px solid #cbcbcb;
            background-image: none !important;
            padding-top:10px;
        }

        #ui-id-1 :is(li.ui-menu-item:hover, li.ui-menu-item.active) {
            background-color: #e3eaf2;
        }
        #ui-id-2 :is(li.ui-menu-item:hover, li.ui-menu-item.active) {
            background-color: #e3eaf2;
        }

        .notice-period .dropdown-menu {
            height: 96px !important;

        }

        .serach-icon .tokenfield {
            width: 455px !important;
            min-height: 55px !important;
        }

        .location_cus .tokenfield .token {
            border-radius: 30px !important;
            background-color: #f6faff !important;
            padding: 0px 10px;
            height: 26px !important;
        }

        .notice-period .btn-group {
            width: 100% !important;

        }


        .notice-period button.multiselect.dropdown-toggle.btn.btn-default {
            padding: 7px 35px 5px 15px !important;
            height: 36px !important;
        }


        .date-in {
            height: 36px !important;
        }

        .location_cus .tokenfield {
            min-height: 55px;
        }

        #search_data {
            background-image: unset !important;
            min-height: 55px !important;
            border: 1px solid #ced4da;
        }

        .tokenfield .token .close {
            line-height: 1.1em !important;

        }



        .boxing {

            padding: 5px 20px 20px 30px !important;

        }

        .sign_head {

            position: relative;

        }

        .sign_head.v-icon.stick_label {

            font-size: 12px;
            background: #59a2f3;
            color: #fff;
            font-family: 'Proximanova-Regular';
            padding: 3px 10px;
            border-radius: 30px;


        }

        .sign_head.research {

            font-size: 12px;
            /*background: #197ff3;*/
            color: #0642a9;
            font-family: 'Proximanova-Regular';
            padding: 3px 10px;
            border-radius: 30px;
            border: 2px solid #0642a9;

        }

        .joblist {
            position: absolute;
            right: -5px;
            top: -7px;
        }


        .list-inline-item-1.layoff-cv {
            background-color: #197ff3;
            color: #fff !important;
            padding: 2px 7px;
            border-radius: 0 5px 0 10px;
            line-height: 19px;
            font-size: 13px;
            display: inline-block;
        }

        .select_input_cus input.email_checkbox.mail_send-box.text-left {

            top: 19px;

            left: -15px;

        }

        @media (max-width: 575px) {
            .sign_head.v-icon.stick_label::after {
                top: 30px;
                left: 0px;
                right: unset;
            }
        }

        .default-size {
            font-size: 15px !important;
        }

        .candidate_title-head {
            font-size: 20px;

        }

        .candidate_text {
            font-size: 20px;

        }

        #more-button {
            background: transparent;
            border: none;
            text-decoration: underline;
            color: blue;
        }

        .recruiter-comments {
            font-size: 15px !important;
            color: #696969 !important;
            font-family: "proximanova-regular" !important;
        }

        .docx-wrapper>section.docx {
            box-shadow: 0 0 2px rgb(0 0 0 / 50%) !important;
            width: 100% !important;
        }
        .searchvalue-tokenfield{
            margin-top:10px;
        }
    </style>



    @php

        $collections = \App\Collection::where('user_id', Auth::guard('company')->user()->id)->get();

        $incount = 1;

    @endphp



    <!-- first section -->

    @if (session()->has('plan_exp_msg'))



        <input type="hidden" name="" id="yes" value="{{ session()->get('plan_exp_msg') }}">



    @endif



    <section class="section_search-box pt-2">


        <div class="container">



            <?php
            
            $company_id = Auth::guard('company')->user()->id;
            
            $company_value = \App\Company::where('id', $company_id)->first();
            
            $now = \Carbon\Carbon::now();
            
            $end_date = $company_value->package_end_date;
            
            //echo $end_date;
            
            ?>



            @if ($end_date)



                @if ($end_date < $now)

                    <div class="alert alert-info mt-2" id="show_alert">

                        Your subscription is inactive. Visit pricing page for purchase options

                    </div>

                @endif
            @else
            <div class="row">
            <div class="{{ Auth::guard('company')->user()->kyc_verified == 2 ? 'col-lg-12': 'col-lg-6' }}">
                <div class="success d-flex justify-content-between align-items-center mt-3"
                    style="border: 1px solid #3998de;padding: 5px 5px 5px 15px;border-radius: 30px;">
                    <div>
                        <h6 class="mb-0 pl-2">
                            Upgrade a Plan
                        </h6>
                    </div>
                    <a href="{{ route('pricing') }}" class="btn btn-plan buy_now " style="
                                        background-color: #197ff3;
                                        color: white;
                                    ">Buy now</a>
                </div>
            </div>
            @if (Auth::guard('company')->user()->kyc_verified != 2)
                <div class="col-lg-6">
                    <div class="success d-flex  mt-3"
                        style="border: 1px solid #3998de;padding: 5px 5px 5px 15px;border-radius: 30px;">
                        <h6 class="mt-2 text-center">
                                KYC Verification
                            @if(Auth::guard('company')->user()->kyc_verified == 0)
                                (Not Verified)
                                <a href="{{ url('/employer-dashboard') }}" class="" style="font-size: 14px;font-weight: 600;">  Submit Now </a>
                            @elseif (Auth::guard('company')->user()->kyc_verified == 1)
                                (In Progress). 
                            @elseif(Auth::guard('company')->user()->kyc_verified == 3)
                                (Resubmit)
                                <a href="{{ url('/employer-dashboard') }}" class="" style="font-size: 14px;font-weight: 600;"> Submit Now </a>.
                            @endif
                        </h6>
                    </div>
                </div >
            @endif
        </div>
            @endif




            <p id="success_id102" class="p-success34 homealert1 px-0"></p>

            <div class='alert alert-success newclass' id="myElem" style="display:none;">Email Sent Successfully</div>

            <div class="success_msg1 success_msg26 " id="success_msg26"></div>

            <div class="success_msg1 success_msg27 " id="success_msg27"></div>

            <div class="success_msg1 draft_success " id="draft_success"></div>


            <div class="errormsg1 " id="errormsg1"></div>



            <?php echo session()->get('search1'); ?>



            <form id="filter1" class="row px-2 mt-sm-5" action="{{ route('candidate.filter1.search') }}" method="post">
                @csrf
                <div class="col-lg-12 form-inline serach-icon location_cus  px-2">
                    <input id="skillsData" value="{{ $search_skill ?? '' }}" name="search"
                        class="form_control rounded pl-3 pr-5 w-100 searchvalue" placeholder="Enter Skills ">

                    {{-- <button class="filter_search-button" type="submit"><img class="search_icon-input pr-0"
                            src="{{ asset('asset/images/loupe.png') }}"></button>  --}}
                </div>


                <div class="col-lg-8 mt-2 position_lit px-2 notice-period location_cus">

                    <input id="tags" value="{{ $store_locations ?? '' }}" name="location"
                        class="form_control rounded pl-3 pr-5 w-100 savelocation" placeholder="Search Location">

                </div>

                <div class="col-lg-2  mt-2">

                    <button type="submit" class="btn btn_submit w-100 text-light">Apply</button>

                </div>
                <div class="col-lg-1 d-flex justify-content-center align-items-center p-0">

                    <a onclick="clearfilter1()" class=""
                        style="color:#197ff3;text-decoration: underline;cursor:pointer">Clear</a>
                </div>

            </form>

        </div>

    </section>



    <!-- second section -->



    <section class="section_candidate-list py-4">

        <div class="container">

            <div class="row">

                <div class="col-lg-3 col-12 scrollbar candidate_filter-sub">

                    <div class="candidate_filter-inner">

                        <div class="row d-block d-lg-none">

                            <div class="col-lg candidate_filter-header">

                                <div class="candidate_filter-body candidate_filter-hide py-3 px-2">

                                    All Filters

                                    <a id="filter_hide-button" class="close_icon-algin" href="javascript:void(0);">

                                        <img class="close_img-icon" src="asset/images/cancel.png">

                                    </a>

                                </div>

                            </div>

                        </div>

                        <div class="candidate_list-filter mb-4 mb-md-0 px-0">

                            <div class="accordion" id="accordionExample">

                                <div class="candidate_list mt-2 border">

                                    <div class="candidate_head mb-1 px-lg-0" id="headingOne">

                                        <button class="btn_candidate-box btn_candidate-arrow px-3 py-4" type="button"
                                            data-toggle="collapse" data-target="#collapseOne" aria-expanded="true"
                                            aria-controls="collapseOne">

                                            Sub Filters

                                        </button>

                                    </div>

                                    <div id="collapseOne" class="collapse {{ (isset($search_skill) ||isset($store_locations))?'show' : '' }}" aria-labelledby="headingOne"
                                        data-parent="#accordionExample">

                                        <div class="candidate_body px-lg-3 py-2">

                                            <div class="form-check pb-2 pl-0 w-100">

                                                <form action="{{ route('candidate.filter2.search') }}" method="post">

                                                    @csrf



                                                    <label class="mb-1 pt-0 sign_fontsize">Total Experience (In Years)<span
                                                            class="text-danger px-1"> </span></label>



                                                    <div class="row py-1">



                                                        <div class="col">

                                                            <input type="number" name="min_exp" placeholder="Min"
                                                                min="0" max="50"
                                                               @if(old('min_exp'))
                                                                    value="{{ old('min_exp')}}"
                                                                @elseif (isset($min_exp)) @if ($min_exp == 0) @else value="{{ $min_exp }}" @endif
                                                            @else value="" @endif

                                                            onkeyup=imposeMinMax(this)

                                                            class="w-100 signup_input rounded pl-2 py-1 default-size min_exp"
                                                            id="save_min_exp">

                                                        </div>

                                                        <div class="col-1 text-center px-0 pt-1">-</div>

                                                        <div class="col">

                                                            <input type="number" name="max_exp" placeholder="Max"
                                                                min="0" max="50"
                                                                
                                                                @if(old('max_exp'))
                                                                    value="{{ old('max_exp')}}"
                                                                @elseif (isset($max_exp)) @if ($max_exp == 0) @else value="{{ $max_exp }}" @endif
                                                            @else value="" @endif

                                                            onkeyup=imposeMinMax(this)

                                                            class="w-100 signup_input rounded pl-2 py-1 default-size max_exp"
                                                            id="save_max_exp">

                                                        </div>

                                                    </div>

                                                    @if ($errors->has('max_exp'))

                                                        <p class="text-danger">{{ $errors->first('max_exp') }}</p>

                                                    @endif



                                                    <label class="mb-1 pt-0 sign_fontsize mt-2">Current CTC Range (In
                                                        Lakhs)<span class="text-danger px-1"> </span></label>



                                                    <div class="row py-1">



                                                        <div class="col">

                                                            <input type="number" name="min_salary" placeholder="Min"
                                                                min="0" max="100" onkeyup=imposeMinMax(this)
                                                                
                                                                @if(old('min_salary'))
                                                                    value="{{ old('min_salary')}}"
                                                                @elseif (isset($min)) 
                                                                    @if ($min == 0) 
                                                                    @else value="{{ $min }}" 
                                                                    @endif
                                                                @else value="" 
                                                                @endif

                                                            class="w-100 signup_input rounded px-1 py-1 default-size min_salary"
                                                            id="save_min_salary">

                                                        </div>

                                                        <div class="col-1 text-center px-0 pt-1">-</div>

                                                        <div class="col">

                                                            <input type="number" name="max_salary" placeholder="Max"
                                                                min="0" max="100" onkeyup=imposeMinMax(this)
                                                                
                                                                @if(old('max_salary'))
                                                                    value="{{ old('max_salary')}}"
                                                                @elseif (isset($max)) @if ($max == 0) @else value="{{ $max }}" @endif
                                                            @else value="" @endif

                                                            class="w-100 signup_input rounded default-size px-1 py-1 max_salary"
                                                            id="save_max_salary">






                                                        </div>

                                                    </div>


                                                    @if ($errors->has('max_salary'))

                                                        <p class="text-danger">{{ $errors->first('max_salary') }}</p>

                                                    @endif

                                            </div>


                                            <label class="mb-1 pt-0 sign_fontsize">Interview Availability<span
                                                    class="text-danger px-1"> </span></label>


                                            <div class="row py-1">



                                                <div class="col">

                                                    <input type="text" name="previous_start_date"
                                                        class="form_action date-in rounded pl-2 mb-3 previous_start_date"
                                                        id="previous_start_date"
                                                        value="{{ isset($s_date) ? $s_date : '' }}"
                                                        placeholder="Start Date">


                                                </div>



                                                <div class="col">

                                                    <input type="text" name="previous_end_date"
                                                        class="form_action date-in rounded pl-2 mb-3 previous_end_date"
                                                        id="previous_end_date"
                                                        value="{{ isset($e_date) ? $e_date : '' }}"
                                                        placeholder= "End Date">


                                                    @if ($errors->has('previous_end_date'))

                                                        <span
                                                            class="text-danger">{{ $errors->first('previous_end_date') }}</span>

                                                    @endif

                                                </div>

                                            </div>
                                            @if ($errors->has('previous_end_date'))

                                                <p class="text-danger">{{ $errors->first('previous_end_date') }}</p>

                                            @endif


                                            <div class="row py-1 notice-period"
                                                style="    margin-left: 0px;
                                        width: 100%;
                                        padding-bottom: 15px!important;">

                                                <select id="multiple-select-notice"
                                                    class="form_control  noticeperiodvalue  form_action rounded pl-3 pr-5 mb-3"
                                                    multiple="multiple" name="notice_period[]" style="pointer-events: none;cursor: default;">

                                                    <option value="1"
                                                        @if (isset($notice_period)) @if (in_array(1, $notice_period)) selected @endif
                                                        @endif>



                                                        Immediately Available </option>

                                                    <option value="2"
                                                        @if (isset($notice_period)) @if (in_array(2, $notice_period)) selected @endif
                                                        @endif>Serving

                                                        Notice Period</option>



                                                </select>
                                            </div>



                                            <?php
                                            
                                            $profile_education = isset($profileEducation) ? $profileEducation->degree_title : null;
                                            
                                            $educationn = \App\Education::find($profile_education);
                                            
                                            $educations = \App\Education::all();
                                            
                                            $education = isset($education) ? $education : null;
                                            
                                            $education1 = \App\Education::where('id', $education)->first();
                                            
                                            ?>



                                            <select class="form_control form_action rounded pl-3 pr-5 mb-3 dynamic "
                                                name="education" style="height: 35px!important;" id="save_education">





                                                <option value="">Select Education</option>

                                                <!--<option value="">All</option>-->

                                                @foreach ($educations as $edu)
                                                    <option value="{{ $edu->id }}"
                                                        @isset($education)  {{ $edu->id == $education ? 'selected' : '' }} @endisset>
                                                        {{ $edu->education }} </option>
                                                @endforeach

                                            </select>





                                            <?php
                                            
                                            $organization = isset($course) ? $course : null;
                                            
                                            $specilation = isset($specilation) ? $specilation : null;
                                            
                                            $course = \App\Course::where('id', $organization)->first();
                                            
                                            $spec = \App\specs::where('id', $specilation)->first();
                                            
                                            ?>




                                            <select class="form_control form_action rounded pl-3 pr-5 mb-3 gender"
                                                name="gender" style="height: 35px!important;" id="save_gender">

                                                <!--<option Selected Disabled>Gender</option>-->

                                                <option value="">Gender</option>

                                                <option value="2"
                                                    @if (isset($gender)) @if ($gender == '2') selected @endif
                                                    @endif>Male</option>

                                                <option value="1"
                                                    @if (isset($gender)) @if ($gender == '1') selected @endif
                                                    @endif>Female</option>

                                                <option value="3"
                                                    @if (isset($gender)) @if ($gender == '3') selected @endif
                                                    @endif>Don't wish to specify</option>

                                            </select>



                                            <select class="form_control form_action job_type rounded pl-3 pr-5 mb-3"
                                                name="job_type" style="height: 35px!important;" id="save_job_type">

                                                <!--<option Selected Disabled>Job Type</option>-->

                                                <option value="">Job Type</option>

                                                <option value="Contract"
                                                    @if (isset($job_type)) @if ($job_type == 'Contract')

                                                        selected @endif
                                                    @endif>Contract</option>

                                                <option value="Permanent"
                                                    @if (isset($job_type)) @if ($job_type == 'Permanent') selected @endif
                                                    @endif>Permanent</option>

                                                <option value="Flexible"
                                                    @if (isset($job_type)) @if ($job_type == 'Flexible') selected @endif
                                                    @endif>Flexible</option>

                                            </select>



                                        </div>



                                        <div class="col-lg-12 box d-block px-0 px-lg-3 mb-1 pb-2 text-center">

                                            <button type="submit" class="btn btn_submit w-100 text-light">Apply</button>


                                        </div>
                                        <div class="d-flex justify-content-center">

                                            <a onclick="clearfilter2()" class="pb-4 "
                                                style="color:#197ff3;text-decoration: underline;cursor:pointer">Clear</a>
                                        </div>

                                        </form>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div <!-- candidate listing left part -->



                <div class="col-lg-9 footer-aligns">

                    <div class="col-lg-12 candidates_job-dashboard pt-3 pb-2 px-0 pt-0">

                        <div class="row mx-0 select-all py-3 align-items-center">

                            <div class="col-lg-3 pb-3 pb-lg-0">

                                <div class="col-12 candidates_job-dashboard px-0 pt-0">

                                    <div class="container">

                                        <div class="alert alert-success newclass" id="myElem" style="display:none;">
                                            Email

                                            send successfully</div>

                                    </div>

                                    <div class="">

                                        <a id="filter_show-button" class="filter_icon-algin d-block d-lg-none"
                                            href="javascript:void(0);">



                                            <img class="filter_img-icon" src="asset/images/Group-1.png">

                                        </a>

                                    </div>

                                    <div class="select_all-check d-flex align-items-center  d-inline">

                                        <span><input type="checkbox" id="select_all" class="checkbox_size"
                                                maxlength="100" required=""><label for="select_all"
                                                class="px-2 sign_head_cus mb-0">Select

                                                all <span id="selected_count"></span></label></span>

                                    </div>

                                </div>

                            </div>

                            <div class="col-md-9 text-lg-right">



                                <button type="submit"
                                    class="py-2 signup_button rounded px-2 px-sm-3 mr-0 mb-1 mb-md-0 mr-xl-3"
                                    onclick="savesearchmodal()"
                                    style="
            border-radius: 40px!important;
        ">Save Search</button>

                                <input type="hidden" name="filter" value="{{ $filter ?? '' }}" id="save_filter">

                                <!--<button type="submit" class="py-2 signup_button rounded px-2 px-xl-3 mr-0 mb-1 mb-md-0 mr-xl-3"-->

                                <!--    data-toggle="modal" data-target="#smsmodal">SMS Candidate</button>-->

                                
                                @if ((Auth::guard('company')->check() && Auth::guard('company')->user()->kyc_verified == 2) ||  Auth::guard('company')->user()->package_id != 0)
                                <button type="submit"
                                    class="py-2 signup_button rounded px-2 px-sm-3 mr-0 mb-1 mb-md-0 mr-xl-3"
                                    data-toggle="modal" data-target="#emailmodal"
                                    style="
                                        border-radius: 40px!important;
                                    ">Send
                                    Email</button>
                                @endif
                                {{-- <button type="submit" class="py-2 signup_button rounded mb-1 mb-md-0 px-2 px-sm-3 "
                                    data-toggle="modal" data-target="#addfoldermodal"
                                    style="border-radius: 40px!important;">Add To
                                    Folder</button> --}}

                            </div>

                        </div>



                    </div>


                    {{-- <span class="candidate_title-head">Showing {{count($users)}} <span class="candidate_text">Results</span></span> --}}

                    <div class="pagiWrap pb-2"> 

                        <nav aria-label="Page navigation example">

                            @if (isset($users) && count($users))
                            {{ $users->appends(request()->query())->render('custom-pagination') }}

                                {{-- {{ $users->appends(request()->query())->links() }}  --}}
                                @endif

                        </nav>

                    </div>
                    


                    <div class="job_offers pt-1 users-data" style='user-select: none;'>

                        @include('company.candidate-search-result')

                    </div>


                    <div class="pagiWrap pb-2">

                        <nav aria-label="Page navigation example">

                            @if (isset($users) && count($users))
                            {{ $users->appends(request()->query())->render('custom-pagination') }}
                            @endif

                                {{-- {{ $users->appends(request()->query())->links() }} @endif --}}

                        </nav>

                    </div>
                </div>





                <!--sms modal Start-->

                <div class="container">

                    <!-- modal -->

                    <div class="modal newmodalclass" id="savesearchmodal">

                        <div class="modal-dialog">

                            <div class="modal-content mx-auto">

                                <!-- header -->

                                <div class="alert alert-danger print-error-msg" style="display:none">

                                    <ul></ul>

                                </div>



                                <form method="post" action="" enctype="multipart/form-data">

                                    @csrf

                                    <div class="col-12 pt-3">



                                        <div class="row">

                                            <div class="col-md-8">

                                                <h4 class="modal-title sign_head">Save Search</h4>

                                            </div>

                                            <div class="col-md-4">

                                                <p type="button" class="info" data-dismiss="modal"><img
                                                        class="float-right modal_close-icon"
                                                        src="{{ asset('/') }}asset/images/close.png"></p>

                                            </div>

                                        </div>

                                    </div>

                                    <!-- body -->

                                    <div class="modal-body">

                                        <span class="help-block user_id-error"></span>

                                        <div class="row">

                                            <input type="hidden" value="" name="search" id="savesearch">

                                            <!-- <input type="hidden" value="" name="location" id="savelocation"> -->

                                            <input type="hidden" value="" name="notice_period"
                                                id="save_notice_period">
                                            @php
                                                if (isset($selected)) {
                                                    $valueString = implode(',', $selected);
                                                } else {
                                                    $valueString = '';
                                                }
                                            @endphp

                                            <input type="hidden" value="{{ $valueString }}" name="location"
                                                id="save_location">



                                            <div class="col-md-12 pb-2">

                                                <label>Search Name</label>



                                                <input type="text" name="search_value" id="search_value"
                                                    value="" class="form-control">



                                                <span class="help-block search_value-error"></span>



                                                <span class="text-danger">

                                                    <strong id="search_value-error" class="new_error_class"></strong>

                                                </span>

                                            </div>

                                        </div>

                                    </div>

                                    <div class="modal-footer justify-content-end px-3">

                                        <button type="button" class="btn btn-secondary py-2 mr-3"
                                            data-dismiss="modal">Cancel</button>

                                        <button type="button" id="save_form_submit"
                                            class="signin_button px-4 py-2 emailsend rounded">Save</button>

                                    </div>

                                </form>

                            </div>

                        </div>

                    </div>

                </div>


            </div>



        </div>



    </section>






    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.6.347/pdf.min.js"></script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.6.347/pdf_viewer.min.css" rel="stylesheet"
        type="text/css" />

    @include('includes.footer')
@endsection


<script type="text/javascript" src="https://unpkg.com/jszip/dist/jszip.min.js"></script>

@push('scripts')




    <!--email modal -->



    <div class="container">

        <!-- modal -->

        <div class="modal newmodalclass" id="emailmodal">

            <div class="modal-dialog">

                <div class="modal-content mx-auto">

                    <!-- header -->

                    <div class="alert alert-danger print-error-msg" style="display:none">

                        <ul></ul>

                    </div>



                    <form enctype="multipart/form-data" onkeydown="return event.key != 'Enter';">

                        @csrf

                        <div class="col-12 pt-3">

                            <div class="row">

                                <div class="col-8">

                                    <h4 class="modal-title sign_head">Send Email</h4>

                                </div>

                                <div class="col-4">

                                    <p type="button" class="info" data-dismiss="modal"><img
                                            class="float-right modal_close-icon"
                                            src="{{ asset('/') }}asset/images/close.png"></p>

                                </div>

                            </div>

                        </div>

                        <!-- body -->

                        <div class="modal-body">

                            <span class="text-danger">

                                <strong id="mail_user_id-error" class="new_error_class user_id-error"></strong>

                            </span>

                            @php

                                $templates = DB::table('templates')
                                    ->where('company_id', Auth::guard('company')->user()->id)
                                    ->get();

                            @endphp



                            <div class="row">

                                <input type="hidden" value="" name="user_id" id="user_id">

                                <input type="hidden" name="templateid" id="templateid" value="0">

                                @if (count($templates) > 0 && isset($templates))

                                    <div class="col-md-12 pb-2 mb-4">

                                        <select class="form-control" id="template" name="template"
                                            style="width: 175px;background: #e3e3e3;float:right;">

                                            @php

                                                $templates = DB::table('templates')
                                                    ->where('company_id', Auth::guard('company')->user()->id)
                                                    ->get();

                                            @endphp

                                            <option selected value="">Select Templates</option>

                                            @foreach ($templates as $template)
                                                <option value="{{ $template->id }}">{{ $template->templatename }}
                                                </option>
                                            @endforeach

                                        </select>

                                        {{-- <span class="text-danger">

                                                <strong id="template-error-sec" class="new_error_class template-error"></strong>

                                            </span> --}}

                                    </div>



                                    {{-- <div class="col-md-4 pb-2">

                                            <button type="button"  id="createnew"

                                        class="signin_button px-4 py-2 emailsend rounded">Create New</button>

                                        </div> --}}
                                @else
                                    <div class="col-md-12 pb-2 mb-4">

                                        <select class="form-control"
                                            style="width: 175px;background: #0a2cdb;float:right;color: white;">

                                            <option selected disabled>No Templates</option>

                                        </select>

                                    </div>





                                @endif







                                <div class="col-md-12 pb-2">

                                    <textarea class="form-control" placeholder="Subject" aria-label="With textarea" id="subject" name="subject"
                                        rows="1"></textarea>

                                    <span class="text-danger">

                                        <strong id="subject-error" class="new_error_class subject-error"></strong>

                                    </span>

                                </div>





                                <div class="col-md-12 pb-2">

                                    <textarea class="form-control summernote" placeholder="Message" id="description" name="description"
                                        aria-label="With textarea" rows="3"></textarea>

                                    <span class="text-danger">

                                        <strong id="description-error" class="new_error_class description-error"></strong>

                                    </span>

                                </div>





                                <div class="col-md-12 pb-2 mt-5">

                                    <label>Save Template <span class="text-danger">*</span></label>

                                    <a href="{{ url('email-templates') }}" target="_blank"
                                        style="float: right;margin-right: 10px;">Edit</a>

                                    <input class="form-control" placeholder="Template Name" id="name"
                                        name="name" rows="1">

                                    <span class="text-danger">

                                        <strong id="name-error" class="new_error_class name-error"></strong>

                                    </span>

                                </div>

                                {{-- <div class="col-md-10 pb-2" @if (count($templates) > 0 && isset($templates)) style="display:none" @endif id="templatediv">

                                        <label>Save Template <span class="text-danger">*</span></label>



                                        <input  class="form-control" placeholder="Template Name"

                                            id="name" name="name" rows="1"></textarea>

                                        <span class="text-danger">

                                            <strong id="name-error" class="new_error_class name-error"></strong>

                                        </span>

                                    </div> --}}

                            </div>

                        </div>

                        <div class="modal-footer justify-content-end px-3">

                            <button type="button" class="btn btn-secondary py-2 mr-3"
                                data-dismiss="modal">Cancel</button>

                            <button type="button" id="preview"
                                class="signin_button px-4 py-2 emailsend rounded">Preview</button>

                            <button type="button" id="form_Submit"
                                class="signin_button px-4 py-2 emailsend rounded">Send</button>

                        </div>

                    </form>

                </div>

            </div>

        </div>


    </div>



    <div class="container">



        <div class="modal newmodalclass" id="previewmodal" style="overflow-y: auto;">

            <div class="modal-dialog">

                <div class="modal-content mx-auto">

                    <!-- header -->

                    <div class="alert alert-danger print-error-msg" style="display:none">

                        <ul></ul>

                    </div>





                    <div class="col-12 pt-3">

                        <div class="row">

                            <div class="col-8">

                                <h4 class="modal-title sign_head">Preview Email</h4>

                            </div>

                            <div class="col-4">

                                <p type="button" class="info" data-dismiss="modal"><img
                                        class="float-right modal_close-icon"
                                        src="{{ asset('/') }}asset/images/close.png"></p>

                            </div>

                        </div>

                    </div>

                    <!-- body -->

                    <div class="modal-body">

                        <table border="0" cellpadding="0" cellspacing="0" class="force-row"
                            style="width: 100%;    border-bottom: solid 1px #ccc;">
                            <tr>
                                <td class="cols-wrapper" style="padding-left:12px;padding-right:12px">
                                    <table border="0" cellpadding="0" cellspacing="0" align="left"
                                        class="force-row" style="width: 100%;">



                                        <tr>



                                            <td class="row" valign="top"
                                                style="padding-left:12px;padding-right:12px;padding-top:18px;padding-bottom:12px">
                                                <table border="0" cellpadding="0" cellspacing="0"
                                                    style="width:100%;">





                                                    <tr>

                                                        <td
                                                            style="font-family:Helvetica,Arial,sans-serif;font-size:14px;line-height:22px;font-weight:400;color:#333;padding-bottom:3px;text-align:left;padding-top: 42px;">

                                                            <b>Subject</b> :<span id="previewsubject"></span>

                                                        </td>

                                                    </tr>

                                                    <tr>

                                                        <td
                                                            style="font-family:Helvetica,Arial,sans-serif;font-size:14px;line-height:22px;font-weight:400;color:#333;padding-bottom:30px;text-align:left;padding-top: 4px;">

                                                            <b> Message</b> :<p id="previewmessage" class="summernote">
                                                            </p>
                                                        </td>

                                                    </tr>
                                                </table>



                                                <br>
                                            </td>



                                        </tr>



                                    </table>



                                </td>



                            </tr>
                            <tr >
                                <td>
                                    <b>
                                        @for ($i=0; $i < 67; $i++)
                                            -
                                        @endfor
                                    </b>
                                </td>
                            </tr>
                           
                            <tr>
                                <td style="font-family:Helvetica,Arial,sans-serif;font-size:11px;line-height:22px;font-weight:400;color:#333;padding-bottom:30px;text-align:left;padding-top: 4px;"
                                >
                                <b>Disclaimer: </b>
                                 The sender of this email is registered with www.zeronoticeperiod.com as {{ Auth::guard('company')->user()->name }} using www.zeronoticeperiod.com services. 
                                 The responsibility of checking the authenticity of offers/correspondence lies with you entirely. 
                                 If you consider the content of this email inappropriate or spam, you may forward this email to: 
                                 info@zeronoticeperiod.com. Please note this email is a private message from the recruiter. 
                                 You are advised not to forward this email to protect your account from unauthorized access.
                                
                                </td>
                            </tr>
                            <tr>
                                <td style="font-family:Helvetica,Arial,sans-serif;font-size:11px;line-height:22px;font-weight:400;color:#333;padding-bottom:30px;text-align:left;padding-top: 4px;"
                                >
                                <b>General Advise :</b>
                                Please do not pay any money to anyone who promises to find you a job. 
                                This could be in any form. The money could be asked for upfront or it could be asked after trust has been built after some communication has been exchanged. 
                                Please ensure you are not being scammed and in case you are suspicious please contact info@zeronoticeperiod.com for advise.
                                </td>
                            </tr>
                        </table>



                    </div>

                    <div class="modal-footer justify-content-end px-3">

                        <button type="button" class="btn btn-secondary py-2 mr-3" id="previewclose">Back</button>



                    </div>



                </div>

            </div>

        </div>



    </div>

    <div class="container">
        <div class="modal newmodalclass" id="previewmodal1" style="overflow-y: auto;">
            <div class="modal-dialog">
                <div class="modal-content mx-auto">
                    <div class="alert alert-danger print-error-msg" style="display:none">
                        <ul></ul>
                    </div>
                    <div class="col-12 pt-3">
                        <div class="row">
                            <div class="col-8">
                                <h4 class="modal-title sign_head">Preview Email</h4>
                            </div>
                            <div class="col-4">
                                <p type="button" class="info" data-dismiss="modal"><img
                                        class="float-right modal_close-icon"
                                        src="{{ asset('/') }}asset/images/close.png"></p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-body">
                        <table border="0" cellpadding="0" cellspacing="0" class="force-row"
                            style="width: 100%;">
                            <tr>
                                <td class="cols-wrapper" style="padding-left:12px;padding-right:12px">
                                    <table border="0" cellpadding="0" cellspacing="0" align="left"
                                        class="force-row" style="width: 100%;">
                                        <tr>
                                            <td class="row" valign="top"
                                                style="padding-left:12px;padding-right:12px;padding-top:18px;padding-bottom:12px">
                                                <table border="0" cellpadding="0" cellspacing="0"
                                                    style="width:100%;">
                                                    <tr>
                                                        <td
                                                            style="font-family:Helvetica,Arial,sans-serif;font-size:14px;line-height:22px;font-weight:400;color:#333;padding-bottom:3px;text-align:left;padding-top: 42px;">
                                                            <b>Subject</b> :<span id="previewsubject1"></span>
                                                        </td>

                                                    </tr>
                                                    <tr>
                                                        <td
                                                            style="font-family:Helvetica,Arial,sans-serif;font-size:14px;line-height:22px;font-weight:400;color:#333;padding-bottom:30px;text-align:left;padding-top: 4px;">
                                                            <b> Message</b> :<p id="previewmessage1" class="summernote">
                                                            </p>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr >
                                <td>
                                    <b>
                                        @for ($i=0; $i < 67; $i++)
                                            -
                                        @endfor
                                    </b>
                                </td>
                            </tr>
                           
                            <tr>
                                <td style="font-family:Helvetica,Arial,sans-serif;font-size:14px;line-height:22px;font-weight:400;color:#333;padding-bottom:30px;text-align:left;padding-top: 4px;"
                                >
                                <b>Disclaimer: </b>
                                 The sender of this email is registered with www.zeronoticeperiod.com as {{ Auth::guard('company')->user()->name }} using www.zeronoticeperiod.com services. 
                                 The responsibility of checking the authenticity of offers/correspondence lies with you entirely. 
                                 If you consider the content of this email inappropriate or spam, you may forward this email to: 
                                 info@zeronoticeperiod.com. Please note this email is a private message from the recruiter. 
                                 You are advised not to forward this email to protect your account from unauthorized access.
                                
                                </td>
                            </tr>
                            <tr>
                                <td style="font-family:Helvetica,Arial,sans-serif;font-size:14px;line-height:22px;font-weight:400;color:#333;padding-bottom:30px;text-align:left;padding-top: 4px;"
                                >
                                <b>General Advise :</b>
                                Please do not pay any money to anyone who promises to find you a job. 
                                This could be in any form. The money could be asked for upfront or it could be asked after trust has been built after some communication has been exchanged. 
                                Please ensure you are not being scammed and in case you are suspicious please contact info@zeronoticeperiod.com for advise.
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div class="modal-footer justify-content-end px-3">
                        <button type="button" class="btn btn-secondary py-2 mr-3" id="previewclose1">Back</button>
                    </div>
                </div>
            </div>
        </div>
    </div>





    {{-- Send Email Modal --}}

    <div class="container">

        <!-- modal -->

        <div class="modal newmodalclass" id="sendemailmodal" style="overflow-y: auto;">

            <div class="modal-dialog">

                <div class="modal-content mx-auto">

                    <!-- header -->

                    <div class="alert alert-danger print-error-msg" style="display:none">

                        <ul></ul>

                    </div>



                    <form method="post" action="" enctype="multipart/form-data">

                        @csrf

                        <div class="col-12 pt-3">

                            <div class="row">

                                <div class="col-8">

                                    <h4 class="modal-title sign_head">Send Email</h4>

                                </div>

                                <div class="col-4">

                                    <p type="button" class="info" data-dismiss="modal"><img
                                            class="float-right modal_close-icon"
                                            src="{{ asset('/') }}asset/images/close.png"></p>

                                </div>

                            </div>

                        </div>

                        <!-- body -->

                        <div class="modal-body">

                            <div class="row">

                                <input type="hidden" value="" name="user_id" id="send_user_id">

                                <input type="hidden" name="templateidsend" id="templateidsend" value="0">

                                @if (count($templates) > 0 && isset($templates))

                                    <div class="col-md-12 pb-2 mb-4">

                                        <select class="form-control" id="templatesend" name="template"
                                            style="width: 175px;background: #e3e3e3;float:right">

                                            <option selected value="">Select Templates</option>

                                            @foreach ($templates as $template)
                                                <option value="{{ $template->id }}">{{ $template->templatename }}
                                                </option>
                                            @endforeach

                                        </select>

                                        {{-- <span class="text-danger">

                                                <strong id="template-error-sec" class="new_error_class template-error"></strong>

                                            </span> --}}

                                    </div>
                                @else
                                    <div class="col-md-12 pb-2 mb-4">

                                        <select class="form-control" style="width: 175px;background: #e3e3e3;float:right">

                                            <option selected disabled>No Templates</option>

                                        </select>

                                    </div>





                                @endif

                                <div class="col-md-12 pb-2">

                                    <textarea class="form-control" placeholder="Subject" aria-label="With textarea" id="email-subject"
                                        name="email-subject" rows="1"></textarea>

                                    <span class="text-danger">

                                        <strong id="email-subject-error" class="new_error_class"></strong>

                                    </span>

                                </div>

                                <div class="col-md-12 pb-2">

                                    <textarea class="form-control summernote" placeholder="Message" name="email-message" id="email-message"
                                        aria-label="With textarea" rows="3"></textarea>

                                    <span class="text-danger">

                                        <strong id="email-message-error" class="new_error_class"></strong>

                                    </span>

                                </div>



                                <div class="col-md-12 pb-2 mt-5">

                                    <label>Save Template <span class="text-danger">*</span></label>

                                    <a href="{{ url('email-templates') }}" target="_blank"
                                        style="float: right;margin-right: 10px;">Edit</a>

                                    <input class="form-control" placeholder="Template Name" id="sendname"
                                        name="name" rows="1">

                                    <span class="text-danger">

                                        <strong id="templatesend-error-sec" class="new_error_class name-error"></strong>

                                    </span>
                                    <span class="text-danger">

                                        <strong id="sendname-error" class="new_error_class name-error"></strong>

                                    </span>


                                </div>





                            </div>

                        </div>

                        <div class="modal-footer justify-content-end px-3">

                            <button type="button" class="btn btn-secondary py-2 mr-3"
                                data-dismiss="modal">Cancel</button>

                            <button type="button" id="preview1"
                                class="signin_button px-4 py-2 emailsend rounded">Preview</button>

                            <button type="button" id="sendformSubmit"
                                class="signin_button px-4 py-2 emailsend rounded">Send</button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>





    <div class="container">



        <!--add to folder modal -->



        <div class="modal" id="addfoldermodal" style="overflow-y: auto;">



            <div class="modal-dialog">



                <div class="modal-content mx-auto">



                    <!-- header -->







                    <div class="modal-header pb-0">



                        <h4 class="modal-title sign_head">Select Add Folder</h4>



                        <p type="button" class="info" data-dismiss="modal"><img class="float-right modal_close-icon"
                                src="{{ asset('/') }}asset/images/close.png"></p>



                    </div>







                    <form method="POST" action="" enctype="multipart/form-data" id="add_folder_form">







                        <div class="modal-body">



                            <span class="help-block user_id1-error"></span>



                            <div class="collection_pic-box text-center mt-4 mt-md-0">



                                <div class="collection_text p-5">



                                    <input type="hidden" name="user_id1[]" id="user_id1" value="">







                                    <select name="collection_id" id="collection_id" class="form-control">



                                        <option value="" selected disabled>Select Folder</option>







                                        @foreach ($collections as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach







                                    </select>



                                    <span class="help-block collection_id-error"></span>



                                    <div class="error_message1 " id=""></div>



                                </div>



                            </div>



                        </div>



                        <div class="modal-footer justify-content-end px-3">



                            <a href="{{ url('collections') }}" class="signin_button px-4 py-2 rounded">Create

                                Folder</a>



                            <button type="button" id="form_Submit1" class="signin_button px-4 py-2 rounded">Add

                                Folder</button>



                            <button type="button" class="btn btn-secondary py-2 mr-3"
                                data-dismiss="modal">Cancel</button>



                        </div>



                    </form>

                    <!--





                                                <div class="text-center p-3">



                                                    <a class="btn signin_button" href="">Create Folder</a>



                                                </div>







                                            -->

                </div>



            </div>



        </div>



    </div>



    <!-- modal end -->





    <!--sms modal Start-->

    <div class="container">

        <!-- modal -->

        <div class="modal newmodalclass" id="smsmodal" >

            <div class="modal-dialog">

                <div class="modal-content mx-auto">

                    <!-- header -->

                    <div class="alert alert-danger print-error-msg" style="display:none">

                        <ul></ul>

                    </div>



                    <form method="post" action="" enctype="multipart/form-data">

                        @csrf

                        <div class="col-12 pt-3">



                            <div class="row">

                                <div class="col-8">

                                    <h4 class="modal-title sign_head">Send SMS</h4>

                                </div>

                                <div class="col-4">

                                    <p type="button" class="info" data-dismiss="modal"><img
                                            class="float-right modal_close-icon"
                                            src="{{ asset('/') }}asset/images/close.png"></p>

                                </div>

                            </div>

                        </div>

                        <!-- body -->

                        <div class="modal-body">

                            <span class="help-block user_id-error"></span>

                            <div class="row">

                                <input type="hidden" value="" name="sms_user_id" id="sms_user_id">

                                <?php
                                
                                ?>



                                <div class="col-md-12 pb-2">

                                    <textarea class="form-control" placeholder="Message" name="message" id="message" aria-label="With textarea"
                                        rows="3">Hi. I found your resume on ZeroNoticePeriod.com. I tried calling you about a Job Opening. Please call +91-00000-00000 </textarea>



                                    <span class="help-block message-error"></span>



                                    <span class="text-danger">

                                        <strong id="message-error" class="new_error_class"></strong>

                                    </span>

                                </div>

                            </div>

                        </div>

                        <div class="modal-footer justify-content-end px-3">

                            <button type="button" class="btn btn-secondary py-2 mr-3"
                                data-dismiss="modal">Cancel</button>

                            <button type="button" id="sms_form_submit"
                                class="signin_button px-4 py-2 emailsend rounded">Send</button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>





    <!--cv Search Plan Expire modal -->

    <div class="container">


        <div class="modal" id="PlanExpire">

            <div class="modal-dialog modal-dialog-centered">

                <div class="modal-content modal_content_custom_width mx-auto p-3">

                    <p type="button" class="info mb-0" data-dismiss="modal"><img class="float-right modal_close-icon"
                            src="{{ asset('/') }}asset/images/close.png"></p>

                    <div class="modal-body py-0">

                        <div class="collection_pic-box text-center mt-2 mt-md-0">

                            <div class="collection_text px-lg-3 py-0">

                                {{-- <h3 class="line_change font_size">Alert!</h3> --}}

                                <!--<p class="fs-18 mb-1">"You have used your quota of 10 searches with a Free-->

                                <!--    account. Please purchase the Subscription to find talent FASTER!".</p>-->


                                <p class="fs-18 mb-1">Please purchase the Subscription to find talent FASTER!</p>


                                <a href="{{ route('pricing') }}" class="btn btn-plan buy_now"
                                    style="
                                        background-color: #0642a9;
                                        color: white;
                                    ">Buy
                                    now</a>

                                <div class="error_message1 " id=""></div>

                            </div>

                        </div>

                    </div>



                </div>

            </div>

        </div>

    </div>
    <div class="container">

        <div class="modal" id="recorded_video">

            <div class="modal-dialog modal-dialog-centered">

                <div class="modal-content modal_content_custom_width mx-auto p-3">

                    <p type="button" class="info mb-0" data-dismiss="modal"><img class="float-right modal_close-icon"
                            src="{{ asset('/') }}asset/images/close.png"></p>

                    <div class="modal-body py-0">

                        <div class="collection_pic-box text-center mt-2 mt-md-0">

                            <div class="collection_text pr-lg-3 py-0">

                                <h5 style="color: #197ff3;font-family: 'proximanova-bold';">
                                    Recorded Video Interview</h5>

                                <video width="400px" height="400px" controls id="videoElement">

                                </video>

                            </div>

                        </div>

                    </div>



                </div>

            </div>

        </div>

    </div>

    <div class="container">

        <div class="modal" id="kyc">

            <div class="modal-dialog modal-dialog-centered">

                <div class="modal-content modal_content_custom_width mx-auto p-3">

                    <p type="button" class="info mb-0" data-dismiss="modal"><img class="float-right modal_close-icon"
                            src="{{ asset('/') }}asset/images/close.png"></p>

                    <div class="modal-body py-0">

                        <div class="collection_pic-box text-center mt-2 mt-md-0">

                            <div class="collection_text px-lg-3 py-0">

                                {{-- <h3 class="line_change font_size">Alert!</h3> --}}

                                <!--<p class="fs-18 mb-1">"You have used your quota of 10 searches with a Free-->

                                <!--    account. Please purchase the Subscription to find talent FASTER!".</p>-->


                                <p class="fs-18 mb-1">Please share KYC documents to continue. Email: <a
                                        href="mailto:employer@zeronoticeperiod.com"
                                        target="_blank">employer@zeronoticeperiod.com</p>

                                <div class="error_message1 " id=""></div>

                            </div>

                        </div>

                    </div>



                </div>

            </div>

        </div>

    </div>

    <div class="container">

        <div class="modal" id="alertmodal">

            <div class="modal-dialog modal-dialog-centered">

                <div class="modal-content modal_content_custom_width mx-auto p-3">

                    <p type="button" class="info mb-0" data-dismiss="modal"><img class="float-right modal_close-icon"
                            src="{{ asset('/') }}asset/images/close.png"></p>

                    <div class="modal-body py-0">

                        <div class="collection_pic-box text-center mt-2 mt-md-0">

                            <div class="collection_text px-lg-3 py-0">

                                {{-- <h3 class="line_change font_size">Alert!</h3> --}}

                                <!--<p class="fs-18 mb-1">"You have used your quota of 10 searches with a Free-->

                                <!--    account. Please purchase the Subscription to find talent FASTER!".</p>-->


                                <p class="fs-18 mb-1">Please purchase the Subscription to find talent FASTER!</p>


                                <a href="{{ route('pricing') }}" class="btn btn-plan buy_now "
                                    style="
                                        background-color: #0642a9;
                                        color: white;
                                    ">Buy
                                    now</a>

                                <div class="error_message1 " id=""></div>

                            </div>

                        </div>

                    </div>



                </div>

            </div>

        </div>

    </div>


    <!--sms-send modal Start-->

    <div class="container">

        <!-- modal -->

        <div class="modal newmodalclass" id="sendsmsmodal">

            <div class="modal-dialog">

                <div class="modal-content mx-auto">

                    <!-- header -->

                    <div class="alert alert-danger print-error-msg" style="display:none">

                        <ul></ul>

                    </div>



                    <form method="post" action="" enctype="multipart/form-data">

                        @csrf

                        <div class="col-12 pt-3">



                            <div class="row">

                                <div class="col-8">

                                    <h4 class="modal-title sign_head">Send SMS</h4>

                                </div>

                                <div class="col-4">

                                    <p type="button" class="info" data-dismiss="modal"><img
                                            class="float-right modal_close-icon"
                                            src="{{ asset('/') }}asset/images/close.png"></p>

                                </div>

                            </div>

                        </div>

                        <!-- body -->

                        <div class="modal-body">

                            <span class="help-block sms_user_id-error"></span>

                            <div class="row">



                                <input type="hidden" value="" name="send_sms_userid" id="send_sms_userid">



                                <div class="col-md-12 pb-2">

                                    <textarea class="form-control" placeholder="Message" name="sendmessage" id="sendmessage" aria-label="With textarea"
                                        value="terst" rows="3">Hi. I found your resume on ZeroNoticePeriod.com. I tried calling you about a Job Opening. Please call +91-00000-00000</textarea>



                                    <span class="help-block sendmessage-error"></span>

                                    <span class="text-danger">

                                        <strong id="sendmessage-error" class="new_error_class"></strong>

                                    </span>

                                </div>

                            </div>

                        </div>

                        <div class="modal-footer justify-content-end px-3">

                            <button type="button" class="btn btn-secondary py-2 mr-3"
                                data-dismiss="modal">Cancel</button>

                            <button type="button" id="send_sms_formsubmit"
                                class="signin_button px-4 py-2 emailsend rounded">Send</button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

    <div class="modal fade" id="rendermodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">

        <div class="modal-dialog" role="document">

            <div class="modal-content">

                <div class="modal-header">

                    <div class="d-flex justify-content-between col-11">
                        <h5 class="modal-title pt-3" id="exampleModalCenterTitle">Preview </h5> <a
                            href="javascript:;" id="pdfLink"
                             style="color: white" target="_blank"
                            class="py-2 signin_button rounded px-2 px-sm-3 mr-1 mr-sm-3">Download Resume</a>
                    </div>



                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                        <span aria-hidden="true"><img class="float-right modal_close-icon"
                                src="{{ asset('/') }}asset/images/close.png"></span>

                    </button>

                </div>

                <div class="modal-body">

                    <div id="pdf_container">

                    </div>

                </div>



            </div>

        </div>

    </div>

    <div class="modal fade" id="docrendermodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">

        <div class="modal-dialog" role="document">

            <div class="modal-content">

                <div class="modal-header">

                    <div class="d-flex justify-content-between col-11">
                        <h5 class="modal-title pt-3" id="exampleModalCenterTitle">Preview </h5>
                        <a href="javascript:;" id="docLink" style="color: white" target="_blank"
                            class="py-2 signin_button rounded px-2 px-sm-3 mr-1 mr-sm-3">
                            Download Resume
                        </a>
                    </div>



                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                        <span aria-hidden="true"><img class="float-right modal_close-icon"
                                src="{{ asset('/') }}asset/images/close.png"></span>

                    </button>

                </div>

                <div class="modal-body">

                    <div id="word-container" class=""></div>

                </div>



            </div>

        </div>

    </div>

    @push('styles')
        <style type="text/css">
            .formrow iframe {



                height: 78px;



            }
        </style>
    @endpush



    <script src="https://cdnjs.cloudflare.com/ajax/libs/tagify/4.32.1/tagify.min.js"></script>
    
    <script>
        
        function PreviewWordDoc(docurl,id) {
            $.ajax({
                url: "{{ url('click-profile') }}/"+id,
                type:"get",
                dataType: "json",
                data: {
                    id: id
                },
                success: function(data) {
                    if(data.status){
                        
                    $('#docrendermodal').modal('show');
                    $("#docLink").attr('href',"{{ url('download-candidate-resum/') }}/"+id+"");
                    

                    //Send a XmlHttpRequest to the URL.

                    var request = new XMLHttpRequest();

                    request.open('GET', docurl, true);

                    request.responseType = 'blob';

                    request.onload = function() {

                        //Set the ContentType to docx.

                        var contentType = "application/vnd.openxmlformats-officedocument.wordprocessingml.document";



                        //Convert BLOB to File object.

                        var doc = new File([request.response], contentType);



                        //If Document not NULL, render it.

                        if (doc != null) {

                            //Set the Document options.

                            var docxOptions = Object.assign(docx.defaultOptions, {

                                useMathMLPolyfill: true

                            });

                            //Reference the Container DIV.

                            var container = document.querySelector("#word-container");



                            //Render the Word Document.

                            docx.renderAsync(doc, container, null, docxOptions);

                        }



                    };

                    request.send();
                    }else{
                        alert(data.msg);
                        $("#errormsg1").html(
                            "<div class='alert alert-danger education_style'>"+data.msg+"</div>"
                            );

                        setTimeout(function() {
                            $(".success_msg26").hide();
                        }, 5000);
                    }
                }
            });

        };

        var input = document.querySelector('#skillsData');

        // initialize Tagify on the above input node reference
        
        var tagify = new Tagify(input, {
            whitelist: [], // Initially empty, populated via AJAX
            maxTags: 5,    // Limit the maximum number of tags
            dropdown: {
                position: 'text', // Dropdown will appear next to the input text
                enabled: 0,       // Show suggestions as soon as the user types
                maxItems: 10      // Limit the number of suggestions
            }
        });
        
        var input2 = document.querySelector('#tags');

        // initialize Tagify on the above input node reference
        
        var tagify2 = new Tagify(input2, {
            whitelist: [], // Initially empty, populated via AJAX
            maxTags: 3,    // Limit the maximum number of tags
            dropdown: {
                position: 'text', // Dropdown will appear next to the input text
                enabled: 0,       // Show suggestions as soon as the user types
                maxItems: 10      // Limit the number of suggestions
            }
        });
        document.addEventListener("keydown", function(event) {
            const items = document.querySelectorAll(".ui-menu-item");
            const activeIndex = Array.from(items).findIndex(item => item.classList.contains("active"));

            if (event.key === "ArrowDown") {
                event.preventDefault(); // Prevent default scrolling behavior

                if (activeIndex !== -1) {
                    items[activeIndex].classList.remove("active");
                    const newIndex = (activeIndex + 1) % items.length;
                    items[newIndex].classList.add("active");
                } else {
                    items[0].classList.add("active");
                }
            } else if (event.key === "ArrowUp") {
                event.preventDefault(); // Prevent default scrolling behavior

                if (activeIndex !== -1) {
                    items[activeIndex].classList.remove("active");
                    const newIndex = (activeIndex - 1 + items.length) % items.length;
                    items[newIndex].classList.add("active");
                } else {
                    items[items.length - 1].classList.add("active");
                }
            }
        });




        $(function() {
            function split(val) {
                return val.split(/,\s*/);
            }

            function extractLast(term) {
                console.log("Search Keywords:", term);
                return split(term).pop();
            }

            // Fetch suggestions dynamically from the server
            tagify2.on('input', function(e) {
                var value = e.detail.value;

                // AJAX request to fetch suggestions
                $.ajax({
                    url: "{{ url('autocomplete/cvlocations') }}",
                    dataType: "json",
                    data: {
                        query: value
                    },
                    success: function(data) {
                        // Update the whitelist with the fetched data
                        tagify2.settings.whitelist = data;

                        // Show the dropdown suggestions
                        tagify2.dropdown.show(value);
                    }
                });
            });
            // $("#tags")
            //     .on("keydown", function(event) {
            //         if (event.keyCode === $.ui.keyCode.TAB && $(this).autocomplete("instance").menu.active) {
            //             event.preventDefault();
            //         }
            //     })
            //     .on("input", function() {
            //         this.value = this.value.replace(/[^\w\s,\/]/gi, '');
            //     })
            //     .autocomplete({
            //         minLength: 0,
            //         source: function(request, response) {
            //             $.ajax({
            //                 url: "{{ url('autocomplete/cvlocations') }}",
            //                 dataType: "json",
            //                 data: {
            //                     query: extractLast(request.term)
            //                 },
            //                 success: function(data) {
            //                     response($.map(data, function(item) {
            //                         return {
            //                             label: item,
            //                             value: item
            //                         };
            //                     }));
            //                 }
            //             });
            //         },
            //         focus: function() {
            //             return false;
            //         },
            //         select: function(event, ui) {
            //             var terms = split(this.value);
            //             terms.pop();
            //             terms.push(ui.item.value);
            //             terms.push("");
            //             this.value = terms.join(", ");

            //             // Trigger typing after a value is selected

            //             document.getElementById("tags").blur()
            //             document.getElementById("tags").focus()


            //             return false;
            //         },
            //         open: function(event, ui) {
            //             var term = extractLast(this.value);
            //             var autocomplete = $(this).data("ui-autocomplete");
            //             autocomplete.menu.element.find("li").each(function() {
            //                 var item = $(this).data("ui-autocomplete-item");
            //                 var highlightedItem = item.label.replace(new RegExp($.ui.autocomplete
            //                         .escapeRegex(term), "gi"),
            //                     '<span class="highlight">$&</span>');
            //                 $(this).html(highlightedItem);
            //             });
            //         }



            // });
            document.querySelector('#filter1').addEventListener('submit', function(event) {
                // Convert the Tagify values into a comma-separated string
                var tagData = tagify.value.map(item => item.value).join(', ');

                // Update the input value
                input.value = tagData;
                
                var tagData2 = tagify2.value.map(item => item.value).join(', ');

                // Update the input value
                input2.value = tagData2;
            });
            // Fetch suggestions dynamically from the server
            tagify.on('input', function(e) {
                var value = e.detail.value;

                // AJAX request to fetch suggestions
                $.ajax({
                    url: "{{ route('cvskills') }}",
                    dataType: "json",
                    data: {
                        query: value
                    },
                    success: function(data) {
                        // Update the whitelist with the fetched data
                        tagify.settings.whitelist = data;

                        // Show the dropdown suggestions
                        tagify.dropdown.show(value);
                    }
                });
            });

            // Clean the input to prevent invalid characters
            tagify.on('input', function(e) {
                var cleanValue = e.detail.value.replace(/[^\w\s,\/]/gi, '');
                tagify.input.value = cleanValue;
            });
            // $("#skillsData")
            //     .on("keydown", function(event) {
            //         if (event.keyCode === $.ui.keyCode.TAB && $(this).autocomplete("instance").menu.active) {
            //             event.preventDefault();
            //         }
            //     })
            //     .on("input", function() {
            //         this.value = this.value.replace(/[^\w\s,\/]/gi, '');
            //     })
            //     .autocomplete({
            //         minLength: 0,
            //         source: function(request, response) {
            //             $.ajax({
            //                 url: "{{ route('cvskills') }}",
            //                 dataType: "json",
            //                 data: {
            //                     query: extractLast(request.term)
            //                 },
            //                 success: function(data) {
            //                     response($.map(data, function(item) {
            //                         return {
            //                             label: item,
            //                             value: item
            //                         };
            //                     }));
            //                 }
            //             });
            //         },
            //         focus: function() {
            //             return false;
            //         },
            //         select: function(event, ui) {
            //             var terms = split(this.value);
            //             terms.pop();
            //             terms.push(ui.item.value);
            //             terms.push("");
            //             this.value = terms.join(", ");

            //             // Trigger typing after a value is selected

            //             document.getElementById("skillsData").blur()
            //             document.getElementById("skillsData").focus()


            //             return false;
            //         },
            //         open: function(event, ui) {
            //             var term = extractLast(this.value);
            //             var autocomplete = $(this).data("ui-autocomplete");
            //             autocomplete.menu.element.find("li").each(function() {
            //                 var item = $(this).data("ui-autocomplete-item");
            //                 var highlightedItem = item.label.replace(new RegExp($.ui.autocomplete
            //                         .escapeRegex(term), "gi"),
            //                     '<span class="highlight">$&</span>');
            //                 $(this).html(highlightedItem);
            //             });
            //         }



            // });






            $("#locationFilter3")
                .on("keydown", function(event) {
                    if (event.keyCode === $.ui.keyCode.TAB && $(this).autocomplete("instance").menu.active) {
                        event.preventDefault();
                    }
                })
                .on("input", function() {
                    this.value = this.value.replace(/[^\w\s,]/gi, '');
                })
                .autocomplete({
                    minLength: 0,
                    source: function(request, response) {
                        $.ajax({
                            url: "{{ url('autocomplete/search-location-job1') }}",
                            dataType: "json",
                            data: {
                                query: request.term
                            },
                            success: function(data) {
                                response($.map(data, function(item) {
                                    return {
                                        label: item,
                                        value: item
                                    };
                                }));
                            }
                        });
                    },
                    focus: function() {
                        return false;
                    },
                    select: function(event, ui) {
                        this.value = ui.item.value;
                        return false;
                    },
                    open: function(event, ui) {
                        var term = this.value;
                        var autocomplete = $(this).data("ui-autocomplete");
                        autocomplete.menu.element.find("li").each(function() {
                            var item = $(this).data("ui-autocomplete-item");
                            var highlightedItem = item.label.replace(new RegExp($.ui.autocomplete
                                    .escapeRegex(term), "gi"),
                                '<span class="highlight">$&</span>');
                            $(this).html(highlightedItem);
                        });
                    }
                });



        });

        function recordedmodal(id) {

            $dta = $('.modalid' + id).val();



            var dta = $('.modalid' + id).val();
            $('#videoElement').replaceWith(
                '<video id="videoElement" width="400px" height="400px" controlsList="nodownload" controls><source src="' +
                dta + '" type="video/mp4"></video>');
            $('#recorded_video').modal({
                backdrop: 'static'
            });
            $('#recorded_video').modal('show');
        }




        $(document).ready(function() {
            $('textarea.summernote').summernote({
                placeholder: 'Write Your Message',
                tabsize: 2,
                height: 300,
                toolbar: [
                    ['font', ['bold', 'italic', 'underline', 'clear']],
                    ['para', ['ul', 'ol', 'paragraph']],
                ],
                callbacks: {
                    onPaste: function(e) {
                        var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData)
                            .getData('Text');
                        e.preventDefault();
                        document.execCommand('insertText', false, bufferText);
                    }
                }
            });




            @if (isset($locations_vals))
                // Set the selected values for jQuery UI Autocomplete
                // Note: You may need to adjust this based on how the jQuery UI Autocomplete handles setting values.
                $('#search_data').val({!! json_encode($selected) !!});
            @endif



        });
    </script>




    <script>
        var msg = '{{ Session::get('
        
                alert ') }}';



        var exist = '{{ Session::has('
        
                alert ') }}';



        if (exist) {



            // $('#show_alert').hide();







            $('#success_id102').html('<p class="alert alert-info">' + msg + '</p>');

            setTimeout(function() {

                $(".homealert1").hide();

            }, 5000);



        }



        $.ajaxSetup({



            headers: {



                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')



            }



        });



        $('.dynamic').change(function() {



            var degree_id = $(this).val();















            if (degree_id) {







                $.ajax({



                    type: "POST",



                    url: "{{ url('gety') }}",



                    _token: '{{ csrf_token() }}',



                    data: {



                        degree: degree_id,



                    },



                    dataType: "json",







                    success: function(res) {



                        if (res) {



                            $(".dynamiccourse").empty();



                            $(".dynamiccourse").append('<option>Select course</option>');

                            $("#newcourse123 option:first").attr("disabled", "disabled");



                            $.each(res, function(key, value) {



                                $(".dynamiccourse").append('<option value="' + value.id + '">' +

                                    value.course + '</option>');



                            });







                        } else {



                            $(".dynamiccourse").empty();



                        }



                    }



                });



            } else {



                // alert('error');



                // $(".dynamiccourse").empty();



                //$(".dynamicspecs").empty();



            }



        });



        $('#multiple-select-notice').multiselect({

            includeSelectAllOption: false,

            nonSelectedText: 'Notice Period',

            numberDisplayed: 2,

        }); 
        
        $('.multiselect').removeAttr('title');
        
        $('#multiple-select-notice').on('change',function(){
            setTimeout(function () {
               $('.multiselect').removeAttr('title');
            }, 500);
          
        });






        function getSelectedValues() {

            var selectedVal = $("#multiple-select-notice").val();

            for (var i = 0; i < selectedVal.length; i++) {

                function innerFunc(i) {

                    setTimeout(function() {

                        location.href = selectedVal[i];

                    }, i * 2000);

                }

                innerFunc(i);

            }

        }



        function show() {



        }



        $('#multiple-select-notice-responsive').multiselect({

            includeSelectAllOption: false,

            nonSelectedText: 'Choose by Notice Periods',

        });



        function getSelectedValues() {

            var selectedVal = $("#multiple-select-notice-responsive").val();

            for (var i = 0; i < selectedVal.length; i++) {

                function innerFunc(i) {

                    setTimeout(function() {

                        location.href = selectedVal[i];

                    }, i * 2000);

                }

                innerFunc(i);

            }
        }
      
        // let elements = document.getElementsByClassName("dropdown-toggle");
        // for (var i = 0; i < elements.length; i++){
        //     elements[i].title = ""
        // }













        $('.dynamiccourse').on('change', function() {







            var course_id = $(this).val();







            if (course_id) {



                $.ajax({



                    type: "POST",



                    url: "{{ url('getspecs') }}",



                    _token: '{{ csrf_token() }}',



                    data: {



                        course: course_id,



                    },



                    dataType: "json",



                    success: function(res) {



                        if (res) {



                            $(".dynamicspecs").empty();



                            $(".dynamicspecs").append('<option>Select Specilization</option>');





                            $("#specs123 option:first").attr("disabled", "disabled");



                            $.each(res, function(key, value) {



                                $(".dynamicspecs").append('<option value="' + value.id + '">' +

                                    value.specs + '</option>');



                            });







                        } else {



                            $(".dynamicspecs").empty();



                        }



                    }



                });



            } else {



                $(".dynamicspecs").empty();



            }







        });







        var base_url = '{{ URL::to('') }}';



        $(document).ready(function() {







            $(".email_checkbox").click(function() {







                var array = new Array();



                // var checked = $(".email_checkbox:checked").length;



                var checkbox = $(".email_checkbox:checked");



                if (checkbox) {



                    var check = checkbox.map(function() {



                        // check1= $(this).val();



                        array.push($(this).val());



                    });



                }



                $("#user_id").val(array);

                $("#user_id1").val(array);

                $("#sms_user_id").val(array);


                var selectedCount = array.length;
                console.log('Selected checkboxes count: ' + selectedCount);

                // Append selected count inside span tag
                var spanText = '(' + selectedCount + ')';
                $("#selected_count").text(spanText);



            });







            $("#select_all").click(function(event) {
                var array1 = [];

                var checkbox = $(".email_checkbox");

                if (checkbox.is(':checked')) {
                    checkbox.each(function() {
                        if ($(this).is(':checked')) {
                            array1.push($(this).val());
                        }
                    });
                } else {
                    array1 = [];
                }

                $("#user_id").val(array1);
                $("#user_id1").val(array1);
                $("#sms_user_id").val(array1);

                var selectedCount = array1.length;
                console.log('Selected checkboxes count: ' + selectedCount);

                // Append selected count inside span tag
                var spanText = '(' + selectedCount + ')';
                $("#selected_count").text(spanText);



            });




        });







        $('#form_Submit').click(function(e) {



            document.getElementById('form_Submit').innerHTML = 'Sending..';

            var template_id = $("#template").val();

            e.preventDefault();



            $('#user_id-error').html("");

            $('#name-error').html("");

            $('#subject-error').html("");

            $('#template-error-sec-error').html("");

            $('#mail_user_id-error').html("");

            $('#description-error').html("");

            $.ajaxSetup({

                headers: {

                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')

                }

            });

            $.ajax({

                url: "{{ route('email.sendbulkemail') }}",

                method: 'POST',

                data: {

                    user_id: $('#user_id').val(),

                    _token: "{{ csrf_token() }}",

                    name: $('#name').val(),

                    subject: $('#subject').val(),

                    template: template_id,

                    description: $('#description').val(),

                },

                success: function(result) {

                    console.log(result);

                    document.getElementById('form_Submit').innerHTML = 'Send';

                    if (result.success) {

                        $('.alert-danger').hide();

                        $('#emailmodal').modal('hide');

                        $("#myElem").show();

                        $('#user_id').val('');

                        // $('#template').val('');

                        $('#name').val('');

                        $('#subject').val('');

                        $('#templateid').val('');

                        $("#description").summernote('code', '');

                        setTimeout(function() {
                            $("#myElem").hide();
                        }, 5000);



                        $('#template option:contains("Select Templates")').prop('selected', true);





                        var checkbox = $(".email_checkbox");

                        var selectall = $("#select_all");



                        $('input[type=checkbox]').each(

                            function(index, checkbox) {

                                if (index != 0) {

                                    checkbox.checked = false;

                                }

                            });





                    }

                    if (result.errors)

                    {

                        // alert(result.errors.user_id[0]);

                        document.getElementById('form_Submit').innerHTML = 'Send'

                        // console.log(result.errors);



                        if (result.errors.user_id) {



                            $('#mail_user_id-error').html(result.errors.user_id[0]);

                        }

                        if (result.errors.subject) {

                            $('#subject-error').html(result.errors.subject[0]);

                        }

                        if (result.errors.template) {

                            $('#template-error-sec').html(result.errors.template[0]);

                        }

                        if (result.errors.name) {

                            $('#name-error').html(result.errors.name[0]);

                        }

                        if (result.errors.description) {

                            $('#description-error').html(result.errors.description[0]);

                        }



                    }
                    if (result.errors1) {



                        alert(result.errors1);



                    }
                    if (result.errors2) {

                        $('#emailmodal').modal('hide');
                        $('#kyc').modal('show');

                    }

                },



            });

        });



        $('#sendformSubmit').click(function(e) {

            $('.alert-danger').hide();



            $('#sendname-error').html("");

            $('#email-subject-error').html("");

            $('#email-message-error').html("");

            $('#templatesend-error-sec').html("");



            var user_id = $("#send_user_id").val();

            document.getElementById('sendformSubmit').innerHTML = 'Sending..';

            //   e.preventDefault();

            var template_id = $("#templatesend").val();



            $.ajaxSetup({

                headers: {

                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')

                }

            });

            $.ajax({

                url: "{{ route('emails.store') }}",

                method: 'post',

                data: {

                    id: user_id,

                    _token: "{{ csrf_token() }}",

                    subject: $('#email-subject').val(),

                    message: $('#email-message').val(),

                    template: template_id,

                    name: $('#sendname').val(),

                },

                success: function(result) {

                    // console.log(result);

                    if (result.success) {



                        $('.alert-danger').hide();

                        $('#sendsmsmodal').modal('hide');

                        $("#myElem").show();

                        $('#email-subject').val('');

                        $('#email-subject').val('');

                        $('#sendname').val('');

                        $('#email-subject-error').val('');

                        $('#email-message-error').val('');

                        $("#email-message").summernote('code', '');

                        $('#templatesend-error-sec').val("");

                        $('#templateidsend').val('');

                        document.getElementById('sendformSubmit').innerHTML = 'Send';

                        setTimeout(function() {
                            $("#myElem").hide();
                        }, 5000);

                        $('#sendemailmodal').modal('hide');
                        location.reload();

                    }

                    if (result.errors)

                    {

                        document.getElementById('sendformSubmit').innerHTML = 'Send';



                        if (result.errors.subject) {

                            $('#email-subject-error').html(result.errors.subject[0]);

                        }


                        if (result.errors.template) {

                            $('#templatesend-error-sec').html(result.errors.template[0]);

                        }

                        if (result.errors.name) {

                            $('#sendname-error').html(result.errors.name[0]);

                        }

                        if (result.errors.message) {

                            $('#email-message-error').html(result.errors.message[0]);

                        }





                    }
                    if (result.errors1)

                    {

                        document.getElementById('sendformSubmit').innerHTML = 'Send';

                        if (result.errors1) {

                            alert(result.errors1);

                        }
                         location.reload();

                    }



                }

            });

        });











        $('#form_Submit1').click(function(e) {

            //    alert('test');

            // document.getElementById("overlay").style.display = "block";



            document.getElementById('form_Submit1').innerHTML = 'Sending..';



            // document.getElementsByClassName('names')



            e.preventDefault();



            //    $( '#description-error' ).html( "" );

            $.ajaxSetup({

                headers: {

                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')

                }

            });

            $.ajax({

                url: "{{ url('add_bulkresumes') }}",

                method: 'POST',

                data: {

                    user_id1: $('#user_id1').val(),

                    _token: "{{ csrf_token() }}",

                    collection_id: $('#collection_id').val(),



                },

                success: function(result) {

                    console.log(result);

                    if (result.success) {

                        $('.alert-danger').hide();

                        $('#addfoldermodal').modal('hide');

                        // $("#success_msg27").show();

                        $('#user_id').val('');

                        $('#collection_id').val('');



                        $(".success_msg27").html(
                            "<div class='alert alert-success education_style'>{{ __('Resume added successfully') }}</div>"
                            );

                        setTimeout(function() {
                            $(".success_msg27").hide();
                        }, 5000);



                    }



                },

                error: function(json) {





                    if (json.status == 422) {





                        var resJSON = json.responseJSON;



                        $('.help-block').html('');



                        $.each(resJSON.errors, function(key, value) {



                            $('.' + key + '-error').html('<strong class="new_error_class">' +
                                value + '</strong>');



                            $('#div_' + key).addClass('has-error');



                        });



                    }



                    if (json.status == 402) {



                        // alert('error');

                        //alert('error');



                        $(".error_message1").html(
                            "<div class='alert alert-danger education_style'>{{ __('The Maximum Folder Size is 100') }}</div>"
                            );

                    }



                }

            });

        });





        $('#sms_form_submit').click(function(e) {





            document.getElementById('sms_form_submit').innerHTML = 'Sending..';







            e.preventDefault();

            $('#sms_user_id-error').html("");

            $('#message-error').html("");

            $.ajaxSetup({

                headers: {

                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')

                }

            });

            $.ajax({

                url: "{{ route('bulk-sms-send') }}",

                method: 'POST',

                data: {

                    user_id: $('#sms_user_id').val(),

                    _token: "{{ csrf_token() }}",

                    message: $('#message').val(),

                },

                success: function(result) {

                    console.log(result);

                    if (result.success) {

                        $('.alert-danger').hide();

                        $('#smsmodal').modal('hide');

                        $('#sms_user_id').val('');

                        $('#message').val('');

                        $(".success_msg26").html(
                            "<div class='alert alert-success education_style'>{{ __('SMS Send Successfully') }}</div>"
                            );

                        setTimeout(function() {
                            $(".success_msg26").hide();
                        }, 5000);

                    }



                },

                error: function(json) {





                    if (json.status == 422) {





                        var resJSON = json.responseJSON;



                        $('.help-block').html('');



                        $.each(resJSON.errors, function(key, value) {



                            $('.' + key + '-error').html('<strong class="new_error_class">' +
                                value + '</strong>');



                            $('#div_' + key).addClass('has-error');



                        });



                    }

                }



            });

        });





        $('#send_sms_formsubmit').click(function(e) {





            document.getElementById('send_sms_formsubmit').innerHTML = 'Sending..';







            e.preventDefault();

            $('#send_sms_userid-error').html("");

            $('#sendmessage-error').html("");

            $.ajaxSetup({

                headers: {

                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')

                }

            });

            $.ajax({

                url: "{{ route('bulk-sms-send') }}",

                method: 'POST',

                data: {

                    user_id: $('#send_sms_userid').val(),

                    _token: "{{ csrf_token() }}",

                    message: $('#sendmessage').val(),

                },

                success: function(result) {

                    console.log(result);

                    if (result.success) {

                        $('.alert-danger').hide();

                        $('#smsmodal').modal('hide');

                        $('#send_sms_userid').val('');

                        $('#sendmessage').val('');

                        document.getElementById('send_sms_formsubmit').innerHTML = 'Send';

                        $(".success_msg26").html(
                            "<div class='alert alert-success education_style'>{{ __('SMS Sended Successfully') }}</div>"
                            );

                        setTimeout(function() {
                            $(".success_msg26").hide();
                        }, 5000);

                    }



                },

                error: function(json) {





                    if (json.status == 422) {



                        document.getElementById('send_sms_formsubmit').innerHTML = 'Send';



                        var resJSON = json.responseJSON;



                        $('.help-block').html('');



                        $.each(resJSON.errors, function(key, value) {



                            $('.' + key + '-error').html('<strong class="new_error_class">' +
                                value + '</strong>');



                            $('#div_' + key).addClass('has-error');



                        });



                    }

                }



            });

        });













        function sendemail(id)

        {

            var user_id = id;

            $("#send_user_id").val(user_id);

            $('#sendemailmodal').modal('show');



        }

        function sendsms(id)

        {

            var user_id = id;

            $("#send_sms_userid").val(user_id);

            $('#sendsmsmodal').modal('show');

            $('#user_number').val('test');









            var newText = $("#phone_number").val();

            var userInput = $("#sendmessage").val();

            userInput = userInput + " " + newText;

            $("#phone_number").val('');

            // $("#sendmessage").val(userInput);



        }

        function sendbulksms()

        {



            $('#smsmodal').modal('show');





            var userInput = $("#sendbulkmessage").val();

            userInput = userInput + " " + newText;

            $("#phone_number").val('');

            $("#sendbulkmessage").val(userInput);



        }



        // Draft Function



        $('#draft_form_Submit').click(function(e) {





            //  document.getElementById('draft_form_Submit').innerHTML = 'Drafting..';





            e.preventDefault();



            $('#name-error').html("");

            $('#message-error').html("");



            $.ajaxSetup({

                headers: {

                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')

                }

            });

            $.ajax({

                url: "{{ route('draft.store') }}",

                method: 'POST',

                data: {

                    _token: "{{ csrf_token() }}",

                    name: $('#name').val(),

                    message: $('#message').val(),



                },



                success: function(result) {

                    $('#draftmodal').modal('hide');

                    //      document.getElementById('draft_form_Submit').innerHTML = 'Draft';

                    //     $(".draft_success").html("<div class='alert alert-success education_style'>{{ __('Drafted Successfully') }}</div>");

                    //    setTimeout(function() { $(".draft_success").hide(); }, 5000);



                    alert('test');



                },

                error: function(json) {





                    if (json.status == 422) {





                        //  document.getElementById('draft_form_Submit').innerHTML = 'Draft';





                        var resJSON = json.responseJSON;



                        $('.help-block').html('');



                        $.each(resJSON.errors, function(key, value) {



                            //  alert(key);



                            $('.' + key + '-error').html('<strong class="new_error_class">' +
                                value + '</strong>');



                            $('#div_' + key).addClass('has-error');



                        });



                    }

                }

            });

        });







        function savesearchmodal()

        {

            var location = $("#locationvalue").val();

            var search = $(".searchvalue").val();

            var notice_period = $(".noticeperiodvalue").val();


            $("#savesearch").val(search);

            // $("#save_location").val(location);

            $("#save_notice_period").val(notice_period);


            $("#savesearchmodal").modal('show');


        }







        $('#save_form_submit').click(function(e) {



            e.preventDefault();



            $('#search_value-error').html("");





            $.ajaxSetup({

                headers: {

                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')

                }

            });

            $.ajax({

                url: "{{ route('save-search') }}",

                method: 'POST',

                data: {

                    _token: "{{ csrf_token() }}",

                    search_value: $('#search_value').val(),

                    location: $(".savelocation").val(),

                    search: $("#savesearch").val(),

                    notice_period: $("#save_notice_period").val(),

                    min_salary: $("#save_min_salary").val(),

                    max_salary: $("#save_max_salary").val(),



                    min_exp: $("#save_min_exp").val(),

                    max_exp: $("#save_max_exp").val(),

                    filter_resume: $("#save_filter_resume").val(),

                    interview_avail: $("#save_interview_avail").val(),

                    education: $("#save_education").val(),

                    course: $(".save_course").val(),

                    specilation: $(".save_specilation").val(),

                    job_type: $("#save_job_type").val(),

                    gender: $("#save_gender").val(),

                    filter: $("#save_filter").val(),

                },

                success: function(result) {

                    console.log(result);





                    $("#savesearchmodal").modal('hide');



                    $('#search_value').val('');

                    $(".success_msg26").html(
                        "<div class='alert alert-success education_style'>{{ __('Search saved successfully') }}</div>"
                        );

                    setTimeout(function() {
                        $(".success_msg26").hide();
                    }, 5000);







                },

                error: function(json) {





                    if (json.status == 422) {





                        var resJSON = json.responseJSON;



                        $('.help-block').html('');



                        $.each(resJSON.errors, function(key, value) {



                            $('.' + key + '-error').html('<strong class="new_error_class">' +
                                value + '</strong>');



                            $('#div_' + key).addClass('has-error');



                        });



                    }

                }



            });

        });



        // Location multiselect



        $(document).ready(function() {



            //multiselect Location



            $('#location-multi-select').multiselect({

                includeSelectAllOption: true,

                selectAllText: 'Any Location',

                enableFiltering: false,

                enableClickableOptGroups: true,

                enableCollapsibleOptGroups: true,

                nonSelectedText: 'Choose by Location',

                numberDisplayed: 2,

                enableCaseInsensitiveFiltering: true,

                filterPlaceholder: 'Enter Location',

            });





        });

        $('.alertmodal').on('click',function () {
            var id = $(this).data('id');
            var route  = "{{ url('employer/buy-cv') }}/"+id  ;
            $('#alertmodal').find('.buy_now').attr('href', route);
        });





        $(window).on('load', function() {

            var dat = $('#yes').val();

            if (dat == 0) {
               
                $('#PlanExpire').modal('show');

                $(".fs-18.mb-1").text("Please purchase the Subscription to find talent FASTER!.");

            }
            if (dat == 2) {
                $('#kyc').modal('show');

            }

            //

        });



        var within_first_modal = false;

        $('.btn-second-modal').on('click', function() {

            $('#emailmodal').modal('hide');

            $('#draftmodal').modal('show');

        });



        $('.btn-second-modal-close').on('click', function() {

            $('#emailmodal').modal('show');

            $('#draftmodal').modal('hide');

        });





        // $(document).ready(function(){





        // showInterview();



        // });





        $('#template').change(function() {



            var template_id = $("#template").val();



            $.ajax({

                url: "{{ route('get.template') }}",

                method: 'POST',

                data: {

                    _token: "{{ csrf_token() }}",

                    id: template_id,



                },



                success: function(result) {



                    console.log(result.data.templatename);



                    if (result.data.templatename != null)

                    {

                        $('#templateid').val(result.data.id);

                    } else {

                        $('#templateid').val('');

                    }



                    $('#subject').val(result.data.subject);







                    //   $('textarea#secondtextarea').val(data);



                    $("#description").summernote('code', result.data.message);



                    //   alert('test');



                },

                error: function(json) {





                    if (json.status == 422) {



                        var resJSON = json.responseJSON;



                        $('.help-block').html('');



                        $.each(resJSON.errors, function(key, value) {



                            //  alert(key);



                            $('.' + key + '-error').html('<strong class="new_error_class">' +
                                value + '</strong>');



                            $('#div_' + key).addClass('has-error');



                        });



                    }

                }

            });





        });





        $('#templatesend').change(function() {



            var template_id = $("#templatesend").val();



            //alert(template_id);



            $.ajax({

                url: "{{ route('get.template') }}",

                method: 'POST',

                data: {

                    _token: "{{ csrf_token() }}",

                    id: template_id,



                },



                success: function(result) {



                    console.log(result.data.templatename);



                    if (result.data.templatename != null)

                    {

                        $('#templateidsend').val(result.data.id);

                    } else {

                        $('#templateidsend').val('');

                    }



                    $('#email-subject').val(result.data.subject);







                    //   $('textarea#secondtextarea').val(data);



                    $("#email-message").summernote('code', result.data.message);



                    //   alert('test');



                },

                error: function(json) {





                    if (json.status == 422) {



                        var resJSON = json.responseJSON;



                        $('.help-block').html('');



                        $.each(resJSON.errors, function(key, value) {



                            //  alert(key);



                            $('.' + key + '-error').html('<strong class="new_error_class">' +
                                value + '</strong>');



                            $('#div_' + key).addClass('has-error');



                        });



                    }

                }

            });





        });



        $("#createnew").click(function() {

            $('#name-error').html("");

            document.getElementById('templatediv').style.display = 'block';

        });





        $("#preview").click(function() {



            var subject = $('#subject').val();

            var description = $('#description').val();



            // alert(subject);



            $('#previewsubject').html(subject);

            $('#previewmessage').html(description);



            $("#emailmodal").modal('hide');



            $("#previewmodal").modal('show');



        });

        $("#previewclose").click(function() {





            $("#emailmodal").modal('show');



            $("#previewmodal").modal('hide');



        });



        $("#preview1").click(function() {



            var subject = $('#email-subject').val();

            var description = $('#email-message').val();



            // alert(subject);



            $('#previewsubject1').html(subject);

            $('#previewmessage1').html(description);



            $("#sendemailmodal").modal('hide');



            $("#previewmodal1").modal('show');



        });

        $("#previewclose1").click(function() {





            $("#sendemailmodal").modal('show');



            $("#previewmodal1").modal('hide');



        });

        $(document).ready(function() {
            $('#previous_start_date').datepicker({
                autoclose: true,
                format: 'dd-mm-yyyy',
                todayHighlight: true,
                startDate: new Date() // set minimum date to today
            });

            var startDate = new Date('12/1950');
            var FromEndDate = new Date();
            var ToEndDate = new Date();
            ToEndDate.setDate(ToEndDate.getDate() + 365);

            $('#previous_start_date').datepicker({
                    weekStart: 1,
                    startDate: '01/09/2019',
                    endDate: FromEndDate,
                    autoclose: true
                })
                .on('changeDate', function(selected) {
                    startDate = new Date(selected.date.valueOf());
                    startDate.setDate(startDate.getDate(new Date(selected.date.valueOf())));
                    $('#previous_end_date').datepicker('setStartDate', startDate);
                });
            $('#previous_end_date').datepicker({
                    weekStart: 1,
                    startDate: startDate,
                    endDate: ToEndDate,
                    format: 'dd-mm-yyyy',
                    autoclose: true,
                    beforeShowDay: function(date) {
                        var daysDiff = Math.ceil((date.getTime() - startDate.getTime()) / (1000 * 3600 *
                            24)); // Calculate days difference
                        if (daysDiff <= 15) {
                            return {
                                enabled: true
                            };
                        } else {
                            return {
                                enabled: false
                            };
                        }
                    }
                })
                .on('changeDate', function(selected) {
                    FromEndDate = new Date(selected.date.valueOf());
                    FromEndDate.setDate(FromEndDate.getDate(new Date(selected.date.valueOf())));
                    $('#previous_start_date').datepicker('setEndDate', FromEndDate);
                });




            $('.select-skill').tokenfield({
                delimiter: ',',
                beautify: false,

            });








            @if (isset($search_vals))
                // Pre-select the options               
                $('.select-skill').tokenfield('setTokens', {!! json_encode($searchselected) !!});
            @endif




            $('#search').click(function() {

                $('#country_name').text($('#search_data').val());

            });



        });




        function clearfilter2() {

            $.ajax({

                type: "POST",

                url: "{{ url('clear-filter2') }}",

                _token: '{{ csrf_token() }}',

                data: {

                },

                dataType: "json",

                success: function(result) {
                    console.log(result);
                    $('.users-data').empty();
                    $('.users-data').html(result.html);
                    $('.min_exp').val('');
                    $('.max_exp').val('');
                    $('.min_salary').val('');
                    $('.max_salary').val('');
                    $('.previous_start_date').val('');
                    $('.previous_end_date').val('');
                    $('.noticeperiodvalue').val([]);
                    $('#multiple-select-notice').multiselect('deselectAll', false);
                    $('#multiple-select-notice').next().find('.multiselect-selected-text').text('Notice Period')
                    $('.dynamic').val('');
                    $('.gender').val('');
                    $('.job_type').val('');
                    $('p.text-danger').hide();

                    // $('.users-data').html(res);

                },
                error: function(result) {

                    // $('.users-data').empty();
                    // $('.users-data').html(result.html);


                    console.log(result.html);
                }

            });

        }

        function clearfilter1() {

            $.ajax({

                type: "POST",

                url: "{{ url('clear-filter1') }}",

                _token: '{{ csrf_token() }}',

                data: {

                },

                dataType: "json",

                success: function(result) {
                    console.log(result);
                    $('.users-data').empty();
                    $('.users-data').html(result.html);


                    var tokenfield = $('.select-skill');

                    // Clear the tokenfield by setting an empty array of tokens
                    tokenfield.tokenfield('setTokens', []);
                    $('.searchvalue').val('');
                    $('.savelocation').val('');
                    $('#collapseOne').removeClass('show');

                    // $('.users-data').html(res);

                },
                error: function(result) {

                    // $('.users-data').empty();
                    // $('.users-data').html(result.html);


                    console.log(result.html);
                }

            });

        }

        function showMore(button) {
            var listItem = button.parentElement;
            var limitedContent = listItem.querySelector(".limited-content");
            var fullContent = listItem.querySelector(".full-content");
            if (fullContent.style.display === "none") {
                fullContent.style.display = "inline"; // Show the full content
                limitedContent.style.display = "none"; // Hide the limited portion
                button.innerHTML = "Less";
            } else {
                fullContent.style.display = "none"; // Hide the full content
                limitedContent.style.display = "inline"; // Show the limited portion
                button.innerHTML = "More";
            }
        }

        








            var pdfjsLib = window['pdfjs-dist/build/pdf'];

            pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.6.347/pdf.worker.min.js';

            var pdfDoc = null;

            var scale = 1; //Set Scale for zooming PDF.

            var resolution = 2; //Set Resolution to Adjust PDF clarity.




        function LoadPdfFromUrl(url,id) {

            $.ajax({
                url: "{{ url('click-profile') }}/"+id,
                type:"get",
                dataType: "json",
                success: function(data) {
                    if(data.status){
                    //Read PDF from URL.

                    pdfjsLib.getDocument(url).promise.then(function(pdfDoc_) {

                        pdfDoc = pdfDoc_;



                        $('#rendermodal').modal('show');

                        $("#pdfLink").attr('href',"{{ url('download-candidate-resum/') }}/"+id+"");
                        $('#pdf_container').empty();



                        //Reference the Container DIV.

                        var pdf_container = document.getElementById("pdf_container");

                        pdf_container.style.display = "block";



                        //Loop and render all pages.

                        for (var i = 1; i <= pdfDoc.numPages; i++) {

                            RenderPage(pdf_container, i);

                        }

                    });

                }else{
                    alert(data.msg);
                    $("#errormsg1").html(
                        "<div class='alert alert-danger education_style'>"+data.msg+"</div>"
                        );

                    setTimeout(function() {
                        $(".success_msg26").hide();
                    }, 5000);
                }
                }
            });
            };

            function RenderPage(pdf_container, num) {

            pdfDoc.getPage(num).then(function(page) {

                //Create Canvas element and append to the Container DIV.

                var canvas = document.createElement('canvas');

                canvas.id = 'pdf-' + num;

                ctx = canvas.getContext('2d');

                pdf_container.appendChild(canvas);



                //Create and add empty DIV to add SPACE between pages.

                var spacer = document.createElement("div");

                spacer.style.height = "20px";

                pdf_container.appendChild(spacer);



                //Set the Canvas dimensions using ViewPort and Scale.

                var viewport = page.getViewport({
                    scale: scale
                });

                canvas.height = resolution * viewport.height;

                canvas.width = resolution * viewport.width;



                //Render the PDF page.

                var renderContext = {

                    canvasContext: ctx,

                    viewport: viewport,

                    transform: [resolution, 0, 0, resolution, 0, 0]

                };



                page.render(renderContext);

            });

            };
    </script>

@endpush
