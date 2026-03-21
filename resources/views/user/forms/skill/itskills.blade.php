<div id="it_skills" class="col-lg-6 pb-3 px-0 pt-4 mt-0 mt-md-3 profile_head rounded">

    <div class="myprofile_font">IT Skills</div>

</div>

<div class="box_profile px-4 px-sm-5 pt-5 pb-4 rounded">

    <a href="#" title="Add IT Skills" class="project_add" data-toggle="modal"

        data-target="#IT_Skill">ADD</a>

        

        <?php 



$skills=\App\ProfileSkill::where('user_id',$user->id)->get();

        //    $skill=(isset($data3) ? $data3->project_title:'');

?>



    <div class="table-responsive">

        <table class="table">

            <thead>

                <th class="pt-0">Skills</th>

                <th class="pt-0">Version</th>

                <th class="experience_skill_1 pt-0">Last used</th>

                <th class="experience_skill pt-0">Projects Completed</th>

                <th class="experience_skill pt-0">Years of Experience</th>

                <th class="pt-0">Actions</th>

            </thead>

            @foreach ($skills as $skill)

            <tr>

           

                

           

                <td class="pb-0">{{$skill->project_title}}</td>

                <td class="pb-0">{{$skill->version}}</td>

                <td class="pb-0">{{$skill->last_used_year}}</td>

                <td class="pb-0">{{$skill->no_of_projects}}</td>

                <td class="pb-0">{{$skill->job_experience}}</td>

                <td class="pb-0"><a href="javascript:void(0)" onclick="edit_profile_skill({{$skill->id}});" value="{{$skill->id}}"><i class="fa fa-pencil pl-2"

                            aria-hidden="true"></i> </a>  <a href="javascript:void(0)" onclick="delete_profile_skill({{$skill->id}});" value="{{$skill->id}}"> <i class="fa fa-trash pl-2"

                                aria-hidden="true"></i> </a></td>

           

            </tr>

            @endforeach 

        </table>

    </div>

    <p id="success_id14"  class="p-success px-0"></p>

</div>



<!-- IT Skills modal STARTS -->

<div class="container">

    <!-- modal -->

    <div class="modal" id="IT_Skill">

        <div class="modal-dialog">

            <div class="modal-content  mx-auto">

                <!-- header -->

                <div class="modal-header pb-0">

                    <h4 class="modal-title sign_head">Add IT Skills</h4>

                    <p type="button" class="info" data-dismiss="modal"><img

                            class="float-right modal_close-icon modal_crossarrow"

                            src="asset/images/close.png"></p>

                </div>

                <!-- body -->

            @include('user.forms.skill.itskills_form')

                <!-- footer -->
                <p id="success_id13"  class="p-success px-0"></p>
                <div class="modal-footer">

                    <div class="col-12 text-right">

                        <button type="button" class="btn btn btn-secondary py-1 mr-0 mr-sm-2"

                            data-dismiss="modal">Cancel</button>

                        <button type="button" class="signin_button  px-3 py-1 rounded"

                            data-toggle="modal" data-target="#create" onclick="submitfrontitskills();">Save</button>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>



<div class="modal fade bs-modal-lg" id="edit_profile_itskill" tabindex="-1" role="dialog" aria-hidden="true">

  

    

           @include('user.forms.skill.itskill_edit_modal')

    

    

  

    

    </div>

    

    <div class="success123" id="success_msg16"></div>
    <div class='alert alert-success newclass' id="myElem" style="display:none; margin-left-500px;"><i class='fa fa-check'></i> Successfully Submitted</div>



@push('scripts') 

<script type="text/javascript">



    /**************************************************/

 

    

    

    function delete_profile_skill(id) {

    if (confirm('Are you sure! you want to delete?')) {

        $.post("{{ route('delete.profile.itskill') }}", {id: id, _method: 'DELETE', _token: '{{ csrf_token() }}'})

            .done(function (response) {

            if (response == 'ok')

            {

             

                location.reload(true);

                

            } else

            {
                $('#success_id14').html('<p class="alert alert-success">' + 'IT Skill Deleted Successfully ' + '</p>');
                location.reload(true);

            }

            });

    }

    }

    

function edit_profile_skill(skill_id){



//alert(skill_id);



$("#edit_profile_itskill").modal();



loadfrontskillEditForm(skill_id);

}



function loadfrontskillEditForm(skill_id)

{

$.ajax({



type : "POST",

url : "{{route('get.front.itskill.data',$user->id)}}",

data : {"skill_id":skill_id,"_token":"{{csrf_token()}}"},

datatype:'json',

success:function(json){



//alert('successfully get value');



$("#edit_profile_itskill").html(json.html);

}



});

}







// function showfrontLanguageEditModal(profile_language_id){

    

//     $("#add_language_modal1234").modal();

//     loadfrontLanguageEditForm(profile_language_id);

//     }

//     function loadfrontLanguageEditForm(profile_language_id){

    

//     $.ajax({

//     type: "POST",

//             url: "{{ route('get.front.profile.language.edit.form', $user->id) }}",

//             data: {"profile_language_id": profile_language_id, "_token": "{{ csrf_token() }}"},

//             datatype: 'json',

//             success: function (json) {

//                 // $('#add_language_modal1234').modal('show'); 

//                 $("#add_language_modal1234").html(json.html);

//             }

//     });

//     }

 

    function submitfrontitskills() {

   

    var form = $('#add_edit_front_profile_skill');

    $.ajax({

    url     : form.attr('action'),

            type    : form.attr('method'),

            data    : form.serialize(),

            dataType: 'json',

            success : function (json){

         
                $('#success_id13').html('<p class="alert alert-success">' + ' IT Skill Updated Successfully ' + '</p>');
         


                setTimeout(function() { $("#success_id13").hide(); }, 5000);

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

    

    

    function updatefrontitskills() {

   

   var form = $('#edit_front_profile_skill');

   $.ajax({

   url     : form.attr('action'),

           type    : form.attr('method'),

           data    : form.serialize(),

           dataType: 'json',

           success : function (json){

            $('#success_id12').html('<p class="alert alert-success">' + ' IT Skill Updated Successfully ' + '</p>');

            setTimeout(function() { $("#success_id12").hide(); }, 5000);

location.reload(true);

         //   alert('success');

          

                

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

    

</script>





@endpush