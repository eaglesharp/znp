<link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">



<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.1/css/selectize.default.css">


<style>
    .exampleSearch .select2-container {
    width: 100%!important; 
    
}
.exampleSearch .select2-selection {
    height: 100%!important; 
    display:flex!important;
    
}
</style>

{!! APFrmErrHelp::showErrorsNotice($errors) !!}

@include('flash::message')

<div class="form-body">

    <div class="form-group">
        @if($user->industry == 1)

        <button class="btn purple btn-outline sbold" onclick="showProfileSkillModal();"> IT Skill </button>
        @endif

        <button class="btn purple btn-outline sbold" onclick="showProfilekeySkillModal();">Update KEY Skill </button>

    </div>

    

    <div class="row">

        <div class="col-md-12">

            <div class="portlet light portlet-fit bordered">

                <div class="portlet-title">

                    <div class="caption"> <i class=" icon-layers font-green"></i> <span class="caption-subject font-green bold uppercase">IT Skill</span> </div>

                </div>

                <div class="portlet-body"><div class="row" id="skill_div"></div></div>

            </div>

        </div>

    </div>

    <div class="row">

        <div class="col-md-12">

            <div class="portlet light portlet-fit bordered">

                <div class="portlet-title">

                    <div class="caption"> <i class=" icon-layers font-green"></i> <span class="caption-subject font-green bold uppercase">KEY Skill</span> </div>

                </div>

                <div class="portlet-body"><div class="row" id="keyskill_div"></div></div>

            </div>

        </div>

    </div>

</div>

<div class="modal fade bs-modal-lg" id="add_skill_modal" tabindex="-1" role="dialog" aria-hidden="true"></div>

{{-- <div class="modal fade bs-modal-lg" id="add_keyskill_modal" tabindex="-1" role="dialog" aria-hidden="true"></div> --}}

<div class="modal  bs-modal-lg"  tabindex="-1" role="dialog" aria-hidden="true" id="key_skills7" >

    <div class="modal-dialog modal-lg">

    <div class="modal-content">

        <form class="form" id="add_edit_profile_keyskill1" method="POST" action="{{route('store.keyskill',[$user->id])}}">{{ csrf_field() }}

            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>

                <h4 class="modal-title">Update Key Skills</h4>

            </div>

           

            <div class="modal-body">

                <div class="form-body">

                    <div class="form-group  kskills " id="div_project_title">

                       <div class="modal-body ">

                        <?php 

                        $keyskill=\App\KeySkill::where('user_id',$user->id)->get();

                       

                        

                       //  $t4=(isset($skill) ? $skill->keyskill:'');

                        //  echo $skill

                        ?>

                  

                          <div class='exampleSearch'>

                           
                            <label class="mb-2 pt-3 sign_fontsize">Mention your key skills<span
                                class="text-danger px-1">*</span></label>
                           
                             <?php

                                $keyskills = \App\KeySkill::where('user_id', $user->id)->pluck('keyskill')->toArray();

                                $job_skills = \App\JobSkill::pluck('job_skill', 'id')->toArray();

                             ?>
                             
                             <select class="form-control js-example-tokenizer" name="keyskills[]" multiple="multiple">
                                @foreach($job_skills as $id => $job_skill)
                                    <option value="{{ $id }}" @if(in_array($id, $keyskills)) selected @endif>{{ $job_skill }}</option>
                                @endforeach
                            </select>


                          </div>

                            <span class="help-block keyskills-error" style="color:#a94442"></span>
                            

                      </div>
                      <p id="success_id105"  class="p-success3 px-0" style="width: 80%;margin-left:80px;color:#36c6d3"></p>
                    </div>

            

            

                </div>

            </div>

            <div class="modal-footer">

                <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>

                <button type="button" class="btn btn-large btn-primary" onClick="submitProfilekeySkillForm();">Update Skill <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></button>

            </div>

        </form>

    </div>

</div>

</div>

@push('css')

<style type="text/css">

    .datepicker>div {

        display: block;

    }

</style>

@endpush

@push('scripts')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.1/js/standalone/selectize.min.js"></script>

<script type="text/javascript">

    /**************************************************/


