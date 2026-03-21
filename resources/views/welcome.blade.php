@extends('layouts.app')



@section('content')



<!-- Header start -->



@include('includes.header')



<!-- Header end -->



<!-- Search start -->





<style>

    select {

   visibility: hidden;

}

.exampleSearch .select2-selection {

    min-height: 55px !important; 

    height: 100% !important; 

    display:flex!important;

    

}

input#search_data-tokenfield {

    height:36px;

}

.font_size1 {
    color: #0642a9;
    font-size: 35px;
    font-family: "proximanova-regular";
}

.font_size2 {
    color: #0642a9;
    font-size: 32px;
    font-family: "proximanova-bold";
}

</style>

  <style>

      input:focus::placeholder {

        color: transparent!important;

      }

    </style>



<!-- Search End -->



<!-- Top Employers start -->



<section class="header mr-auto">



    <div class="container">



        <div class="row line">


            <div class="col-lg-12 px-2 pt-md-4 text-center">



                <div class="parah pt-4 px-1 px-sm-5 px-lg-0">
                    

                    @if(Auth::check() || Auth::guard('company')->check())

                    <span

                        class="line_change font_size1">  Verified Database of IT & Non IT Talent With ZeroNoticePeriod</span>

                    @else

                    <span

                        class="line_change font_size1">Verified Database of IT & Non IT Talent With ZeroNoticePeriod</span>

                     @endif
                </div>



                <div class="font_size2 pb-3 pt-1">HIRE QUICK!</div>



            </div>

        </div>



        <?php
   
            $query = \App\User::orderBy('updated_at', 'desc');
            
            $notice_period = [1];
            
            
                $query->whereHas('profileNop', function($q) use($notice_period){
                    $q->whereIn('nop_days',$notice_period);
            });
            
             $users = $query->paginate(5);

    
        ?>
 
      <div  id="data-wrapper">



      @include("welcome-search")



      </div>

                                                    <!-- Data Loader -->

    <!-- <div class="auto-load text-center">

        <svg version="1.1" id="L9" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"

            x="0px" y="0px" height="60" viewBox="0 0 100 100" enable-background="n allew 0 0 0 0" xml:space="preserve">

            <path fill="#000"

                d="M73,50c0-12.7-10.3-23-23-23S27,37.3,27,50 M30.9,50c0-10.5,8.5-19.1,19.1-19.1S69.1,39.5,69.1,50">

                <animateTransform attributeName="transform" attributeType="XML" type="rotate" dur="1s"

                    from="0 50 50" to="360 50 50" repeatCount="indefinite" />

            </path>

        </svg>

    </div> -->



 







</section>







<!-- number Board -->







<section class="number_board py-4 py-lg-5">



    <div class="container">



        <div class="row">



            <div class="col-12 number_board-counter">



                <div class="style_text text-center">



                    ZeroNoticePeriod Metrics



                </div>

                <?php 



                $counter=\App\Counter::all()->take(1);



                

              

                



                //  echo $counter;



                ?>

                @foreach($counter as $c)



           



                @endforeach



                <div class="number_board-counter  row col-lg py-sm-4 mx-0 my-0">



                    <div class="col-md-6 col-lg-5 offset-lg-1 number_board_1 text-center">



                        <div class="run_number">



                            <span class="run_number counter" data-count="{{$c->counter}}">0</span>+

                        </div>



                        <p class="typeo_class">NON IT IMMEDIATE HIRES</p>



                    </div>



                    <div class="col-md-5 number_board_2 md-6-p-0 mt-3 mt-md-0 text-center">



                        <div class="run_number"><span class="run_number counter" data-count="{{$c->counter1}}">0</span>+

                        </div>



                        <p class="typeo_class">IT IMMEDIATE HIRES</p>



                    </div>



                </div>



            </div>



        </div>



    </div>



</section>







<!--image section-->







