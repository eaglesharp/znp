@extends('layouts.app')



@section('content')

<style>

</style>

<!-- Header start -->



@include('includes.header')


<div class="container">

<div class="modal pr-0" id="exampleModalCenter">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content modal_content_custom_width mx-auto p-3">

            <p type="button" class="info mb-0" data-dismiss="modal"><img

                    class="float-right modal_close-icon"

                    src="{{ asset('/') }}asset/images/close.png"></p>

            <div class="modal-body p-0">

                <div class="collection_pic-box  mt-2 mt-md-0">

                    <div class="collection_textw px-lg-3 py-0">

                        <h4 class="sign_head text-center">KYC Document Details</h4>

                        
                        
                        <form action="{{ url("kyc-documents") }}" method="POST" autocomplete="off" enctype="multipart/form-data">
                            <div class="modal-body">
                                @csrf
                              
                                <div class="row">

                                    <div class="col-lg-12">
                            
                                        <label class="mb-2 pt-3 sign_fontsize">Type of Business Entity<span
                            
                                                class="text-danger px-1">*</span></label>
                            
                                        <select name="document_type" id="select_document_type" required
                            
                                            class="w-100 pl-3 pr-4 py-2 form_control-arrow sign_fontsize  signup_input rounded">
                            
                                            <option selected disabled>Select Type of Business Entity</option>
                            
                                            <option value="freelancer">Freelancer/Individual</option>
                                            <option value="sole">Sole proprietorship</option>
                                            <option value="partnership">Partnership firm</option>
                                            <option value="limited">Limited liability partnership</option>
                                            <option value="private">Private or public limited company</option>
                                      
                                      
                                        </select>
                            
                                        <span class="help-block degree_result-error"></span>
                            
                                    </div>
                            
                                </div>
                            
                                {{-- <input type="text" placeholder="Enter Name" class="px-3 py-2 signup_input w-100 rounded" id="name" requried="" maxlength="100" name="name"> --}}
                                <div class="text-danger">
                                    <strong id="name-error" class="new_error_class"></strong>
                                </div>
                                <!-- <div class="selfie row  pt-4" id="selfieDiv">
                                    <div class="col-lg-6 pb-4">
                                        <label class="mb-2 sign_fontsize">Selfie<span class="text-danger px-1">*</span></label>
                                        <button type="button" id="openCamera" class="btn btn-sm btn-primary" >Open Camera</button>
                                        <div class="text-danger">
                                            <strong id="selfie-error" class="selfie-error new_error_class"></strong>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 pb-4">
                                        <input type="hidden" name="selfie" id="selfieData">
                                        <img src="" alt="selfie" class="d-none selfieImage" width="80" height="80">
                                    </div>
                                </div> -->


                                <div class="freelancer row  pt-4" id="freelancer">
                                    <div class="col-lg-6">
                                        <label class="mb-2  sign_fontsize">PAN Card Copy<span class="text-danger px-1">*</span></label>
                                        <input type="file" name="pancard" id="">
                                        <div class="text-danger">
                                            <strong id="freelancer-pancard-error" class=" freelancer-pancard-error  new_error_class"></strong>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="mb-2  sign_fontsize">Aadhar Copy<span class="text-danger px-1">*</span></label>
                                        <input type="file" name="aadharcard" id="">
                                        <div class="text-danger">
                                            <strong id="freelancer-aadharcard-error" class=" freelancer-aadharcard-error new_error_class"></strong>
                                        </div>
                                    </div> 
                                </div>  
                                
                                <div class="sole row pt-4" id="sole">
                                   
                                    <div class="col-lg-6">
                                        <label class="mb-2 sign_fontsize">GST registration certificate<span class="text-danger px-1">*</span></label>
                                        <input type="file" name="sole_gstcertificate" id="sole_gstcertificate">
                                        <div class="text-danger">
                                            <strong id="sole_gstcertificate-error" class="sole_gstcertificate-error new_error_class"></strong>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="mb-2 sign_fontsize">PAN Card Copy<span class="text-danger px-1">*</span></label>
                                        <input type="file" name="sole_pancard" id="sole_pancard">
                                        <div class="text-danger">
                                            <strong id="sole_pancard-error" class="sole_pancard-error new_error_class"></strong>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 mt-4">
                                        <label class="mb-2 sign_fontsize">Aadhar Copy<span class="text-danger px-1">*</span></label>
                                        <input type="file" name="sole_aadharcard" id="sole_aadharcard">
                                        <div class="text-danger">
                                            <strong id="sole_aadharcard-error" class="sole_aadharcard-error new_error_class"></strong>
                                        </div>
                                    </div> 
                                </div> 
                                
                                <div class="partnership row pt-4" id="partnership">
                                    
                                    <div class="col-lg-6">
                                        <label class="mb-2 sign_fontsize">Registration Certificate for registered partnership firms<span class="text-danger px-1">*</span></label>
                                        <input type="file" name="partnership_registrationcertificate" id="partnership_registrationcertificate">
                                        <div class="text-danger">
                                            <strong id="partnership_registrationcertificate-error" class="partnership_registrationcertificate-error new_error_class"></strong>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="mb-2 sign_fontsize">PAN card of the Partnership firm<span class="text-danger px-1">*</span></label>
                                        <input type="file" name="partnership_pancard" id="partnership_pancard">
                                        <div class="text-danger">
                                            <strong id="partnership_pancard-error" class="partnership_pancard-error new_error_class"></strong>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 mt-4">
                                        <label class="mb-2 sign_fontsize">Proof of Legal name and telephone number of the firm<span class="text-danger px-1">*</span></label>
                                        <input type="file" name="partnership_aadharcard" id="partnership_aadharcard">
                                        <div class="text-danger">
                                            <strong id="partnership_aadharcard-error" class="partnership_aadharcard-error new_error_class"></strong>
                                        </div>
                                    </div> 
                                </div> 
                                
                                <div class="limited row pt-4" id="limited">
                                    
                                    <div class="col-lg-6">
                                        <label class="mb-2 sign_fontsize">Certificate of Incorporation document<span class="text-danger px-1">*</span></label>
                                        <input type="file" name="limited_certificateofincorporation" id="limited_certificateofincorporation">
                                        <div class="text-danger">
                                            <strong id="limited_certificateofincorporation-error" class="limited_certificateofincorporation-error new_error_class"></strong>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="mb-2 sign_fontsize">PAN of LLP<span class="text-danger px-1">*</span></label>
                                        <input type="file" name="limited_pancardllp" id="limited_pancardllp">
                                        <div class="text-danger">
                                            <strong id="limited_pancardllp-error" class="limited_pancardllp-error new_error_class"></strong>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="private row pt-4" id="private">
                                    <div class="col-lg-6">
                                        <label class="mb-2 sign_fontsize">Certificate of incorporation (with CIN)<span class="text-danger px-1">*</span></label>
                                        <input type="file" name="private_certificateofincorporation" id="private_certificateofincorporation">
                                        <div class="text-danger">
                                            <strong id="private_certificateofincorporation-error" class="private_certificateofincorporation-error new_error_class"></strong>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="mb-2 sign_fontsize">PAN of the Company<span class="text-danger px-1">*</span></label>
                                        <input type="file" name="private_pancardcompany" id="private_pancardcompany">
                                        <div class="text-danger">
                                            <strong id="private_pancardcompany-error" class="private_pancardcompany-error new_error_class"></strong>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 mt-4">
                                        <label class="mb-2 sign_fontsize">A valid certified copy of the business commencement certificate (Public Limited Company)<span class="text-danger px-1">*</span></label>
                                        <input type="file" name="private_commencementcertificate" id="private_commencementcertificate">
                                        <div class="text-danger">
                                            <strong id="private_commencementcertificate-error" class="private_commencementcertificate-error new_error_class"></strong>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 mt-4">
                                        <label class="mb-2 sign_fontsize">Proof of the company's name, principal place of business, mailing address, and Telephone/Fax numbers (Telephone bill not older than two months)<span class="text-danger px-1">*</span></label>
                                        <input type="file" name="private_proofofcompany" id="private_proofofcompany">
                                        <div class="text-danger">
                                            <strong id="private_proofofcompany-error" class="private_proofofcompany-error new_error_class"></strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- footer -->
                            <div class="modal-footer">
                                <div class="col-8 col-sm-6">
                                    <button type="button" class="btn btn btn-secondary py-2" data-dismiss="modal">Cancel</button>
                                </div>
                                <div class="col-4 col-sm-6 text-right">
                                    <button type="submit" class="signup_button btn-submit  px-3 py-2 rounded" id="create_folder">Submit</button>
                                </div>
                            </div>
                        </form>

                        

                    </div>

                </div>




            </div>

        </div>

    </div>

