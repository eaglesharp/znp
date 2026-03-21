@extends('layouts.app')







@section('content') 







<!-- Header start --> 







@include('includes.header') 


@php
    // Define the selected values

    if(isset($locations_vals)) {

        $selected = $locations_vals;

       
    }
        if(isset($search_vals)) {

        $searchselected = $search_vals;

       
    }



@endphp

<style>
.savelocation{
            height: 55px;
            border: 1px solid #cbcbcb;
            background-image: none!important;
        }

#ui-id-1 :is(li.ui-menu-item:hover, li.ui-menu-item.active ) {
    background-color: #e3eaf2;
}
    .notice-period .dropdown-menu {
            height: 96px!important;

        }

        .serach-icon .tokenfield{
                width: 499.172px!important;
                    min-height: 55px!important;
        }

        .location_cus .tokenfield .token{
                border-radius: 30px!important;               
                background-color: #f6faff!important;
                padding: 0px 10px;
                height: 26px!important;
        }

        .notice-period .btn-group{
                width: 100% !important;

        }


          .notice-period button.multiselect.dropdown-toggle.btn.btn-default{
               padding: 7px 35px 5px 15px !important;
               height: 36px !important;
        }
        .date-in{
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



    .date-in{

        height: 40px !important;

    }

    #overlay {

      position: fixed;

      display: none;

      width: 100%;

      height: 100%;

      top: 0;

      left: 0;

      right: 0;

      bottom: 0;

      background-color: rgba(0,0,0,0.5);

      z-index: 2;

      cursor: pointer;

    }

    #text{

      position: absolute;

      top: 50%;

      left: 50%;

      font-size: 50px;

      color: white;

      transform: translate(-50%,-50%);

      -ms-transform: translate(-50%,-50%);

    }

    

    .joblist{
        position: absolute;
        right: -10px;
        top: -22px;
    }


    .list-inline-item-1.layoff-cv {
        background-color: #3998de;
        color: #fff !important;
        padding: 2px 7px;
        border-radius:  0 5px 0 10px;
        line-height: 19px;
        font-size: 13px;
        display: inline-block;
    }
    
    
     .default-size{
            font-size:15px !important;
        }



    

    </style>



<?php 



if(isset($collections))



{


foreach($collections as $collect)



{



$collection_id =  $collect->collection_id;



//echo $collection_id;



}







}







?>







<!-- Email modal starts -->







<!-- modal -->