<section class="base_img py-lg-5">



    <div class="container">



        <div class="list_img px-lg-0 pb-4 text-center">Why ZeroNoticePeriod?</div> 



        <div class="row">





            <div class="col-lg-6 text-left align-self-center">



                <div class="whyus_last-title  px-lg-0 py-4 text-center">Hello Recruiter!</div>

                <video width="100%" height="335" controlsList="nodownload"  controls>

                  <source src="{{ asset('/') }}asset/videos/employer.mp4" type="video/mp4">  

                </video>

              

    {{--                 <iframe class="iframe_img-aligin" width="100%" height="335" src="https://www.youtube.com/embed/OwLk3JhtevI" title="YouTube video player"



                            frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" controlsList="nodownload"allowfullscreen>



                        </iframe> --}}

              </div>



            <div class="col-lg-6 text-left align-self-center">



                <div class="whyus_last-title  px-lg-0 py-4 text-center">Hello Jobseeker!</div>



              

                    <video width="100%" height="335" controlsList="nodownload"  controls>

                  <source src="{{ asset('/') }}asset/videos/jobseeker.mp4" type="video/mp4">  

                </video>

              </div>





              







         



        </div>



    </div>



</section>







<!--image-->







{{-- <section class="content-head text-center py-5">



    <div class="container">



        <div class="head1 pb-4 mb-2">



            <div class="how_text">How it works</div>



        </div>



        <div class="row">



            <div class="col-md-4 pt-3">



                <img src="asset/images/voting (1).png">



                <div class="line">Register</div>



            </div>



            <div class="col-md-4 pt-3">



                <img src="asset/images/book (2).png">



                <div class="line">Buy database<br>subscriptions</div>



            </div>



            <div class="col-md-4 pt-3">



                <img src="asset/images/login.png">



                <div class="line">Login to access<br>candidate database</div>



            </div>



        </div>



    </div>



</section> --}}



<section class="section_home-clients pb-5 mb-sm-3">

    <div class="container">

        <div class="row">

            <div class="col-12">

                <div class="list_img text-center mb-sm-4">Top Employers in India</div>

                <div id="carouselExampleControls" class="carousel slide py-4" data-ride="carousel">

                    <div class="carousel-inner">

                        <div class="carousel-item active">

                            <div class="row px-xl-5">

                                <div class="col-6 col-sm-4 col-lg-3 py-3">
                                    <div><img class="img-fluid" src="{{ asset('/') }}asset/images/client-logo1.png" alt="First slide"></div>
                                </div>

                                <div class="col-6 col-sm-4 col-lg-3 py-3">
                                    <div><img class="img-fluid" src="{{ asset('/') }}asset/images/client-logo2.png" alt="First slide"></div>
                                </div>

                                <div class="col-6 col-sm-4 col-lg-3 py-3">
                                    <div><img class="img-fluid" src="{{ asset('/') }}asset/images/client-logo3.png" alt="First slide"></div>
                                </div>

                                <div class="col-6 col-sm-4 col-lg-3 py-3">
                                    <div><img class="img-fluid" src="{{ asset('/') }}asset/images/client-logo4.png" alt="First slide"></div>
                                </div>


                            </div>

                        </div>

                        <div class="carousel-item">

                            <div class="row px-xl-5">

                                <div class="col-6 col-sm-4 col-lg-3 py-3">
                                    <div><img class="img-fluid" src="{{ asset('/') }}asset/images/client-logo5.png" alt="First slide"></div>
                                </div>

                                <div class="col-6 col-sm-4 col-lg-3 py-3">
                                    <div><img class="img-fluid" src="{{ asset('/') }}asset/images/client-logo6.png" alt="First slide"></div>
                                </div>

                                <div class="col-6 col-sm-4 col-lg-3 py-3">
                                    <div><img class="img-fluid" src="{{ asset('/') }}asset/images/client-logo7.png" alt="First slide"></div>
                                </div>

                                <div class="col-6 col-sm-4 col-lg-3 py-3">
                                    <div><img class="img-fluid" src="{{ asset('/') }}asset/images/client-logo8.png" alt="First slide"></div>
                                </div>

                            </div>

                        </div>

                        <div class="carousel-item">

                            <div class="row px-xl-5">

                                <div class="col-6 col-sm-4 col-lg-3 py-3">
                                    <div><img class="img-fluid" src="{{ asset('/') }}asset/images/client-logo9.png" alt="First slide"></div>
                                </div>

                                <div class="col-6 col-sm-4 col-lg-3 py-3">
                                    <div><img class="img-fluid" src="{{ asset('/') }}asset/images/client-logo10.png" alt="First slide"></div>
                                </div>

                                <div class="col-6 col-sm-4 col-lg-3 py-3">
                                    <div><img class="img-fluid" src="{{ asset('/') }}asset/images/client-logo11.png" alt="First slide"></div>
                                </div>

                                <div class="col-6 col-sm-4 col-lg-3 py-3">
                                    <div><img class="img-fluid" src="{{ asset('/') }}asset/images/client-logo12.png" alt="First slide"></div>
                                </div>
                                    

                            </div>

                        </div>

                        <div class="carousel-item">

                            <div class="row px-xl-5">

                                <div class="col-6 col-sm-4 col-lg-3 py-3">
                                    <div><img class="img-fluid" src="{{ asset('/') }}asset/images/client-logo13.png" alt="First slide"></div>
                                </div>

                                <div class="col-6 col-sm-4 col-lg-3 py-3">
                                    <div><img class="img-fluid" src="{{ asset('/') }}asset/images/client-logo14.png" alt="First slide"></div>
                                </div>

                                <div class="col-6 col-sm-4 col-lg-3 py-3">
                                    <div><img class="img-fluid" src="{{ asset('/') }}asset/images/client-logo16.png" alt="First slide"></div>
                                </div>

                                <div class="col-6 col-sm-4 col-lg-3 py-3">
                                    <div><img class="img-fluid" src="{{ asset('/') }}asset/images/client-logo17.png" alt="First slide"></div>
                                </div>

                            </div>

                        </div>

                         <div class="carousel-item">

                        <div class="row px-xl-5">

                                <div class="col-6 col-sm-4 col-lg-3 py-3">
                                    <div><img class="img-fluid" src="{{ asset('/') }}asset/images/client-logo19.png" alt="First slide"></div>
                                </div>

                                <div class="col-6 col-sm-4 col-lg-3 py-3">
                                    <div><img class="img-fluid" src="{{ asset('/') }}asset/images/client-logo20.png" alt="First slide"></div>
                                </div>

                                <div class="col-6 col-sm-4 col-lg-3 py-3">
                                    <div><img class="img-fluid" src="{{ asset('/') }}asset/images/client-logo21.png" alt="First slide"></div>
                                </div>

                                <div class="col-6 col-sm-4 col-lg-3 py-3">
                                    <div><img class="img-fluid" src="{{ asset('/') }}asset/images/client-logo22.png" alt="First slide"></div>
                                </div>

                            </div>

                        </div>

                        <div class="carousel-item">

                            <div class="row px-xl-5">
    
                                    <div class="col-6 col-sm-4 col-lg-3 py-3">
                                        <div><img class="img-fluid" src="{{ asset('/') }}asset/images/client-logo23.png" alt="First slide"></div>
                                    </div>
    
                                </div>
    
                            </div>

                    </div>

                    <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">

                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>

                        <span class="sr-only">Previous</span>

                    </a>

                    <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">

                        <span class="carousel-control-next-icon" aria-hidden="true"></span>

                        <span class="sr-only">Next</span>

                    </a>

                </div>

            </div>

        </div>

    </div>