</div>

</div>
<style>
    .modal-body video{
        width: 450px
    } 
</style>


<div class="modal pr-0" id="camera">
    <div class="modal-dialog modal-lg ">
        <div class="modal-content modal_content_custom_width mx-auto p-3" style="width: 40% !important;">
            <p type="button" class="info" data-dismiss="modal">
                <img class="float-right modal_close-icon"
                    src="{{ asset('asset/images/close.png') }}"> 
                </p>
            <div class="modal-body p-0 text-center">
            </div>
            <div class="modal-footer">
                <button id="capture" class="btn btn-primary">Capture</button>
            </div>
        </div>
    </div>
</div>



            

<section class="section_canddashboard section_empdashboard py-4 py-sm-5">

    <div class="container py-2">
     
        <div class="col-12 pb-4 kyc-box">
          <!-- Modal -->

                <div class="success d-flex justify-content-between align-items-center py-3" 
                    style="background-color: #3998de;color: #fff;padding: 10px 15px;border-radius: 10px;">

                    <div>
                        <h2 class="mb-0 pl-2 myprofile_font text-white">                           
                            KYC Verification
                        <p class="mb-0 text-white d-inline" style="font-size:13px"> (  <span class="text-white">Status :

                            @if($company->kyc_verified == 0)
                            Not Verified
                            @elseif ($company->kyc_verified == 1)
                            Under Verification
                            @elseif($company->kyc_verified == 2)
                            Completed                                
                            @elseif($company->kyc_verified == 3)
                            Resubmit
                            @elseif ($company->is_freeze)
                            Freezed
                            @endif

                            </span> )</p>
                    


                        </h2> 
                        @if($company->kyc_verified == 3 )

                        <p class="mb-0 pl-2 text-white pt-1" style="font-size:13px">
                            Resubmit kyc documents  <a href="#Interview" class="videoi text-white" style="
                            font-size: 18px;
                            font-weight: 600;
                            
                        " data-toggle="modal" data-target="#exampleModalCenter">   HERE </a>.
                        </p>


                        @elseif($company->kyc_verified == 2 )

                        @elseif ($company->kyc_verified == 1) 
                        <p class="mb-0 pl-2 text-white pt-1" style="font-size:13px">
                            KYC verification will be completed within 6 hours.
                        </p>
                        @elseif($company->kyc_verified == 0)
                       
                        <p class="mb-0 pl-2 text-white pt-1" style="font-size:13px">
                            Please Update Your KYC Information Within 7 days. View the List of Documents  <a href="#Interview" class="videoi text-white" style="
                            font-size: 18px;
                            font-weight: 600;
                            
                        " data-toggle="modal" data-target="#exampleModalCenter">   HERE </a>.
                        </p>


                        @endif
                        
                    </div>
                    
                       
                </div>
              

        </div>
      


        <div class="row">

            <div class="col-lg-4 col-xl-3 pr-lg-0">

                <div class="dash_box-right pb-5 px-4 h-100 v-icon stick_label position-relative ul-resume">





                    <div class="py-4">

                        @if(session()->has('message'))

                        <h2 class="mb-0 myprofile_font text-center text-black">

                            {{ session()->get('message') }}

                        </h2>

                        @endif



                        @if(session()->has('message1'))



                        <input type="hidden" name="" id="yes" value="{{ session()->get('message1') }}">



                        @endif

                    </div>

                    <div class="container">

                        <div class="modal pr-0" id="myModal">

                            <div class="modal-dialog modal-dialog-centered">

                                <div class="modal-content modal_content_custom_width mx-auto p-3">

                                    <p type="button" class="info mb-0" data-dismiss="modal"><img

                                            class="float-right modal_close-icon"

                                            src="{{ asset('/') }}asset/images/close.png"></p>

                                    <div class="modal-body p-0">

                                        <div class="collection_pic-box text-center mt-2 mt-md-0">

                                            <div class="collection_text px-lg-3 py-0">

                                                <h4 class="sign_head">Thanks for Signing up</h4>

                                                <p class="modal-title border-top my-4 pt-4 fs-18">With free account, you

                                                    can make 10 CV searches</p>

                                            </div>

                                        </div>



                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="text-center center_profile">



                        <div class="dash_pic">

                            <a href="javascript:void(0);">

                                @if($company->logo)

                                <img src="{{ asset('company_logos/'.$company->logo) }}"

                                    class="img-fluid canddashboard-userpic" style="width: 115px;height: 115px;">

                                @else

                                <img src="{{ asset('asset/images/dashboardpic.png') }}" style="width: 115px;height: 115px;" class="img-fluid  canddashboard-userpic">

                                @endif

                            </a>









                            <div class="py-2">

                                <h2 class="text-black dash_box-texthead mb-0">{{$company->name}}</h2>

                            </div>

                            <div class="">
                                {{-- <a href="mailto:{{ $company->email }}"class="text-white dash_color  pr-sm-3 "> --}}
                                    <i class="fa fa-envelope pr-2 text-black"

                                        aria-hidden="true"></i>{{$company->email}}
                                    {{-- </a> --}}



                            </div>

                            <div class="">
                                {{-- <a href="tel:+91 {{ $company->phone }}"class="text-white dash_color pr-sm-3"> --}}
                                    <i class="fa fa-phone text-white dash_color pr-2"
                                        aria-hidden="true">
                                    </i>
                                    {{$company->phone}}
                                {{-- </a> --}}



                            </div>







                        </div>



                        <div class="pt-4">



                            <div class="">

                                <label class="text-white dash_color">CV Access</label>

                                <div class="progress-container" data-percentage='30' value="" id="profile_complete">

                                    <div class="progress"></div>

                                    <div class="percentage">0%</div>

                                </div>

                            </div>
                            <!-- <div class="pt-3">

                               <span style="color:#007bff">KYC Status : </span><span>{{$company->is_freeze ? 'Verified': 'Not Verified' }} </span>

                            </div> -->
                            <!-- Button trigger modal -->


                       



                        </div>



                    </div>

                </div>

            </div>

            <div class="col-lg-8 col-xl-9 pt-4 pt-sm-5 pt-lg-0">



                <div class="dash_box p-4 h-100">

                    <div class="mx-auto col-lg-7 pb-4 px-0">

                        <div class="success d-flex justify-content-between align-items-center"

                            style="background-color: #3998de;color: #fff;padding: 8px 15px;border-radius: 30px;">

                            <div>

                                <h6 class="mb-0 text-white pl-2">

                                    @php

                                    $now = \Carbon\Carbon::now();

                                    $renew = \Carbon\Carbon::now()->subDay('5');

                                    @endphp



                                    <!--Upgrade a Plan-->
                                    Subscription

                                    </h2>

                                    {{-- <p class="mb-0 text-white" style="font-size:13px"> your Plan will be Expired on : {{ \Carbon\Carbon::parse($company->package_end_date)->format('d-m-Y') }}

                                    </p> --}}

                            </div>

                            <a href="{{ route('pricing') }}" class="btn btn-plan py-0 px-2">Buy now</a>

                        </div>

                    </div>

                    <div class="row justify-content-center">





                        <div class="col-6 col-md-3 text-center px-2 pb-3">

                            <div class="vertical">



                            <h3 class="cand_dtxt">Resumes Access Quota</h3>



                            <h2 class="mx-auto py-0 canddash_head mb-0">{{$company->cvs_quota??0}}</h2>

                            </div>

                        </div>



                        <div class="col-6 col-md-3 text-center px-2 pb-3">
                            <div class="vertical">


                            <h3 class="cand_dtxt">Unlocked Resumes</h3>


                            <h2 class="mx-auto py-0 canddash_head mb-0">{{$company->availed_cvs_quota??0}}</h2>

                            </div>

                        </div>







                        <div class="col-6 col-md-3 text-center px-2 pb-3">

                            <div class="vertical">



                            <h3 class="cand_dtxt">Remaining Resume Access</h3>



                            <h2 class="mx-auto py-0 canddash_head mb-0">
                                @if($balance > 0) {{$balance}} @else 0 @endif 
                                </h2>

                            </div>

                        </div>



                        <?php 

                            

                            $folder=\App\Collection::where('user_id',$company->id)->get();
                            $jobs = \App\PostJob::where('company_id',$company->id)->get();
                            $ids = [];
                            foreach ($jobs as $key => $job) {
                                $ids[] = $job->id;

                            }
                            $jobsappllied = \App\JobApply::whereIn('job_id',$ids)->count();
                            $activeJobs = \App\PostJob::where('company_id',$company->id)->where('status',1)->count();



                            ?>





                        <div class="col-6 col-md-3 text-center px-2 pb-3">

                            <div class="vertical">



                            <h3 class="cand_dtxt">Total Job Applicants</h3>



                            <h2 class="mx-auto py-0 canddash_head mb-0">{{$jobsappllied}}</h2>

                            </div>

                        </div>





                        <div class="col-6 col-md-3 text-center px-2 pb-3">

                            <div class="vertical">

                            <h3 class="cand_dtxt">Bulk Email Quota</h3>



                            <h2 class="mx-auto py-0 canddash_head mb-0">{{$company->email_quota??0}}</h2>

                            </div>

                        </div>



                        <div class="col-6 col-md-3 text-center px-2 pb-3">

                            <div class="vertical">

                            <h3 class="cand_dtxt">Emails Utilized</h3>



                            <h2 class="mx-auto py-0 canddash_head mb-0">{{$company->availed_email_quota??0}}</h2>

                            </div>

                        </div>



                        <div class="col-6 col-md-3 text-center px-2 pb-3">

                            <div class="vertical">

                            <h3 class="cand_dtxt">Remaining Email Quota</h3>



                            <h2 class="mx-auto py-0 canddash_head mb-0">{{$email_balance??0}}</h2>

                            </div>

                        </div>

                        <div class="col-6 col-md-3 text-center px-2 pb-3">

                            <div class="vertical">

                            <h3 class="cand_dtxt">Active Jobs</h3>



                            <h2 class="mx-auto py-0 canddash_head mb-0">{{ $activeJobs }}/{{ count($jobs) }}</h2>

                            </div>

                        </div>



                    </div>

                    <div class="row align-items-center pt-2 pt-sm-4">

                        <div class="col-md-6">

                            <p class="mb-0">For queries/support, mail us: <a href="mailto:hello@zeronoticeperiod.com">hello@zeronoticeperiod.com</a><br> <a href="tel:+91 9035479715"

                                    class="text-white dash_color pr-sm-3"><i

                                        class="fa fa-phone text-white dash_color pr-2"

                                        aria-hidden="true"></i>+91-9035479715</a></p>

                        </div>

                        

                    <div class="col-md-6 text-center text-sm-right pt-4 pt-md-0">

                        <a href="{{ url('post-job')}}"

                            class="d-inline-block text-white py-2 signin_button rounded px-3 mr-2">Post Job <i class="pl-3 fa fa-arrow-right text-white" aria-hidden="true"></i></a>

                        <a href="{{ url('cv-search')}}"

                            class="d-inline-block text-white py-2 signin_button rounded px-3">Search

                            CVs <i class="pl-3 fa fa-arrow-right text-white" aria-hidden="true"></i></a>

                    </div>

                    </div>



                </div>



            </div>

        </div>























    </div>