<div class="container">

    <!-- modal -->

    <!--<div class="modal" id="bulkemailmodal">-->

    <!--    <div class="modal-dialog">-->

    <!--        <div class="modal-content mx-auto">-->

                <!-- header -->

            

    <!--            <form  method="post" action="" enctype="multipart/form-data">-->

    <!--                @csrf-->

    <!--            <div class="col-12 pt-3">-->

    <!--                <div class="row">-->

    <!--                    <div class="col-8">-->

    <!--                        <h4 class="modal-title sign_head">Send Email</h4>-->

    <!--                    </div>-->

    <!--                    <div class="col-4">-->

    <!--                        <p type="button" class="info" data-dismiss="modal"><img class="float-right modal_close-icon" src="{{asset('/')}}asset/images/close.png"></p>-->

    <!--                    </div>-->

    <!--                </div>-->

    <!--            </div>-->

                <!-- body -->

    <!--            <div class="modal-body">-->

    <!--                <div class="text-danger p-2">-->

    <!--                    <h6 id="user_id-error" style="color: red"></h6>-->

    <!--                </div>-->

    <!--                <div class="row">-->

    <!--                    <div id="overlay" onclick="off()">-->

    <!--                        <div id="text">Sending..</div></div>-->

    <!--                    {{-- <input type="hidden" value="{{$user->id}}" name="id" id="id"> --}}-->

    <!--                    <input type="hidden" name="user_id[]" id="user_id" value="">-->

    <!--                    <div class="col-md-10 pb-2">-->

    <!--                        <input type="text" placeholder="Subject" name="subject" id="subject" class="w-75 signup_input rounded px-3 py-2">-->

    <!--                        {{-- <textarea class="form-control" placeholder="Subject" aria-label="With textarea" id="subject" name="subject" rows="1"></textarea> --}}-->

    <!--                        <div class="text-danger">-->

    <!--                            <strong id="subject-error" class="new_error_class"></strong>-->

    <!--                        </div>-->

    <!--                    </div>-->

    <!--                    <div class="col-md-12 pb-2">-->

    <!--                        <textarea class="form-control" placeholder="Message" id="description" name="description" aria-label="With textarea" row="10"></textarea>-->

    <!--                        <span class="text-danger">-->

    <!--                            <strong id="description-error" class="new_error_class"></strong>-->

    <!--                        </span>-->

    <!--                    </div>-->

    <!--                </div>-->

    <!--            </div>-->

    <!--            <div class="modal-footer justify-content-end px-3">-->

    <!--                <button type="button" class="btn btn-secondary py-2 mr-3" data-dismiss="modal">Cancel</button>-->

    <!--                <button type="submit" id="form_Submit" class="signin_button px-4 py-2 rounded form_Submit1">Send</button>-->

    <!--            </div>-->

    <!--            </form>-->

    <!--        </div>-->

    <!--    </div>-->

    <!--</div>-->

     <div class="modal newmodalclass" id="bulkemailmodal">

        <div class="modal-dialog">

            <div class="modal-content mx-auto">

                <!-- header -->

                <div class="alert alert-danger print-error-msg" style="display:none">

                    <ul></ul>

                </div>



                <form   enctype="multipart/form-data" onkeydown="return event.key != 'Enter';">

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

                                    $templates = DB::table('templates')->where('company_id',Auth::guard('company')->user()->id)->get();

                                @endphp

                       

                        <div class="row">

                            <input type="hidden" value="" name="user_id" id="user_id">

                            <input type="hidden" name="templateid" id="templateid" value="0" >

                           @if(count($templates) > 0 && isset($templates))

                            <div class="col-md-12 pb-2 mb-4">

                                <select class="form-control" id="template" name="template"  style="width: 175px;background: #e3e3e3;float:right">                                    

                                    <option selected value="">Select Templates</option>

                                    @foreach ($templates as $template)                                        

                                    <option value="{{ $template->id }}">{{ $template->templatename }}</option>

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

                                <select class="form-control" style="width: 175px;background: #e3e3e3;float:right">                                    

                                    <option selected disabled>No Templates</option>                                  

                                </select>                              

                            </div>





                            @endif







                            <div class="col-md-12 pb-2">

                                <textarea class="form-control" placeholder="Subject" aria-label="With textarea"

                                    id="subject" name="subject" rows="1"></textarea>

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

                                <a href="{{url('email-templates')}}" target="_blank" style="float: right;margin-right: 10px;">Edit</a>

                                <input  class="form-control" placeholder="Template Name" 

                                    id="name" name="name" rows="1"></textarea>

                                <span class="text-danger">

                                    <strong id="name-error" class="new_error_class name-error"></strong>

                                </span>

                            </div>

                            {{-- <div class="col-md-10 pb-2" @if(count($templates) > 0 && isset($templates)) style="display:none" @endif id="templatediv">

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

                        <button type="button" class="btn btn-secondary py-2 mr-3" data-dismiss="modal">Cancel</button>

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

    <div class='alert alert-success newclass' id="myElem" style="display:none;">Email Sent Successfully</div>

</div>



<!-- modal end -->





<div class="container">



    <div class="modal newmodalclass" id="previewmodal">

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

                        <table border="0" cellpadding="0" cellspacing="0" class="force-row" style="width: 100%;    border-bottom: solid 1px #ccc;">



  

                            <tr>

                        

                                <td class="cols-wrapper" style="padding-left:12px;padding-right:12px">

                        

                                  

                        

                                    <table border="0" cellpadding="0" cellspacing="0" align="left" class="force-row" style="width: 100%;">

                        

                                        <tr>

                        

                                            <td class="row" valign="top" style="padding-left:12px;padding-right:12px;padding-top:18px;padding-bottom:12px"><table border="0" cellpadding="0" cellspacing="0" style="width:100%;">

                        

                        

                                <tr>

                                    <td style="font-family:Helvetica,Arial,sans-serif;font-size:14px;line-height:22px;font-weight:400;color:#333;padding-bottom:3px;text-align:left;padding-top: 42px;" >

                                        <b>Subject</b> :<span id="previewsubject"></span>     

                                    </td>

                                </tr>

                                <tr>

                                    <td style="font-family:Helvetica,Arial,sans-serif;font-size:14px;line-height:22px;font-weight:400;color:#333;padding-bottom:30px;text-align:left;padding-top: 4px;" >

                                       <b> Message</b> :<p id="previewmessage"></p>     </td>

                                </tr>

        

        

        
{{-- 
                            <tr >

                                <td style="font-family:Helvetica,Arial,sans-serif;font-size:14px;line-height:22px;font-weight:400;color:#333;padding-bottom:30px;text-align:left;padding-top: 42px;">

                             

                                <p style=" border-top: 1px dashed #000;padding-bottom: 30px;"><p>

        

                               <b> Disclaimer :</b> The sender of this email is registered with <a href="{{ url('/') }}">www.zeronoticeperiod.com</a> as <b> {{ Auth::guard('company')->user()->name }} ({{ Auth::guard('company')->user()->email }}) </b> using <a href="{{ url('/') }}">www.zeronoticeperiod.com</a> services. If you consider the content of this email inappropriate or spam, you may forward the email to: <a href="mailto:compliance@zeronoticeperiod.com" target="_blank">compliance@zeronoticeperiod.com</a>.  Please note this email is a private message from the recruiter. Please do not pay any money to anyone who promises to find you a job. Please note, there are multiple scams where you may be asked to pay money for a job. In case you are suspicious please forward the content to <a href="mailto:compliance@zeronoticeperiod.com" target="_blank">compliance@zeronoticeperiod.com</a>

        

                                    

                                  <!--<p>  <b>General Advise :</b> Please do not pay any money to anyone who promises to find you a job. This could be in any form. The money could be asked for upfront or it could be asked after trust has been built after some communication has been exchanged. Please ensure you are not being scammed and in case you are suspicious please contact <a href="mailto:compliance@zeronoticeperiod.com" target="_blank">compliance@zeronoticeperiod.com</a> for advise.</p></td>-->

                          

                            </tr>

         --}}

                        

                                                  

                                          

                        

                                                    <tr>

                        

                                                        <td style="font-family: Helvetica, Arial, sans-serif;font-size: 14px;line-height: 22px;font-weight: 400;color: #333; padding-bottom: 20px;text-align: left; padding-top:50px;">Thanks, <br>

                        

                                                            ZeroNoticePeriod Team</td>

                        

                                                    </tr>

                        

                                                </table>

                        

                                                <br></td>

                        

                                        </tr>

                        

                                    </table>      

                        

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















<section class="section_search-box pt-4">



    <div class="container">



   



        <form class="row px-2 mt-sm-5" action="{{route('candidate.bulk.filter.page')}}" method="post">

            <input type="hidden" name='collection_id' value="{{(isset($collection_id)? $collection_id:'')}}">
                    <div class="col-lg form-inline serach-icon location_cus  px-2">

                @csrf

                <div class="col-lg-5 form-inline serach-icon location_cus  px-2">

                @csrf

                <input class="form_control-1 select-skill rounded pl-3 pr-5" type="text" placeholder="Search" aria-label="Search"

                    name="search[]" value="" id="searchvalue">

                <button class="filter_search-button" type="submit"><img class="search_icon-input pr-0" src="{{ asset('asset/images/loupe.png') }}"></button>

            </div>


            <div class="col-lg-4 position_lit px-2 notice-period location_cus">

                <input id="tags" value="{{ $store_locations??'' }}"  name="location" class="form_control rounded pl-3 pr-5 w-100 savelocation" placeholder="Search Location">

            </div>

            <div class="col-lg-2">

                <button type="submit" class="btn btn_submit w-100 text-light">Apply</button>

            </div>
        <div class="col-lg-1 d-flex justify-content-center align-items-center p-0">
                                
            <!-- <a  onclick="clearfilter1()" class="" style="color:#197ff3;text-decoration: underline;cursor:pointer">Clear</a> -->
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



                                    <img class="close_img-icon" src="{{asset('/')}}asset/images/cancel.png">



                                </a>



                            </div>



                        </div>



                    </div>



                    <div class="candidate_list-filter mb-4 mb-md-0 px-0">



                        <div class="accordion" id="accordionExample">



                            <div class="candidate_list mt-2 pt-3">



                                <div class="candidate_head mb-1 px-lg-1" id="headingOne">



                                    <button class="btn_candidate-box btn_candidate-arrow px-3 py-4" type="button"



                                        data-toggle="collapse" data-target="#collapseOne" aria-expanded="true"



                                        aria-controls="collapseOne">



                                        Sub Filters



                                    </button>



                                </div>



                                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"



                                    data-parent="#accordionExample">



                                    <div class="candidate_body px-lg-3 py-2">



                                    <div class="form-check pb-2 pl-0 w-100">



                                        <form action="{{route('candidate.bulk.filter2.page')}}" method="post">



                                            <input type="hidden" name='collection_id' value="{{(isset($collection_id)? $collection_id:'')}}">
                                            @csrf










                                        <label  class="mb-1 pt-0 sign_fontsize">Total Experience<span class="text-danger px-1"> </span></label>



                                            <div class="row py-1">



                                                <div class="col">



                                                    <input type="number" name="min_exp" placeholder="Min" min="0" max="50" value="{{(isset($min_exp)?$min_exp:'')}}"



                                                        onkeyup=imposeMinMax(this)



                                                        class="w-100 signup_input rounded pl-2 py-1">



                                                </div>



                                                <div class="col-1 text-center px-0 pt-1">-</div>



                                                <div class="col">



                                                    <input type="number" name="max_exp" placeholder="Max" min="0" max="50" value="{{(isset($max_exp)?$max_exp:'')}}"



                                                        onkeyup=imposeMinMax(this)



                                                        class="w-100 signup_input rounded pl-2 py-1">




                                                </div>



                                            </div>
                                            
                                            
                                            
                                                        @if($errors->has('max_exp'))                           

                                                        <p class="text-danger">{{ $errors->first('max_exp') }}</p>

                                                        @endif



                                        </div>



                                                    <label class="mb-1 pt-0 sign_fontsize">Salary Range<span

                                                                class="text-danger px-1"> </span></label>



                                                    <div class="row py-1">



                                                        <div class="col">

                                                              <input type="number" name="min_salary" placeholder="Min" min="0" max="100"

                                                           onkeyup=imposeMinMax(this) @if(isset($min)) @if($min == 0) @else value="{{ $min }}" @endif @else value="" @endif

                                                           class="w-100 signup_input rounded px-1 py-1" id="save_min_salary">

                                                                            </div>

                                                                            <div class="col-1 text-center px-0 pt-1">-</div>

                                                                            <div class="col">

                                                                                 <input type="number" name="max_salary" placeholder="Max" min="0" max="100"

                                                           onkeyup=imposeMinMax(this) @if(isset($max)) @if($max == 0) @else value="{{ $max }}" @endif @else value="" @endif

                                                           class="w-100 signup_input rounded px-1 py-1" id="save_max_salary">

                                                                            



                                                                                
                                                                            </div>

                                                                        </div>
                                                                        
                                                                          @if($errors->has('max_salary'))

                                                                                    <p class="text-danger">{{ $errors->first('max_salary') }}</p>

                                                                                @endif
                                                              <label class="mb-1 pt-0 sign_fontsize">Interview Availability<span



                                                            class="text-danger px-1"> </span></label>

                                        

                                        

                                          <div class="row py-1">



    



                                                        <div class="col">



                                                            <input type="text" name="previous_start_date" class="form_action date-in rounded pl-2 mb-3" id="previous_start_date" value="{{ isset($s_date) ? $s_date : '' }}" placeholder="Start Date">

                                      



                                                        </div>



                                                     



                                                        <div class="col">



                                                                 <input type="text" name="previous_end_date" class="form_action date-in rounded pl-2 mb-3" id="previous_end_date" value="{{ isset($e_date) ? $e_date : '' }}" placeholder= "End Date"> 





                                                              



                                                        </div>



                                                    </div>
                                                    
                                                    
                                                      @if($errors->has('previous_end_date'))                           



                                                                <span class="text-danger">{{ $errors->first('previous_end_date') }}</span>



                                                                @endif

                                                     <div class="row py-1 notice-period" style="    margin-left: 0px;   width: 100%;  padding-bottom: 15px!important;">
   
                                                                              <select id="multiple-select-notice" class="form_control  noticeperiodvalue  form_action rounded pl-3 pr-5 mb-3" multiple="multiple" name="notice_period[]">

                                                                            <option value="1" @if (isset($notice_period)) @if (in_array(1, $notice_period)) selected @endif @endif>



                                                                                Immediately Available </option>

                                                                            <option value="2" @if (isset($notice_period)) @if (in_array(2, $notice_period)) selected @endif @endif>Serving

                                                                                Notice Period</option>



                                                                        </select>
                                      </div>


                          
                                    

                                    <?php



                                                    $profile_education = (isset($profileEducation) ? $profileEducation->degree_title : null);



                                                    $educationn = \App\Education::find($profile_education);



                                                    $educations = \App\Education::all();





                                                    $education = (isset($education) ? $education : null);



                                                    $education1 = \App\Education::where('id',$education)->first();



                                                    



                                       ?>



                                        <select class="form_control form_action rounded pl-3 pr-5 mb-3 dynamic " name="education" 

                                            style="height: 35px!important;">

                                              

                                            <option value="" selected >{{(isset($education1) ? $education1->education : 'Select Education')}}</option>

                                             <!--<option value="">All</option>-->

                                            @foreach($educations as $edu)



                                                <option value="{{$edu->id}}"> {{$edu->education}}</option>



                                            @endforeach

                                        </select>





                                        <?php



                                                $organization = (isset($course) ? $course : null);



                                                $specilation = (isset($specilation) ? $specilation : null);







                                                $course=\App\Course::where('id',$organization)->first();



                                                $spec=\App\specs::where('id',$specilation)->first();







                                        ?>



                                   

                                    

                                    

                            <select class="form_control form_action rounded pl-3 pr-5 mb-3" name="gender"

                            style="height: 35px!important;" id="save_gender">

                            <!--<option Selected Disabled>Gender</option>-->

                            <option value="" >Gender</option>

                            <option value="2" @if (isset($gender)) @if ($gender=='2' ) selected @endif

                                @endif>Male</option>

                            <option value="1" @if (isset($gender)) @if ($gender=='1' ) selected @endif

                                @endif>Female</option>

                            <option value="3" @if (isset($gender)) @if ($gender=='3' ) selected @endif

                                @endif>Don't wish to specify</option>

                        </select>
                                        
                                        
                                        <select class="form_control form_action rounded pl-3 pr-5 mb-3"

                                        name="job_type" style="height: 35px!important;" id="save_job_type">

                                        <!--<option Selected Disabled>Job Type</option>-->

                                        <option value="" >Job Type</option>

                                        <option value="Contract" @if (isset($job_type)) @if ($job_type=='Contract' )

                                            selected @endif @endif>Contract</option>

                                        <option value="Permanent" @if (isset($job_type)) @if ($job_type=='Permanent'

                                            ) selected @endif @endif>Permanent</option>

                                        <option  value="Flexible" @if (isset($job_type)) @if ($job_type=='Flexible'

                                        ) selected @endif @endif>Flexible</option>

                                    </select>


                                    </div>



                                </div>



                            </div>



                        </div>



                        <div class="col-lg-12 box d-block px-0 px-lg-3 mb-1">



                            <button type="submit" class="btn btn_submit w-100 text-light">Apply</button>



                        </div>



                    </form>



                    </div>



                </div>



            </div>







     @if(isset($fusers))



        @include('bulk-search')



    @else 



<div class="col-lg-9 footer-alignss">

    {{-- {{$collections}} --}}

    <div class="col-12 candidates_job-dashboard py-3 px-0 pt-0">

        <div class="container">

            <div class='alert alert-success newclass' id="myElem" style="display:none;">Email sent successfully</div>

        </div>

        <!-- <span class="candidate_title-head">Showing 46 <span class="candidate_text">Candidates</span></span> -->

        <div class="row pb-4">



            <div class="col-md-7 align-self-center">



              



            <!-- <div class="col-5">    -->

                <?php 



          

            $folder = \App\Collection::where('id',$folder_id)->first();





            ?>



                <h3 class="sign_head">{{ $folder->name }}</h3>



                <div class="">{{ $folder->description }}</div>



                



            </div>



            <!-- <div class="col-md-7 text-right pt-3  d-none d-md-block ">   -->





 

                <?php 

                $company_id = Auth::guard('company')->user()->id ;      

        

                $company_value = \App\Company::where('id', $company_id)->first();

                $now = \Carbon\Carbon::now();

                $end_date = $company_value->package_end_date;

           

                //echo $end_date;

                ?>

                @if($end_date < $now )

            

                <div class="col-md-5 col-sm-12 text-right pt-3">  

                    <button type="submit" class="py-2 signin_button send_mail_btn rounded px-3" data-toggle="modal"   onclick="alert('Your Package Expired!')">Send Email</button>

                </div>



                @else      





                <div class="col-md-5 col-sm-12 text-right pt-3">  

                    <button type="submit" class="py-2 signin_button send_mail_btn rounded px-3" data-toggle="modal" data-target="#bulkemailmodal" data-id="">Send Email</button>

                </div>





               @endif





               



        </div>

        <div class="row mx-0 select-all py-2">

            <div class="col-10">

               

                

                <!--@if(isset($check_user))-->

                <div class="select_all-check d-flex align-items-center  d-inline">

                    <span><input type="checkbox" id="select_all" class="checkbox_size" maxlength="100" required> <span id="selected_count"></span><label for="select_all" class="pl-2 sign_head mb-0">Select all to sent Email</label></span>

                </div>

                <!--@endif-->

            </div>

            <div class="col-2">

                <a id="filter_show-button" class="filter_icon-algin d-block d-lg-none" href="javascript:void(0);">

                    <img class="filter_img-icon" src="asset/images/Group-1.png">

                </a>

            </div>

        </div>

    </div>

    {{-- {{$collections->collection_id}} --}}

    <?php

    

    // $users=\App\CollectionList::orderBy('created_at','desc')->get();

    // echo($users);

?>

  

      

   

     

     <div class="pagiWrap">

        <nav aria-label="Page navigation example">

            @if(isset($fusers) && count($fusers))

           
            {{ $fusers->links() }}
            
            @endif

        </nav>

    </div>



                                    </div>











                        @endif



                    </div> 



                </div>



            </div>



        </div>



</section>







@include('includes.footer')







@endsection







<script type="text/JavaScript">




    </script>







@push('scripts')


<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">

<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tokenfield/0.12.0/css/bootstrap-tokenfield.min.css">

<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tokenfield/0.12.0/bootstrap-tokenfield.js"></script>



  <script>  
        $(document).ready(function() { 

            $('textarea.summernote').summernote({   
                placeholder: 'Write Your Message',  
                tabsize: 2, 
                height: 300,    
                toolbar: [  
                  //  ['style', ['style']],   
                    ['font', ['bold', 'italic', 'underline', 'clear']], 
                    // ['font', ['bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear']], 
                    //['fontname', ['fontname']],   
                    // ['fontsize', ['fontsize']],  
                 //   ['color', ['color']],   
                    ['para', ['ul', 'ol', 'paragraph']],    
                    // ['height', ['height']],  
                    // ['table', ['table']],    
                 //   ['insert', ['link']],   
                    // //['view', ['fullscreen', 'codeview']],  
                    // ['help', ['help']]   
                ],  
                callbacks: {
                    onPaste: function(e) {
                        var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');
                        e.preventDefault();
                        document.execCommand('insertText', false, bufferText);
                    }
               }
            }); 
        }); 
    </script>   





<script>




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

$("#tags")
.on("keydown", function(event) {
  if (event.keyCode === $.ui.keyCode.TAB && $(this).autocomplete("instance").menu.active) {
    event.preventDefault();
  }
})
.on("input", function() {
    this.value = this.value.replace(/[^\w\s,\/]/gi, '');
})
.autocomplete({
  minLength: 0,
  source: function(request, response) {
    $.ajax({
      url: "{{ url('autocomplete/cvlocations') }}",
      dataType: "json",
      data: {
        query: extractLast(request.term)
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
    var terms = split(this.value);
    terms.pop();
    terms.push(ui.item.value);
    terms.push("");
    this.value = terms.join(", ");

    // Trigger typing after a value is selected
    
    document.getElementById("tags").blur()
    document.getElementById("tags").focus()

    
    return false;
  },
  open: function(event, ui) {
    var term = extractLast(this.value);
    var autocomplete = $(this).data("ui-autocomplete");
    autocomplete.menu.element.find("li").each(function() {
      var item = $(this).data("ui-autocomplete-item");
      var highlightedItem = item.label.replace(new RegExp($.ui.autocomplete.escapeRegex(term), "gi"), '<span class="highlight">$&</span>');
      $(this).html(highlightedItem);
    });
  }


  
});



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
      var highlightedItem = item.label.replace(new RegExp($.ui.autocomplete.escapeRegex(term), "gi"), '<span class="highlight">$&</span>');
      $(this).html(highlightedItem);
    });
  }
});



});