</section>



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

                            <!--<h3 class="line_change font_size">Alert</h3>-->

                            <p class="fs-18 mb-1">You have used your quota of 10 searches with a Free

                                account. Please purchase the Subscription to find talent FASTER!.</p>

                            <div class="error_message1 " id=""></div>

                        </div>

                    </div>

                </div>

                <div class="d-flex justify-content-center px-3 border-0 py-3">

                    <a href="{{ route('pricing') }}" class="btn  btn_style btn_style_height">Subscribe Now</a>

                </div>

            </div>

        </div>

    </div>

</div>



<!-- modal end -->

<!--Sign As Employer modal -->

<div class="container">

    <div class="modal" id="LoginasEmployer">

        <div class="modal-dialog modal-dialog-centered">

            <div class="modal-content modal_content_custom_width mx-auto p-3">

                <p type="button" class="info mb-0" data-dismiss="modal"><img class="float-right modal_close-icon"

                        src="{{ asset('/') }}asset/images/close.png"></p>

                <div class="modal-body p-0">

                    <div class="collection_pic-box text-center mt-2 mt-md-0">

                        <div class="collection_text px-lg-3 py-0">

                            <h4 class="sign_head">Hello Employer!</h4>

                            <!--<p class="modal-title border-top my-4 pt-4 fs-18">To view the resume, click the button below.</p>-->

                        </div>

                    </div>

                </div>

                <div class="d-flex justify-content-center px-3 border-0 pb-3">

                    <a href="{{ route('company.register.page') }}" class="btn  btn_style btn_style_height">Sign Up</a>

                </div>

            </div>

        </div>

    </div>

