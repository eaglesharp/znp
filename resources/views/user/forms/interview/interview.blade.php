  <!-- Interview Availability -->

  <div id="Interview" class="col-lg-6 pb-3 px-0 pt-4 mt-0 mt-md-3 profile_head rounded">

    <div class="myprofile_font">Interview Availability</div>

</div>

<span class="price-section"></span>

<div class="box_profile px-4 px-sm-5 py-4 py-sm-5 rounded">

    <div class="inner_box_1 mb-2">

        <a href="javascript:void(0)" title="Add Video Interview Availability" class="project_add" data-toggle="modal"

        data-target="#InterviewAvailable" style="top:0;right:0;">ADD</a>
 
        <!-- Interview Availability for paid -->
        {{-- @if($user->package_end_date > $now)
        @if($interview_count < 3)
        <a href="javascript:void(0)" title="Add Video Interview Availability" class="project_add" data-toggle="modal"

        data-target="#InterviewAvailable" style="top:0;right:0;">ADD</a>
        @endif
        @else
        <a href="javascript:void(0)" title="Add Video Interview Availability" class="project_add" data-toggle="modal"

        onclick="scrollToBuynow()" style="top:0;right:0;">BUY NOW</a>
        @endif
        --}}

    <!-- End -->

      

           

        <p class="pr-5 mr-1 mr-sm-4 mr-lg-5 video-interview">Notify recruiters about your availaibility for Video Interview <i class="fa fa-info"
            data-toggle="tooltip" title="Recruiters will confirm the interview based on your availability"></i>
            {{-- (Recruiters will confirm the interview based on your availability)  --}}
            :  </p>

     @if(isset($interviews) && count($interviews) > 0)    
      

        <div class="table-responsive">

            <table class="table">

                <thead>

                    <tr>

                        <th class="pt-0">Date</th>

                        <th class="experience_skill_1 pt-0">From Time</th>
                        
                        <th class="experience_skill_1 pt-0">To Time</th>

                        <th class="pt-0">Actions</th>

                    </tr>

                </thead>

                <tbody>

                 @foreach ($interviews as $interview)
                     
              
                    <tr>

                        <td class="pb-0">{{ \Carbon\Carbon::parse($interview->date)->format('d/m/Y')}}</td>                     

                        <td class="pb-0">{{ $interview->from_time }}</td>
                        
                        <td class="pb-0">{{ $interview->to_time }}</td>

                        <td class="pb-0">
                            <a href="javascript:void(0)" value="{{$interview->id}}" onclick="showVideoEditModal({{$interview->id}});"><i class="fa fa-pencil pl-2"

                            aria-hidden="true"></i></a>
                            <a href="javascript:void(0)" value="{{$interview->id}}" onclick="delete_interview({{$interview->id}});"><i class="fa fa-trash pl-2"

                                aria-hidden="true"></i></a>
                        </td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    @endif

    </div>

    {{-- <div class="inner_box_2">

        @if((isset($data3->night_telephonic_date_from) ? $data3->night_telephonic_date_from:''))

   

    

        @else

        <a href="javascript:void(0)" title="Add Night Interview Availability" class="project_add" data-toggle="modal"

            data-target="#NightInterviewAvailable" style="top:0;right:0;">ADD</a>

            

            @endif

            

        <p class="pr-5 mr-1 mr-sm-4 mr-lg-5">Please mention your availability for an Interview in the

            night (9 PM till 6 AM any day)</p>

        <div class="table-responsive">

            <table class="table">

                <thead>

                    <tr>

                        <th class="pt-0">From</th>

                        <th class="pt-0">To</th>

                        <th class="experience_skill_1 pt-0">Time</th>

                        <th class="pt-0">Actions</th>

                    </tr>

                </thead>

                <tbody>

                @if((isset($data3->night_telephonic_date_from) ? $data3->night_telephonic_date_from:''))

                    <tr>

                        <td class="pb-0">{{ \Carbon\Carbon::parse($data3->night_telephonic_date_from)->format('d/m/Y')}}</td>

                        <td class="pb-0">{{ \Carbon\Carbon::parse($data3->night_telephonic_date_to)->format('d/m/Y')}}</td>

                        <td class="pb-0">{{date("g:i a",strtotime($data3->night_time))}}</td>

                        <td class="pb-0"><a href="javascript:void(0)" value="{{$user->id}}" onclick="shownightEditModal({{$user->id}});"><i class="fa fa-pencil pl-2"

                                    aria-hidden="true"></i></a></td>

                    </tr>

                    @endif

                </tbody>

            </table>

        </div>

    </div> --}}