var base_url = '{{URL::to('')}}';



$(document).ready(function(){



    



    $(".email_checkbox").click(function(){



      //  alert('test');



        var array = new Array();



        // var checked = $(".email_checkbox:checked").length;



        var checkbox = $(".email_checkbox:checked");



        if (checkbox) {



            var check = checkbox.map(function(){



                // check1= $(this).val();



                array.push($(this).val());



            });



        }



        $("#user_id").val(array);

        var selectedCount = array.length;
                console.log('Selected checkboxes count: ' + selectedCount);

                // Append selected count inside span tag
                var spanText = '(' + selectedCount + ')';
                $("#selected_count").text(spanText);



        //console.log(array);



    });







    $("#select_all").click(function(event){



        var array1 = new Array();



        var checkbox = $(".email_checkbox");



        if (checkbox.is(':checked')) {



            var selectid = checkbox.map(function(){



                array1.push($(this).val());



            });



        } else {



           selectid=0; 



        }



        $("#user_id").val(array1);

        var selectedCount = array1.length;
                console.log('Selected checkboxes count: ' + selectedCount);

                // Append selected count inside span tag
                var spanText = '(' + selectedCount + ')';
                $("#selected_count").text(spanText);



    });



});

    $(document).ready(function(){

        $('#form_Submit').click(function(e){



        document.getElementById('form_Submit').innerHTML = 'Sending..';

        var template_id = $("#template").val();

        e.preventDefault();

        

            $( '#user_id-error' ).html( "" );

            $( '#name-error' ).html( "" );

            $( '#subject-error' ).html( "" ); 

            $( '#template-error-sec-error' ).html( "" ); 

            $( '#mail_user_id-error' ).html( "" ); 

            $( '#description-error' ).html( "" );

            $.ajaxSetup({

                headers: {

                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')

                }

            });

            $.ajax({

                url: "{{ route('email.sendbulkemail') }}",

                method: 'POST',

                data: {

                    user_id:$('#user_id').val(),

                    _token:"{{ csrf_token() }}",

                    name: $('#name').val(),

                    subject: $('#subject').val(),

                    template:template_id,

                    description: $('#description').val(),

                },

                success: function(result){

                    console.log(result);

                    document.getElementById('form_Submit').innerHTML = 'Send';

                    if(result.success) {

                        $('.alert-danger').hide();

                        $('#bulkemailmodal').modal('hide');

                        $("#myElem").show();

                        $('#user_id').val('');

                       // $('#template').val('');

                        $('#name').val('');

                        $('#subject').val('');

                        $('#templateid').val('');

                        $('#description').val('');

                        setTimeout(function() { $("#myElem").hide(); }, 5000);

           

                        $('#template option:contains("Select Templates")').prop('selected',true);



                        

                        var checkbox = $(".email_checkbox");

                        var selectall = $("#select_all");



                        $('input[type=checkbox]').each(

                         function (index, checkbox) {

                            if (index != 0) {

                                checkbox.checked = false;

                            }

                        });





                    }

                    if(result.errors)

                    {

                       // alert(result.errors.user_id[0]);

                        document.getElementById('form_Submit').innerHTML = 'Send'

                       // console.log(result.errors);

                       

                        if(result.errors.user_id){

                           

                        $( '#mail_user_id-error' ).html( result.errors.user_id[0] );

                        }

                        if(result.errors.subject){

                            $( '#subject-error' ).html( result.errors.subject[0] );

                        }

                        if(result.errors.template){

                            $( '#template-error-sec' ).html( result.errors.template[0] );

                        }

                        if(result.errors.name){

                            $( '#name-error' ).html( result.errors.name[0] );

                        }

                        if(result.errors.description){

                            $( '#description-error' ).html( result.errors.description[0] );

                        }

                       

                    }if(result.errors1)

                    {

                        if(result.errors1){

                           alert('Please Upgrade Your Plan');

                        }

                    }

                },



            });

        });

    });





















    $.ajaxSetup({



headers: {



    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')



}



});