//     var templateSkills = finTempObj.skills;
// var str_array_skills = templateSkills.split(',');
// var $select =   $("#search30").selectize();
// var selectize = $select[0].selectize;
// selectize.setValue(str_array_skills);
// selectize.refreshOptions();


    var _token = $('input[name="_token"]').val();

    var $select = $('#search30').selectize({

        valueField: 'id',

        labelField: 'job_skill',

        searchField: 'job_skill',
        delimiter: ',',

        

       

        load: function (query, callback) {

            $.ajax({

                url: "{{ route('autocomplete.fetch.admin') }}",

                type: "post",



                data:{query:query, _token:_token},

                success: function (response) { console.log(response); $select.options = response.data; callback(response.data); }
                // success: function (response) { console.log(response); $select.options = response.data; callback(response.data); $select.addOption({value: response.query, text: response.query});   }

            });

        }

    });





    function showProfileSkillModal(){

    $("#add_skill_modal").modal();

    loadProfileSkillForm();

    }

    function loadProfileSkillForm(){

    $.ajax({

    type: "POST",

            url: "{{ route('get.profile.skill.form', $user->id) }}",

            data: {"_token": "{{ csrf_token() }}"},

            datatype: 'json',

            success: function (json) {

            $("#add_skill_modal").html(json.html);

            }

    });

    }

    function showProfileSkillEditModal(skill_id){

    $("#add_skill_modal").modal();

    loadProfileSkillEditForm(skill_id);

    }

    function loadProfileSkillEditForm(skill_id){

    $.ajax({

    type: "POST",

            url: "{{ route('get.profile.skill.edit.form', $user->id) }}",

            data: {"skill_id": skill_id, "_token": "{{ csrf_token() }}"},

            datatype: 'json',

            success: function (json) {

            $("#add_skill_modal").html(json.html);

            }

    });

    }

    function submitProfileSkillForm() {

    var form = $('#add_edit_profile_skill');

    $.ajax({

    url     : form.attr('action'),

            type    : form.attr('method'),

            data    : form.serialize(),

            dataType: 'json',

            success : function (json){

            $ ("#add_skill_modal").html(json.html);

            showSkills();

            

            },

            error: function(json){

            if (json.status === 422) {

            var resJSON = json.responseJSON;

            $('.help-block').html('');

            $.each(resJSON.errors, function (key, value) {

            $('.' + key + '-error').html('<strong>' + value + '</strong>');

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

    function delete_profile_skill(id) {

  

    $.post("{{ route('delete.profile.skill') }}", {id: id, _method: 'DELETE', _token: '{{ csrf_token() }}'})

            .done(function (response) {

            if (response == 'ok')

            {

            $('#skill_' + id).remove();

            } else

            {

                showSkills();

            }

            });

    }

 

    $(document).ready(function(){

    showSkills();

    });

    function showSkills()

    {

    $.post("{{ route('show.profile.skills', $user->id) }}", {user_id: {{$user->id}}, _method: 'POST', _token: '{{ csrf_token() }}'})

            .done(function (response) {

            $('#skill_div').html(response);

            });

    }

</script> 

<script type="text/javascript">

    /**************************************************/

    function showProfilekeySkillModal(){

    $("#add_keyskill_modal").modal();

    loadProfilekeySkillForm();

    }

    function loadProfilekeySkillForm(){

        $("#key_skills7").modal();

        

    // $.ajax({

    // type: "POST",

    //         url: "{{ route('get.profile.keyskill.show.form', $user->id) }}",

    //         data: {"_token": "{{ csrf_token() }}"},

    //         datatype: 'json',

    //         success: function (json) {

    //         $("#add_keyskill_modal").html(json.html);

    //         }

    // });

    }

    function showProfilekeySkillEditModal(keyskill_id){

    $("#add_keyskill_modal").modal();

    loadProfilekeySkillEditForm(keyskill_id);

    }

    function loadProfilekeySkillEditForm(keyskill_id){

    $.ajax({

    type: "POST",

            url: "{{ route('get.profile.keyskill.edit.form', $user->id) }}",

            data: {"keyskill_id": keyskill_id, "_token": "{{ csrf_token() }}"},

            datatype: 'json',

            success: function (json) {

            $("#add_keyskill_modal").html(json.html);

            }

    });

    }

    $(document).ready(function(){

    showkeySkills();

    });

    function showkeySkills()

    {

    $.post("{{ route('show.profile.keyskills', $user->id) }}", {user_id: {{$user->id}}, _method: 'POST', _token: '{{ csrf_token() }}'})

            .done(function (response) {

            $('#keyskill_div').html(response);

            });

    }

    function submitProfilekeySkillForm() {

    var form = $('#add_edit_profile_keyskill1');

    $.ajax({

    url     : form.attr('action'),

            type    : form.attr('method'),

            data    : form.serialize(),

            dataType: 'json',

            success : function (json){

             //   alert('success');

                $('#success_id105').html('<p style="color:#36c6d3;margin-left: -64px;">' + 'Keyskill Updated Successfully' + '</p>');

               //  location.reload(true);+
               
                // setTimeout(function()
                // {
                //     $('#key_skills7').modal('hide');
                // },
                // 2000
                // );                
               
           $("#key_skills7").modal('hide');

            showkeySkills();

            },

            error: function(json){

            if (json.status === 422) {

            var resJSON = json.responseJSON;

            $('.help-block').html('');

            $.each(resJSON.errors, function (key, value) {

            $('.' + key + '-error').html('<strong>' + value + '</strong>');

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

    

    function delete_profile_keyskill(id) {

    // if (confirm('Are you sure! you want to delete?')) {

    $.post("{{ route('delete.profile.keyskill') }}", {id: id, _method: 'DELETE', _token: '{{ csrf_token() }}'})

            .done(function (response) {

            if (response == 'ok')

            {

                

            } else

            {

                showkeySkills();

            }

            });

    // }

    }


$(".js-example-tokenizer").select2({
    tags: true,
    tokenSeparators: [',', ' ']
})
  

    

</script> 

@endpush