</div>



<!-- Interview Available modal STARTS -->

@include('user.forms.interview.video_interview')





<div class="modal fade bs-modal-lg" id="edit_video_modal" tabindex="-1" role="dialog" aria-hidden="true">

  

 

    @include('user.forms.interview.video_edit_modal')

    

  

    

    </div>

  



@include('user.forms.interview.night_interview')





<div class="modal fade bs-modal-lg" id="edit_night_modal" tabindex="-1" role="dialog" aria-hidden="true">



    @include('user.forms.interview.night_edit_modal')



</div>



<!-- Interview Available modal End -->

@push('scripts') 



<script type="text/javascript">

function scrollToBuynow () {
            $(window).scrollTop(0);
        }

    /**************************************************/

    $(document).ready(function () {

$('.date-picker').datepicker({

    startDate: new Date(), // controll start date like startDate: '-2m' m: means Month
    endDate: '+30d',
    format: 'dd-mm-yyyy',
    changeMonth: true,
    changeYear: true


});

// var startDate = new Date('01/01/2022');

// var FromEndDate = new Date();

// var ToEndDate = new Date();

// ToEndDate.setDate(ToEndDate.getDate() + 365);



// $('#front_video_from').datepicker({

//     weekStart: 1,

//     startDate: '01/01/2022',

//     endDate: FromEndDate,

//     autoclose: true

// })

    // .on('changeDate', function (selected) {

    //     startDate = new Date(selected.date.valueOf());

    //     startDate.setDate(startDate.getDate(new Date(selected.date.valueOf())));

    //     $('#front_video_to').datepicker('setStartDate', startDate);

    // });

// $('#front_video_to')

//     .datepicker({

//         weekStart: 1,

//         startDate: startDate,

//         endDate: ToEndDate,

//         format: 'dd-mm-yyyy',

//         autoclose: true

//     })

//     .on('changeDate', function (selected) {

//         FromEndDate = new Date(selected.date.valueOf());

//         FromEndDate.setDate(FromEndDate.getDate(new Date(selected.date.valueOf())));

//         $('#front_video_from').datepicker('setEndDate', FromEndDate);

//     });



});    





