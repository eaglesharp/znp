

<div id="Education" class="col-lg-6 pb-3 px-0 pt-4 mt-0 mt-md-3 profile_head rounded">

  <div class="myprofile_font">Education</div>

</div>

<div class="box_profile px-4 px-sm-5 py-4 py-sm-4 rounded">

  <a href="#" title="Add Education" class="project_add" data-toggle="modal"

      data-target="#education_add">ADD</a>

    

      <?php 

      

      $educations = \App\ProfileEducation::where('user_id',$user->id)->get();

      

      foreach ($educations as $key => $value) {

      // echo $value;

      }

      

     

      

      ?>

                  <?php

      $profile_education = (isset($profileEducation) ? $profileEducation->degree_title : null);

     

          

         $educationn = \App\Education::find($profile_education); 

         

       

         

         ?>

      

  <div class="">

  @foreach ($educations as $education)

      <?php 

     // echo $education->organization;

       $degrees=\App\Degree::where('id',$education->organization)->first();

     

      // echo $degrees->educations;

      

      

      ?>

<?php 

  $education_title = \App\Education::where('id',$education->degree_title)->first();



//  echo $education_title->education;

 $education_course = \App\Course::where('id',$education->course)->first();

// echo $education_course->course;

$education_specs = \App\specs::where('id',$education->specilation)->first();

// echo $education_specs->specs;

?>

      <h6 class="sign_head pt-3">{{$education_title->education}}<a href="javascript:void(0)" ><i class="fa fa-pencil pl-2"

                  aria-hidden="true" onclick="showfronteducationEditModal({{$education->id}});"></i></a><a href="javascript:void(0)" onclick="delete_front_education({{$education->id}});"><i class="fa fa-trash pl-2"

                    aria-hidden="true" ></i></a></h6>
      
      <p class="my-0 sign_fontsize"><span>Education Status : </span>{{$education->education_status}}</p>

      @if(isset($education->year_of_passing))

              <p class="my-0 sign_fontsize"><span>Year of Passing : </span>{{$education->year_of_passing}}</p>

      @endif

      @if(isset($education_course->course))

             <p class="my-0 sign_fontsize"><span>Course : </span>{{$education_course->course}}</p>

      @endif

      @if(isset($education_specs->specs))

             <p class="my-0 sign_fontsize"><span>Specialization : </span>{{(isset($education_specs->specs)?$education_specs->specs:'')}}</p>

      @endif

      @if(isset($degrees->educations))

      <p class="my-0 sign_fontsize"><span>University / College : </span>{{(isset($degrees->educations)?$degrees->educations:'')}}</p>

      @endif


      @if($education->degree_result == '1')

      <p class="my-0 sign_fontsize"><span>Grade : </span>Scale 10 Grading System</p>

      <p class="my-0 sign_fontsize"><span>Grade Achieved : </span>{{ $education->grade_achieved1 }}</p>

      @elseif($education->degree_result == '2')

      <p class="my-0 sign_fontsize"><span>Grade : </span>Scale 4 Grading System</p>

      <p class="my-0 sign_fontsize"><span>Grade Achieved : </span>{{ $education->grade_achieved2 }}</p>

      @elseif($education->degree_result == '3')

      <p class="my-0 sign_fontsize"><span>Grade : </span>% Marks out 100 Maximum</p>

      <p class="my-0 sign_fontsize"><span>Grade Achieved : </span>{{ $education->grade_achieved3 }}</p>

      @elseif($education->degree_result == '4')

      <p class="my-0 sign_fontsize"><span>Grade : </span>Course requires a Pass</p>

      <p class="my-0 sign_fontsize"><span>Grade Achieved : </span>{{ $education->grade_achieved4 }}</p>

      @endif
      

      @endforeach

  </div>

  <p id="success_id50"  class="p-success50 px-0"></p>


</div>



<!-- Education modal Starts -->

@include('user.forms.education.education_modal')



<div class="modal" id="edit_education_modal" role="dialog">



@include('user.forms.education.education_edit_modal')



</div>



@push('styles')



<style type="text/css">



.datepicker>div {



  display: block;



}



</style>



@endpush



@push('scripts') 



<script type="text/javascript">



/**************************************************/







$.ajaxSetup({

headers: {

  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

}

});