$('.dynamic').change(function(){



var degree_id = $(this).val(); 







//     alert(degree_id);







if(degree_id){







  $.ajax({



    type:"POST",



    url:"{{url('gety')}}",



    _token: '{{ csrf_token() }}',



    data: {



       degree:degree_id,



    },



    dataType: "json",



    



    success:function(res){        



    if(res){



      $(".dynamiccourse").empty();



      $(".dynamiccourse").append('<option>Select course</option>');

      $("#newcourse123 option:first").attr("disabled", "disabled");



      $.each(res,function(key,value){



        $(".dynamiccourse").append('<option value="'+value.id+'">'+value.course+'</option>');



      });



    



    }else{



      $(".dynamiccourse").empty();



    }



    }



  });



}else{







}   



});











$('.dynamiccourse').on('change',function(){







var course_id = $(this).val();  







if(course_id){



 $.ajax({



   type:"POST",



   url:"{{url('getspecs')}}",



   _token: '{{ csrf_token() }}',



   data: {



      course:course_id,



   },



   dataType:"json",



   success:function(res){        



   if(res){



     $(".dynamicspecs").empty();



     $(".dynamicspecs").append('<option>Select Specilization</option>');

    



$("#specs123 option:first").attr("disabled", "disabled");



     $.each(res,function(key,value){



       $(".dynamicspecs").append('<option value="'+value.id+'">'+value.specs+'</option>');



     });



   



   }else{



     $(".dynamicspecs").empty();



   }



   }



 });



}else{



 $(".dynamicspecs").empty();



}



 



});