$(document).ready(function () {

$('.night_date_from').datepicker({

    autoclose: true,

    format: 'dd-mm-yyyy',

    todayHighlight: true,

    startDate: '01/01/2022'

});

var startDate = new Date('01/01/2022');

var FromEndDate = new Date();

var ToEndDate = new Date();

ToEndDate.setDate(ToEndDate.getDate() + 365);



$('.night_date_from').datepicker({

    weekStart: 1,

    startDate: '01/01/2022',

    endDate: FromEndDate,

    autoclose: true

})

    .on('changeDate', function (selected) {

        startDate = new Date(selected.date.valueOf());

        startDate.setDate(startDate.getDate(new Date(selected.date.valueOf())));

        $('.night_date_to').datepicker('setStartDate', startDate);

    });

$('.night_date_to')

    .datepicker({

        weekStart: 1,

        startDate: startDate,

        endDate: ToEndDate,

        format: 'dd-mm-yyyy',

        autoclose: true

    })

    .on('changeDate', function (selected) {

        FromEndDate = new Date(selected.date.valueOf());

        FromEndDate.setDate(FromEndDate.getDate(new Date(selected.date.valueOf())));

        $('.night_date_from').datepicker('setEndDate', FromEndDate);

    });



});  





 



    function submitVideoInterviewForm() {

    

        $("form").submit(function(e){

        e.preventDefault();

    });



    var form = $('#add_edit_interview');



    $.ajax({



    url     : form.attr('action'),



            type    : form.attr('method'),



            data    : form.serialize(),



            dataType: 'json',



            success: function (data) {

                $('#success_id7').html('<p class="alert alert-success">' + ' Video Interview Addded Successfully' + '</p>');
                $('#InterviewAvailable').hide();

            location.reload(true);

       

       

                },



            error: function(json){

                if (json.status === 422) {

            var resJSON = json.responseJSON;

            $('.help-block').html('');

            $.each(resJSON.errors, function (key, value) {

            $('.' + key + '-error').html('<strong class="new_error_class">' + value + '</strong>');

            $('#div_' + key).addClass('has-error');

            });

            } else {

            // Error

            // Incorrect credentials

            // alert('Incorrect credentials. Please try again.')

            }

             

            }



    });



    }

    

    





    function updateVideoInterviewForm() {

    // alert('hello');

        $("form").submit(function(e){

        e.preventDefault();

    });



var form = $('#edit_interview');



$.ajax({



url     : form.attr('action'),



        type    : form.attr('method'),



        data    : form.serialize(),



        dataType: 'json',



        success: function (data) {

            $('#success_id4').html('<p class="alert alert-success">' + 'Video Interview Updated Successfully ' + '</p>');

        location.reload(true);

   

   

            },



        error: function(json){

            if (json.status === 422) {

        var resJSON = json.responseJSON;

        $('.help-block').html('');

        $.each(resJSON.errors, function (key, value) {

        $('.' + key + '-error').html('<strong class="new_error_class">' + value + '</strong>');

        $('#div_' + key).addClass('has-error');

        });

        } else {

        // Error

        // Incorrect credentials

        // alert('Incorrect credentials. Please try again.')

        }

         

        }



});



}

   

   

    

    function showVideoEditModal(interview_id){

    //alert('hello');

    

    $("#edit_video_modal").modal();

    loadfrontvideoEditForm(interview_id);

   

    }

  

    function loadfrontvideoEditForm(interview_id){

    

    $.ajax({

    type: "POST",

            url: "{{ route('get.front.video.edit.form', $user->id) }}",

            data: {"interview_id": interview_id, "_token": "{{ csrf_token() }}"},

            datatype: 'json',

            success: function (json) {
                console.log(json);
                $('#date').val(json.date);
                $('#edit_input_from').val(json.from_time);
                $('#edit_input_to').val(json.to_time);
                $('#interview_id').val(json.id);
                // $('#video_date_from1').val('10-01-2021');

                // $('#add_language_modal1234').modal('show'); 

                // $("#edit_video_modal").html(json.html);

            }

    });

    }

    

    

    

    function submitnightInterviewForm() {

    

    

    

    $("form").submit(function(e){

    e.preventDefault();

});



var form = $('#add_night_interview');



$.ajax({



url     : form.attr('action'),



        type    : form.attr('method'),



        data    : form.serialize(),



        dataType: 'json',



        success: function (data) {

            $('#success_id6').html('<p class="alert alert-success">' + 'Night Interview Updated Successfully ' + '</p>');

        location.reload(true);

   

   

            },



        error: function(json){

            if (json.status === 422) {

        var resJSON = json.responseJSON;

        $('.help-block').html('');

        $.each(resJSON.errors, function (key, value) {

        $('.' + key + '-error').html('<strong class="new_error_class">' + value + '</strong>');

        $('#div_' + key).addClass('has-error');

        });

        } else {

        // Error

        // Incorrect credentials

        // alert('Incorrect credentials. Please try again.')

        }

         

        }



});



}





   

    

function shownightEditModal(user_id){

   // alert('hello');

    

    $("#edit_night_modal").modal();

    loadfrontnightEditForm(user_id);

   

    }

  

    function loadfrontnightEditForm(user_id){

    

    $.ajax({

    type: "POST",

            url: "{{ route('get.front.night.edit.form', $user->id) }}",

            data: {"user_id": user_id, "_token": "{{ csrf_token() }}"},

            datatype: 'json',

            success: function (json) {

                // $('#add_language_modal1234').modal('show'); 

                $("#edit_night_modal").html(json.html);

            }

    });

    }



function updatenightInterviewForm() {

    

    

    

    $("form").submit(function(e){

    e.preventDefault();

});



var form = $('#edit_night_interview');



$.ajax({



url     : form.attr('action'),



        type    : form.attr('method'),



        data    : form.serialize(),



        dataType: 'json',



        success: function (data) {

        
            $('#success_id5').html('<p class="alert alert-success">' + 'Night Interview Updated Successfully' + '</p>');
        location.reload(true);

   

   

            },



        error: function(json){

            if (json.status === 422) {

        var resJSON = json.responseJSON;

        $('.help-block').html('');

        $.each(resJSON.errors, function (key, value) {

        $('.' + key + '-error').html('<strong class="new_error_class">' + value + '</strong>');

        $('#div_' + key).addClass('has-error');

        });

        } else {

        // Error

        // Incorrect credentials

        // alert('Incorrect credentials. Please try again.')

        }

         

        }



});



}

$('.timepicker').timepicker({});



function delete_interview(id) {
    if (confirm('Are you sure! you want to delete?')) {
    $.post("{{ route('front.delete.interview') }}", {id: id, _method: 'DELETE', _token: '{{ csrf_token() }}'})
            .done(function (response) {
            if (response == 'ok')
            {
                window.location.reload();
            } else
            {
                window.location.reload();
            }
            });
    }
    }




</script> 



@endpush