@extends('layouts.app')

@section('content')

@include('includes.header')





<section class="postjob-listing py-5 section_canddashboard">
    <div class="container">
        <div class="row">
            <div class="col-lg-7 pr-lg-3 pl-lg-0 p-0">
                <div class="boxing rounded dash_box-right my-4">
                    <div class="row pt-3">
                        <div class="col-lg-9 col-md-10">
                            <div class="row">
                            <div class="col-lg-2 pr-0 mr-0 text-center col-3 col-md-2 detail-industry">
                            <img src="{{asset('/')}}asset/images/industry-logo.png">
                            </div>
                            <div class="col-lg-10 pl-0 ml-0 col-9 col-md-10">
                                <h2 class="line_change_detail font-weight-bold mb-0">Frontend,HTML,Bootstrap,Css,ReactJs,Javascript Developer </h2>
                                <ul class="list-inline pt-2">
                                    <li class="list-inline-item"><i class="fa fa-building-  o pr-2"></i>Nexevo Technologies</li>
                                    <li class="list-inline-item"><i class="fa fa-map-marker pr-2"></i>Banglore</li>
                                </ul>
                            </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-2 my-auto text-md-right">
                            <button type="submit" class="btn btn-sent-apply mb-2 mb-sm-4 mr-2" data-toggle="modal" data-target="#firstmodal" id="apply-1">Apply</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6 pt-2 pt-lg-0 border-top">
                                <ul class="date pt-3">
                                    <li class="list-inline-item"><span>Job Applicants : </span>70</li>
                                </ul>
                        </div>
                        <div class="col-6 pt-2 pt-lg-0 border-top text-md-right">
                                <ul class="date pt-3">
                                    <li class="list-inline-item"><span>Posted Date : </span>04-05-2023</li>
                                </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 pl-lg-3 pr-lg-0 p-0">
                <div class="boxing-job company pt-4 mt-2 px-4 pb-2 my-4">
                    <h2>About Company</h2>
                    <p class="text-white">We are one of India's leading providers of human resource services in the organized segment delivering a broad range of human resource services to various industries with a vision of putting India to work.</p>
                    <div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="row">
                    <div class="col-lg-7 pr-lg-3 pl-lg-0 p-0">
                        <div class="boxing rounded justify-content-center bg-white px-lg-5">
                            <h3 class="pt-4">Job Description</h3>
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptates non tempora, quibusdam blanditiis ex atque consequatur sint veritatis quae dicta natus quia dolor. Iusto dolor deleniti voluptates, suscipit mollitia assumenda?</p>
                            <h3 class="pt-4">Job Overview</h3>
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptates non tempora, quibusdam blanditiis ex atque consequatur sint veritatis quae dicta natus quia dolor. Iusto dolor deleniti voluptates, suscipit mollitia assumenda?</p>
                            <ul class="pl-4">
                                <li>Lorem ipsum dolor sit amet consectetur adipisicing elit. </li>
                                <li>Lorem ipsum dolor sit amet consectetur adipisicing elit. </li>
                                <li>Lorem ipsum dolor sit amet consectetur adipisicing elit. </li>
                                <li>Lorem ipsum dolor sit amet consectetur adipisicing elit. </li>
                                <li>Lorem ipsum dolor sit amet consectetur adipisicing elit. </li>
                                <li>Lorem ipsum dolor sit amet consectetur adipisicing elit. </li>
                                <li>Lorem ipsum dolor sit amet consectetur adipisicing elit. </li>
                                <li>Lorem ipsum dolor sit amet consectetur adipisicing elit. </li>
                            </ul>
                            <h3 class="pt-4">Roles & Responsibilities</h3>
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptates non tempora, quibusdam blanditiis ex atque consequatur sint veritatis quae dicta natus quia dolor. Iusto dolor deleniti voluptates, suscipit mollitia assumenda?</p>
                            <ul class="pl-4">
                                <li>Lorem ipsum dolor sit amet consectetur adipisicing elit. </li>
                                <li>Lorem ipsum dolor sit amet consectetur adipisicing elit. </li>
                                <li>Lorem ipsum dolor sit amet consectetur adipisicing elit. </li>
                                <li>Lorem ipsum dolor sit amet consectetur adipisicing elit. </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-5 pl-lg-3 pr-lg-0 p-0">
                        <div class="boxing rounded justify-content-center bg-white px-lg-5 pb-4">
                            <h3 class="pt-4">Job Summary</h3>
                            <ul class="detail-list">
                                <li class="pt-3"><i class="fa fa-money mr-2"></i><span>Salary Range :</span> 2lakh - 3lakh a year</li>
                                <li class="pt-3"><i class="fa fa-suitcase mr-2"></i><span>Job Type :</span> Full time </li>
                                <li class="pt-3"><i class="fa fa-calendar mr-2"></i><span>Experience :</span> 0-1 years</li>
                                <li class="pt-3"><i class="fa fa-user-plus mr-2"></i><span>Number Of Openings:</span> 20</li>
                            </ul>
                            <h3 class="pt-4">Skills</h3>
                            <ul class="list-inline developer">   
                                <li class="list-inline-item terms mb-1">HTML</li>
                                <li class="list-inline-item terms mb-1">Bootstrap</li>
                                <li class="list-inline-item terms mb-1">SASS</li>
                                <li class="list-inline-item terms mb-1">LESS</li>
                                <li class="list-inline-item terms mb-1">Media Queries</li>
                            </ul>
                        </div>
                        <div class="boxing rounded justify-content-center bg-white px-lg-5 pb-4 job-detail-img">
                            <h3 class="pt-4">Lorem Ipsum</h3>
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptates non tempora, quibusdam blanditiis ex atque consequatur sint veritatis quae dicta natus quia dolor. Iusto dolor deleniti voluptates, suscipit mollitia assumenda?</p>
                            <a href="{{ url('jobs') }}">Find More Jobs</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>