</section>















@include('includes.footer')



@endsection



@push('scripts')
<script>
let videoStream;

document.getElementById('openCamera').addEventListener('click', function() {
  if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
    navigator.mediaDevices.getUserMedia({ video: true })
      .then(function(stream) {
        videoStream = stream; 
        var video = document.createElement('video');
        video.srcObject = stream;
        video.autoplay = true;

        $('#camera').find('.modal-body').html(video);
        $('#exampleModalCenter').hide();
        $('#camera').show();
        // document.body.appendChild(video);
      })
      .catch(function(error) {
        console.error('Error accessing the camera:', error);
      });
  } else {
    alert('Your browser does not support the getUserMedia API');
  }
});

document.getElementById('capture').addEventListener('click', function() {
  if (videoStream) {
   
    var canvas = document.createElement('canvas');
    var context = canvas.getContext('2d');
    canvas.width = videoStream.getVideoTracks()[0].getSettings().width;
    canvas.height = videoStream.getVideoTracks()[0].getSettings().height;

    context.drawImage(document.querySelector('video'), 0, 0, canvas.width, canvas.height);
    console.log(context);

    $('.selfieImage').attr('src', canvas.toDataURL('image/png'));
    $('.selfieImage').removeClass('d-none');

    var selfieDataInput = document.getElementById('selfieData');
    selfieDataInput.value = canvas.toDataURL('image/png');

    videoStream.getTracks().forEach(track => track.stop());
    $('#camera').find('.modal-body').empty();
    $('#exampleModalCenter').show();
    $('#camera').hide();
  } else {
    alert('Please open the camera first');
  }
});
$('#camera  img').on('click',function () {
    videoStream.getTracks().forEach(track => track.stop());
    $('#camera').find('.modal-body').empty();
    $('#exampleModalCenter').show();
    $('#camera').hide();
})
</script>