$('.dynamic').change(function(){

  // alert('heloo');

var degree_id = $(this).val(); 



    //alert(degree_id);



if(degree_id){

    if(degree_id == 5)
    {
        $('.dynamiccourse').empty(); // Set the value to an empty string to deselect any previously selected option
        // $('.dynamiccourse option:contains("N/A")').prop('selected', true); // Select the "N/A" option using the :contains selector
        $('.dynamiccourse').append('<option value="N/A" selected disabled>No Input Needed</option>');
        $('.dynamicspecs').append('<option value="N/A" selected disabled>No Input Needed</option>');
        $('#university').append('<option value="N/A" selected disabled>No Input Needed</option>');
        // Disable the search functionality
            $('#university').select2({
            minimumResultsForSearch: Infinity
            })


    }else {


        $.ajax({

            type: "POST",

            url: "{{url('gety')}}",

            _token: '{{ csrf_token() }}',

            data: {

                degree: degree_id,

            },

            dataType: "json",


            success: function (res) {

                if (res) {

                    $(".dynamiccourse").empty();

                    $(".dynamiccourse").append('<option>Select course</option>');

                    $.each(res, function (key, value) {

                        $(".dynamiccourse").append('<option value="' + value.id + '">' + value.course + '</option>');

                    });


                } else {

                    $(".dynamiccourse").empty();

                }

            }

        });


        $('#university').append('<option value="" selected disabled>Select University/College</option>');
        


$('#university').select2({
    tags: true, 
   
    minimumInputLength: 2, // Set the minimum input length to 2
    ajax: {
        url: '/search-university', // Replace this with the URL to your search endpoint
        dataType: 'json',
        delay: 100,
        data: function (params) {
            return {
                q: params.term // Use the input value as the search query
            };
        },
        processResults: function (data) {
            // Transform the data into the format expected by Select2
            return {
                results: $.map(data, function (university) {
                    return {
                        id: university.id,
                        text: university.educations
                    };
                })
            };
        },
        cache: true
    }
});



    }

    }else{

    //alert('error');

    $(".dynamiccourse").empty();

    $(".dynamicspecs").empty();

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



function submiteducation() {

var form = $('#add_front_profile_education');

$.ajax({

url     : form.attr('action'),

      type    : form.attr('method'),

      data    : form.serialize(),

      dataType: 'json',

      success : function (json){

        $(".success_msg22").show(); 

$(".new_error_class").hide(); 

$(".success_msg22").html("<div class='alert alert-success education_style'>{{__('Education Updated successfully')}}</div>");
       setTimeout(function() { $(".success_msg22").hide(); }, 5000);

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



function updateeducation() { 

// alert('hello');

var form = $('#edit_front_profile_education');

$.ajax({

url     : form.attr('action'),

      type    : form.attr('method'),

      data    : form.serialize(),

      dataType: 'json',

      success : function (json){

        $(".success_msg21").show(); 

$(".new_error_class").hide(); 

$(".success_msg21").html("<div class='alert alert-success education_style'>{{__('Education Updated successfully')}}</div>");
       setTimeout(function() { $(".success_msg21").hide(); }, 5000);

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





function delete_front_education(id) {



var msg = "{{__('Are you sure! you want to delete?')}}";



if (confirm(msg)) {



$.post("{{ route('delete.front.profile.education') }}", {id: id, _method: 'DELETE', _token: '{{ csrf_token() }}'})



  .done(function (response) {



  if (response == 'ok')



  {



 console.log(response);



  } else



  {

    $('#success_id50').html('<p class="alert alert-success">' + '  Sucessfully Deleted' + '</p>');

      location.reload(true);



  }



  });



}



}



function showfronteducationEditModal(profile_education_id){



//$("#edit_education_modal").modal();

loadfrontEducationEditForm(profile_education_id);

}

function loadfrontEducationEditForm(profile_education_id){



$.ajax({

type: "POST",

      url: "{{ route('get.front.profile.education.edit.form', $user->id) }}",

      data: {"profile_education_id": profile_education_id, "_token": "{{ csrf_token() }}"},

      datatype: 'json',

      success: function (json) {

      //  alert('sucss');

           $('#edit_education_modal').modal('show'); 

          $("#edit_education_modal").html(json.html);
          
 $('.dynamic').change(function(){

// alert('heloo');

var degree_id = $(this).val(); 



// alert(degree_id);



if(degree_id){

  if(degree_id == 5)
    {
        $('.dynamiccourse').empty(); // Set the value to an empty string to deselect any previously selected option
        // $('.dynamiccourse option:contains("N/A")').prop('selected', true); // Select the "N/A" option using the :contains selector
        $('.dynamiccourse').append('<option value="N/A" selected disabled>No Input Needed</option>');
        $('.dynamicspecs').append('<option value="N/A" selected disabled>No Input Needed</option>');
        $('#organizationid').append('<option value="N/A" selected disabled>No Input Needed</option>');
        // Disable the search functionality
            $('#organizationid').select2({
            minimumResultsForSearch: Infinity
            })


    }else {



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

                  $.each(res,function(key,value){

                    $(".dynamiccourse").append('<option value="'+value.id+'">'+value.course+'</option>');

                  });



                }else{

                  $(".dynamiccourse").empty();

                }

                }

                });

              }

              
        $('#organizationid').append('<option value="" selected disabled>Select University/College</option>');
        


        $('#organizationid').select2({
            tags: true, 
           
            minimumInputLength: 2, // Set the minimum input length to 2
            ajax: {
                url: '/search-university', // Replace this with the URL to your search endpoint
                dataType: 'json',
                delay: 100,
                data: function (params) {
                    return {
                        q: params.term // Use the input value as the search query
                    };
                },
                processResults: function (data) {
                    // Transform the data into the format expected by Select2
                    return {
                        results: $.map(data, function (university) {
                            return {
                                id: university.id,
                                text: university.educations
                            };
                        })
                    };
                },
                cache: true
            }
        });

}else{

//alert('error');

$(".dynamiccourse").empty();

$(".dynamicspecs").empty();

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


      }

});

}



</script> 



@endpush