@include('includes.footer')

@endsection



<!--cv Search Plan Expire modal -->

<div class="container">

    <div class="modal" id="firstmodal">

        <div class="modal-dialog modal-dialog-centered">

            <div class="modal-content modal_content_custom_width mx-auto p-3">

                <p type="button" class="info mb-0" data-dismiss="modal"><img class="float-right modal_close-icon"

                        src="{{ asset('/') }}asset/images/close.png"></p>

                <div class="modal-body py-0">

                    <div class="collection_pic-box mt-2 mt-md-0">
                        <h4 class="font_color text-center">Cover Letter</h4>
                        <form class="px-3 px-sm-5 priceform row" action="http://127.0.0.1:8000/company/register" method="POST" id="priceform1">
                            <div class="col-12">
                                <p class="sign_fontsize mb-2 pt-3">Message<span class="text-danger px-1">*</span></p>
                                <textarea class="w-100 py-2 px-3 signin_input rounded summernote" placeholder="Message" id="description" name="description"  rows="5"></textarea>

                                <button type="button" class="btn btn-sent mb-2 mb-sm-4 mr-2 mt-4" data-toggle="modal" data-target="#PlanExpire-1" id="apply-now">Apply Now</button>

                                <!-- <input type="text" class="w-100 py-2 px-3 signin_input rounded" placeholder="Location" maxlength="100" name="Location" id="Location" value=""> -->
                            </div>
                        </form>

                        <div class="collection_text px-lg-3 py-0">

                            <!-- <h3 class="line_change font_size">Alert</h3>

                            <p class="fs-18 mb-1">Thank you for Applying job.</p>
                            <p>Our recruiters will get back to you soon.....</p> -->

                            <div class="error_message1 " id=""></div>

                        </div>

                    </div>

                </div>


            </div>

        </div>

    </div>

</div>



<!-- modal end -->



<!--cv Search Plan Expire modal -->

<div class="container">

    <div class="modal" id="second-modal">

        <div class="modal-dialog modal-dialog-centered">

            <div class="modal-content modal_content_custom_width mx-auto p-3">

                <p type="button" class="info mb-0" data-dismiss="modal"><img class="float-right modal_close-icon"

                        src="{{ asset('/') }}asset/images/close.png"></p>

                <div class="modal-body py-0">

                    <div class="collection_pic-box mt-2 mt-md-0 text-center">

                                <!-- <input type="text" class="w-100 py-2 px-3 signin_input rounded" placeholder="Location" maxlength="100" name="Location" id="Location" value=""> -->
                            </div>
                        </form>

                        <div class="px-lg-3 py-0 text-center">

                            <p class="fs-18 mb-1">Thank you for Applying job.</p>
                            <p>Our recruiters will get back to you soon.....</p>

                            <div class="error_message1 " id=""></div>

                        </div>

                    </div>

                </div>


            </div>

        </div>

    </div>

</div>



<!-- modal end -->


<script src="{{asset('/')}}asset/script/jquery-3.5.1.min.js"></script>

<script>

$(document).ready(function(){
//set button id on click to hide first modal
$("#apply-now").on( "click", function() {
  
            $('#firstmodal').modal('hide');  
            $('#second-modal').modal('show'); 

    });
    

});

    function searchcandidates() {



var form = $('#home_search');

$.ajax({

    url: form.attr('action'),

    type: form.attr('method'),

    data: form.serialize(),

    dataType: 'json',

    success: function (response) {



     //   alert('success');



        console.log(response.users);



          $("#data-wrapper").empty();



           $("#data-wrapper").append(response.users);

 

  

    },

    error: function (json) {

        if (json.status === 422) {



    var resJSON = json.responseJSON;



    $('.help-block').html('');



    $.each(resJSON.errors, function(key, value) {



        $('.' + key + '-error').html('<strong class="text-danger">' + value +

            '</strong>');



        $('#div_' + key).addClass('has-error');



    });



} else {



    // Error



    // Incorrect credentials



    // alert('Incorrect credentials. Please try again.')



}

        if (json.status === 400) {



            $("#PlanExpire").modal('show');

           

        } 

    }

});

}
</script>



<script>
    function searchcandidates() {



var form = $('#home_search');

$.ajax({

    url: form.attr('action'),

    type: form.attr('method'),

    data: form.serialize(),

    dataType: 'json',

    success: function (response) {



     //   alert('success');



        console.log(response.users);



          $("#data-wrapper").empty();



           $("#data-wrapper").append(response.users);

 

  

    },

    error: function (json) {

        if (json.status === 422) {



    var resJSON = json.responseJSON;



    $('.help-block').html('');



    $.each(resJSON.errors, function(key, value) {



        $('.' + key + '-error').html('<strong class="text-danger">' + value +

            '</strong>');



        $('#div_' + key).addClass('has-error');



    });



} else {



    // Error



    // Incorrect credentials



    // alert('Incorrect credentials. Please try again.')



}

        if (json.status === 400) {



            $("#PlanExpire-1").modal('show');

           

        } 

    }

});

}
</script>