<script>

var value = Math.round({{$company -> availed_cvs_quota??0}}/{{$company->cvs_quota??0}}*100)



        console.log(value);



        if (value > 100) {



            value = 100



        }





        $("#profile_complete").attr("data-percentage", value.toString());


        $(document).ready(function() {



            const progressContainer = document.querySelector('.progress-container');



            // initial call

            setPercentage();







            function setPercentage() {

                const percentage = progressContainer.getAttribute('data-percentage') + '%';



                const progressEl = progressContainer.querySelector('.progress');

                const percentageEl = progressContainer.querySelector('.percentage');



                progressEl.style.width = percentage;

                percentageEl.innerText = percentage;

                percentageEl.style.left = percentage;

            }

        });

</script>





<script type="text/javascript">

// $(window).on('load', function() {

//     var dat = $('#yes').val();





//     if (dat == 0) {

//         $('#myModal').modal('show');



//     }

//     // 

// });




$(document).ready(function() {
    // Hide all the divs initially
    $('.freelancer, .sole, .partnership, .limited, .private ,#selfieDiv').hide();

    // Show/hide divs based on selected option
    $('#select_document_type').change(function() {
        var selectedOption = $(this).val();

        // Hide all divs
        $('.freelancer, .sole, .partnership, .limited, .private,#selfieDiv').hide();

        // Show the div based on selected option
        $('#selfieDiv').show();
        $('#' + selectedOption).show();
    });

    // Validation and storing values on form submission
    $('form').submit(function(e) {
        e.preventDefault();
       

        var selectedOption = $('#select_document_type').val();
        var isValid = true;

        // Perform validation based on selected option
        switch (selectedOption) {
            case 'freelancer':
                isValid = validateFreelancer();
                break;
            case 'sole':
                isValid = validateSole();
                break;
            case 'partnership':
                isValid = validatePartnership();
                break;
            case 'limited':
                isValid = validateLimited();
                break;
            case 'private':
                isValid = validatePrivate();
                break;
        }

        if (isValid) {
            // Store the form values and submit the form
            storeFormValues();           
            this.submit();
        }
    });

    function validateFreelancer() {
    var isValid = true;
    var pancard = $('input[name="pancard"]').val();
    var aadharcard = $('input[name="aadharcard"]').val();
    var selfie = $('input[name="selfie"]').val();

    $('.freelancer .new_error_class').text(''); // Clear previous error messages
    // if (!selfie) {
    //     isValid = false;
    //     $('.selfie .selfie-error').text('Please upload selfie');
    // }

    if (!pancard) {
        isValid = false;
        $('.freelancer .freelancer-pancard-error').text('Please upload PAN Card');
    }

    if (!aadharcard) {
        isValid = false;
        $('.freelancer .freelancer-aadharcard-error').text('Please upload Aadhar Card');
    }

    return isValid;
}

function validateSole() {
    var isValid = true;
    var gstCertificate = $('input[name="sole_gstcertificate"]').val();
    var solepancard = $('input[name="sole_pancard"]').val();
    var soleaadharcard = $('input[name="sole_aadharcard"]').val();
    var selfie = $('input[name="selfie"]').val();

    $('.sole .new_error_class').text(''); // Clear previous error messages
    // if (!selfie) {
    //     isValid = false;
    //     $('.selfie .selfie-error').text('Please upload selfie');
    // }


    if (!gstCertificate) {
        isValid = false;
        $('.sole .sole_gstcertificate-error').text('Please upload GST Certificate');
    }

    if (!solepancard) {
        isValid = false;
        $('.sole .sole_pancard-error').text('Please upload PAN Card');
    }

    if (!soleaadharcard) {
        isValid = false;
        $('.sole .sole_aadharcard-error').text('Please upload Aadhar Card');
    }

    return isValid;
}

function validatePartnership() {
    var isValid = true;
    var partnershipgstCertificate = $('input[name="partnership_registrationcertificate"]').val();
    var partnershippancard = $('input[name="partnership_pancard"]').val();
    var partnershipaadharcard = $('input[name="partnership_aadharcard"]').val();
    var selfie = $('input[name="selfie"]').val();

    $('.partnership .new_error_class').text(''); // Clear previous error messages
    // if (!selfie) {
    //     isValid = false;
    //     $('.selfie .selfie-error').text('Please upload selfie');
    // }

    if (!partnershipgstCertificate) {
        isValid = false;
        $('.partnership .partnership_registrationcertificate-error').text('Please upload Registration Certificate');
    }

    if (!partnershippancard) {
        isValid = false;
        $('.partnership .partnership_pancard-error').text('Please upload PAN Card');
    }

    if (!partnershipaadharcard) {
        isValid = false;
        $('.partnership .partnership_aadharcard-error').text('Please upload Proof of Legal');
    }

    return isValid;
}

function validateLimited() {
    var isValid = true;
    var limitedgstCertificate = $('input[name="limited_certificateofincorporation"]').val();
    var limitedpancardpancard = $('input[name="limited_pancardllp"]').val();
    var selfie = $('input[name="selfie"]').val();
    $('.limited .new_error_class').text(''); // Clear previous error messages
    // if (!selfie) {
    //     isValid = false;
    //     $('.selfie .selfie-error').text('Please upload selfie');
    // }


    if (!limitedgstCertificate) {
        isValid = false;
        $('.limited .limited_certificateofincorporation-error').text('Please upload Certificate of Incorporation document');
    }

    if (!limitedpancardpancard) {
        isValid = false;
        $('.limited .limited_pancardllp-error').text('Please upload PAN of LLP');
    }

    return isValid;
}

function validatePrivate() {
    var isValid = true;
    var certificateofincorporation = $('input[name="private_certificateofincorporation"]').val();
    var pancardcompany = $('input[name="private_pancardcompany"]').val();
    var commencementcertificate = $('input[name="private_commencementcertificate"]').val();
    var proofofcompany = $('input[name="private_proofofcompany"]').val();
    var selfie = $('input[name="selfie"]').val();

    $('.private .new_error_class').text(''); // Clear previous error messages
    // if (!selfie) {
    //     isValid = false;
    //     $('.selfie .selfie-error').text('Please upload selfie');
    // }


    if (!certificateofincorporation) {
        isValid = false;
        $('.private .private_certificateofincorporation-error').text('Please upload Certificate of incorporation');
    }

    if (!pancardcompany) {
        isValid = false;
        $('.private .private_pancardcompany-error').text('Please upload PAN of the Company');
    }

    if (!commencementcertificate) {
        isValid = false;
        $('.private .private_commencementcertificate-error').text('Please upload Business commencement certificate');
    }

    if (!proofofcompany) {
        isValid = false;
        $('.private .private_proofofcompany-error').text("Please upload Proof of the company's name");
    }

    return isValid;
}


    // Validation functions for other options (partnership, limited, private) can be added similarly

    function storeFormValues() {
        // Get the form values based on the selected option and store them
        // Example code:
        var selectedOption = $('#select_document_type').val();
        var formValues = {};

        switch (selectedOption) {
            case 'freelancer':
                formValues.pancard = $('input[name="pancard"]').val();
                formValues.aadharcard = $('input[name="aadharcard"]').val();
                break;
                
            case 'sole':             

                formValues.gstCertificate = $('input[name="sole_gstcertificate"]').val();
                formValues.solepancard = $('input[name="sole_pancard"]').val();
                formValues.soleaadharcard = $('input[name="sole_aadharcard"]').val();
                break;

            case 'partnership':          

                formValues.partnershipgstCertificate = $('input[name="partnership_registrationcertificate"]').val();
                formValues.partnershippancard = $('input[name="partnership_pancard"]').val();
                formValues.partnershipaadharcard = $('input[name="partnership_aadharcard"]').val();

                break;  

            case 'limited':
                
                formValues.limitedgstCertificate = $('input[name="limited_certificateofincorporation"]').val();
                formValues.pancard = $('input[name="limited_pancardllp"]').val();
               
                break;   
            case 'private':
             
                formValues.certificateofincorporation = $('input[name="private_certificateofincorporation"]').val();
                formValues.pancardcompany = $('input[name="private_pancardcompany"]').val();
                formValues.commencementcertificate = $('input[name="private_commencementcertificate"]').val();
                formValues.proofofcompany = $('input[name="private_proofofcompany"]').val();
                
                break;  

            // Store form values for other options (partnership, limited, private) similarly
        }

        // Store the formValues object or perform any other action with the values
        console.log(formValues);
    }
});


</script>















@endpush