$('#multiple-select-notice').multiselect({

    includeSelectAllOption: false,

    nonSelectedText: 'Choose by Notice Period',

    numberDisplayed: 2,

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



$('#template').change(function() {



    var template_id = $("#template").val();



    $.ajax({

                url: "{{ route('get.template') }}",

                method: 'POST',

                data: {                    

                    _token:"{{ csrf_token() }}",

                      id: template_id,                   

                   

                },

                

                success: function(result){



                    console.log(result.data.templatename);



                    if(result.data.templatename != null)

                    {

                        $('#templateid').val(result.data.id);

                    }else{

                        $('#templateid').val('');

                    }

                    

                    $('#subject').val(result.data.subject);



                    



                  //   $('textarea#secondtextarea').val(data);



                    
                     $("#description").summernote('code', result.data.message);

                  

             //   alert('test');

                    

                },

                error: function(json){

       



                    if (json.status == 422) {

                    

                    var resJSON = json.responseJSON;



                    $('.help-block').html('');



                    $.each(resJSON.errors, function (key, value) {

                        

                      //  alert(key);



                    $('.' + key + '-error').html('<strong class="new_error_class">' + value + '</strong>');



                    $('#div_' + key).addClass('has-error');



                    });



                    }

                }

            });



    

});





$("#preview").click(function(){



   var subject =  $('#subject').val();

   var description = $('#description').val();



  // alert(subject);



   $('#previewsubject').html(subject);

   $('#previewmessage').html(description);



      $("#bulkemailmodal").modal('hide');



   $("#previewmodal").modal('show'); 

    

});

$("#previewclose").click(function(){





$("#emailmodal").modal('show');



$("#previewmodal").modal('hide');



});





$(document).ready(function () {

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

.on('changeDate', function (selected) {

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
                beforeShowDay: function(date){
                    var daysDiff = Math.ceil((date.getTime() - startDate.getTime()) / (1000 * 3600 * 24)); // Calculate days difference
                    if (daysDiff <= 15) {
                        return {enabled: true};
                    } else {
                        return {enabled: false};
                    }
                }
            })
            .on('changeDate', function (selected) {
                FromEndDate = new Date(selected.date.valueOf());
                FromEndDate.setDate(FromEndDate.getDate(new Date(selected.date.valueOf())));
                $('#previous_start_date').datepicker('setEndDate', FromEndDate);
            });


             // Initialize the tokenfield plugin
            $('#search_data').tokenfield({
              autocomplete: {
                source: function(request, response) {
                  jQuery.get("{{ url('autocomplete/search-location') }}", {
                    query : request.term
                  }, function(data){
                    data = JSON.parse(data);
                    response(data);
                  });
                },
                delay: 100
              },
              showAutocompleteOnFocus: true,
              allowDuplicates: false,
              createTokensOnBlur: false
            });

            @if(isset($locations_vals))
                // Set the selected values
                $('#search_data').tokenfield('setTokens', {!! json_encode($selected) !!});
            @endif



            $('.select-skill').tokenfield({
                delimiter: ',',
                beautify: false
            });


            @if(isset($search_vals))
              // Pre-select the options               
              $('.select-skill').tokenfield('setTokens', {!! json_encode($searchselected) !!} );
            @endif



});



</script>









@endpush