</div>



    <section class="four_links d-none d-sm-block">



        <div class="icons">



            <a href="https://www.linkedin.com/company/zeronoticeperiod" target="_blank" class="list_nav">



                <i class="fa fa-linkedin" aria-hidden="true"></i>



            </a>



            <a href="https://www.facebook.com/Zero-Notice-Period-100871645858475" target="_blank" class="list_nav">



                <i class="fa fa-facebook" aria-hidden="true"></i>

            </a>



            <a href="https://twitter.com/ZNPTEAM" target="_blank" class="list_nav">



                <i class="fa fa-twitter" aria-hidden="true"></i>



            </a>



            <a href="https://www.youtube.com/channel/UCA_pykWTYsltpgdinRQMOgg" target="_blank" class="list_nav">



                <i class="fa fa-youtube-play" aria-hidden="true"></i>



            </a>
            
            <!--    <a href="https://www.instagram.com/zeronoticeperiod" target="_blank" class="list_nav">-->
            <!--    <i  class="fa fa-instagram" aria-hidden="true"></i>-->
            <!--</a>-->




        </div>



    </section>



<!-- modal end -->



@include('includes.footer')



@endsection



@push('scripts')

<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">

<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tokenfield/0.12.0/css/bootstrap-tokenfield.min.css">

<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tokenfield/0.12.0/bootstrap-tokenfield.js"></script>







<script>

$(document).ready(function() {

    $('.carousel').carousel({
      interval: 3000
    })

    let select1 = $('.select_skills');

    $('.select_skills').next('span.select2').find('ul').html(function() {

        let count = select1.select2('data').length;

        if (count < 1) {

            return "<li>Choose by Skills</li>";

        } else {

            return "<li>" + count + " skills selected</li>";

        }

    });



});



// multiple select skill

$('#multiple-select-skill').multiselect({

    includeSelectAllOption: false,

    nonSelectedText: 'Choose by Skills',

    numberDisplayed: 2,

    enableCaseInsensitiveFiltering: true,

    filterPlaceholder: 'Enter Skills',

});

// multiple select notice

$('#multiple-select-home_notice').multiselect({

    includeSelectAllOption: false,

    nonSelectedText: 'Choose by Notice Period',

    numberDisplayed: 2,

});









$(document).ready(function($) {



    $("form").submit(function() {



        $(this).find(":input").filter(function() {



            return !this.value;



        }).attr("disabled", "disabled");



        return true;



    });



    $("form").find(":input").prop("disabled", false);



});



$(document).ready(function() {



    //multiselect Location

    $('#location-multi-select').multiselect({

        includeSelectAllOption: true,

       selectAllText: 'Any Location',

        enableFiltering: false,

        enableClickableOptGroups: true,

        enableCollapsibleOptGroups: true,

        nonSelectedText: 'Current Location',

        numberDisplayed: 2,

        enableCaseInsensitiveFiltering: true,

        filterPlaceholder: 'Enter Location',

    });



   

    // $("button").click(function() {

    //     console.clear()

    //     //loop through ul > li which has class active (selected)

    //     $(".multiselect-container").find("li.active:not(.multiselect-group)").each(function(index,

    //         item) {

    //         //get li value and get group name

    //         console.log("Selected -- " + $(this).text() + "Values - " + $(this).find(

    //             "input[type=checkbox]").val() + " From Group -" + $(this).prevAll(

    //             ".multiselect-group:first").text() + "Values - " + $(this).prevAll(

    //             ".multiselect-group:first").find("input[type=checkbox]").val());

                



    //     })

    // })









    

});



</script>



<script>

$.ajaxSetup({

        headers: {

            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

        }

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



$(".js-example-tokenizer").select2({

    tags: true,

    tokenSeparators: [','],

        placeholder: "Choose by Skills",

   

})

</script>

<script>

    $(document).ready(function(){

        

      $('#search_data').tokenfield({

          autocomplete :{

              source: function(request, response)

              {

                  jQuery.get("{{ url('autocomplete/search') }}", {

                      query : request.term

                  }, function(data){

                      data = JSON.parse(data);

                      response(data);

                  });

              },

              delay: 100

          }

      });

  

      $('#search').click(function(){

          $('#country_name').text($('#search_data').val());

      });

      

     

  

    });















  </script>


@endpush