  <!-- IT Projects -->

  <div id="it_projects" class="it_projects-process">

        <div class="col-lg-6  pb-3 px-0 pt-4 mt-0 mt-md-3 profile_head rounded">

            <div class="myprofile_font">IT Projects</div>

        </div>

        <div class="box_profile px-4 px-sm-5 py-4 py-sm-4 rounded">

            <a href="#" title="Add Project" class="project_add" data-toggle="modal"

                data-target="#project_modal">ADD</a>

            <div class="">

            <?php 

            $experience = \App\ProfileProject::where('user_id',$user->id)->get();

            

           

            ?>

              

            

            @foreach($experience as $exp)
            {{-- {{ $exp }} --}}

                <h6 class="sign_head pt-3">{{(isset($exp->name) ? $exp->name:'')}}<a href="javascript:void(0)"><i

                            class="fa fa-pencil pl-2" aria-hidden="true" onclick="editproject1({{$exp->id}})"></i></a><a href="javascript:void(0)"><i

                                class="fa fa-trash pl-2" aria-hidden="true" onclick="deleteproject({{$exp->id}})"></i></a></h6>

                <p class="my-0 sign_fontsize"><span>Role in the project : </span>{{(isset($exp->role_in_project)? $exp->role_in_project:'')}}</p>

                <p class="my-0 sign_fontsize"><span>Client : </span>{{(isset($exp->client)? $exp->client:'')}}</p>

                <p class="my-0 sign_fontsize"><span>Domain : </span>{{(isset($exp->domain) ? $exp->domain:'')}}</p>

                <p class="my-0 sign_fontsize"><span>Duration of the Project : </span>{{(isset($exp->duration) ? $exp->duration:'')}}</p>

                <p class="my-0 sign_fontsize"><span>Project Type : </span>{{(isset($exp->project_type)? $exp->project_type:'')}}</p>

                <p class="my-0 sign_fontsize"><span>Technologies Used in the Project : </span>{{(isset($exp->tech_used) ? $exp->tech_used:'')}}</p>

                <p class="my-0 sign_fontsize"><span>Project Description :</span></p>

                <p class="w-100 pb-2 mb-0 sign_fontsize">{{(isset($exp->description)? $exp->description:'')}}</p>

                    @endforeach

            </div>

            <p id="success_id17"  class="p-success px-0"></p>

        </div>

    </div>



    <!-- project modal STARTS -->

    @include('user.forms.project.project_modal')

    <!-- project modal End -->



<div class="modal" id="edit_project_modal" role="dialog">

        @include('user.forms.project.project_edit_modal')



</div>



@push('styles')



<style type="text/css">



    .datepicker>div {



        display: block;



    }



</style>



<link href="{{ asset('/') }}dropzone/dropzone.min.css" rel="stylesheet">



@endpush



@push('scripts') 



<script src="{{ asset('/') }}dropzone/dropzone.min.js"></script> 



<script type="text/javascript">



   



    /**************************************************/







    function submitFrontProfileProjectForm() {

   // alert('hello');



    var form = $('#add_front_profile_project');



    $.ajax({



    url     : form.attr('action'),



            type    : form.attr('method'),



            data    : form.serialize(),



            dataType: 'json',



            success : function (json){



                $('#success_id15').html('<p class="alert alert-success">' + ' IT Project Updated Successfully ' + '</p>');



                setTimeout(function() { $("#success_id15").hide(); }, 5000);

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



    /*****************************************/



    function editproject1(project_id){

    

    //alert('hello');



    $("#edit_project_modal").modal();



    loadProfileProjectEditForm1(project_id);



    }



    function loadProfileProjectEditForm1(project_id){



    $.ajax({



    type: "POST",



            url: "{{ route('get.front.profile.project.edit.form1', $user->id) }}",



            data: {"project_id": project_id, "_token": "{{ csrf_token() }}"},



            datatype: 'json',



            success: function (json) {



            $("#edit_project_modal").html(json.html);



           

            }



    });



    }

    

    

    function updateFrontProfileProjectForm() {

   // alert('hello');



    var form = $('#edit_front_profile_project');



    $.ajax({



    url     : form.attr('action'),



            type    : form.attr('method'),



            data    : form.serialize(),



            dataType: 'json',



            success : function (json){

            
                $('#success_id16').html('<p class="alert alert-success">' + ' IT Project Updated Successfully ' + '</p>');
           // alert('success');

           setTimeout(function() { $("#success_id16").hide(); }, 5000);

location.reload(true);



        //     $ ("#edit_front_profile_project").html(json.html);



  



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



    /*****************************************/





    function deleteproject(id) {



    var msg = "{{__('Are you sure! you want to delete?')}}";



    if (confirm(msg)) {



    $.post("{{ route('delete.front.profile.project') }}", {id: id, _method: 'DELETE', _token: '{{ csrf_token() }}'})



            .done(function (response) {



            if (response == 'ok')



            {



            $('#project_' + id).remove();



            } else



            {



            //alert('Request Failed!');

            $('#success_id17').html('<p class="alert alert-success">' + 'Certificate Deleted Successfully ' + '</p>');

            location.reload(true);



            }



            });



    }



    }



     $(".newduration option:first").attr("disabled", "disabled");

    

     $(".newprojects option:first").attr("disabled", "disabled");

     

    $("#project_type option:first").attr("disabled","disabled");

    

    $("#project_type1 option:first").attr("disabled","disabled");



</script>



@endpush