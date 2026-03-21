<style>

.bootstrap-tagsinput {

    padding: 15px 10px;

}

.bootstrap-tagsinput .tag {

    color: #202124;

}

li.ui-menu-item {

    z-index: 2000 !important;

}

#keyskills ul#ui-id-1 {

    z-index: 2000;

    display: block !important;

}

</style>

    <div id="keyskills" class="col-lg-6  pb-3 px-0 pt-4 mt-0 mt-md-3 profile_head rounded">

        <div class="myprofile_font">Key Skills<a href="javascript:void(0)"><i class="fa fa-pencil pl-2" onclick="edit_keyskill({{$user->id}})"

                    aria-hidden="true"></i></a></div>

    </div>

    <div class="box_profile px-4 px-sm-5 py-4 py-sm-4 rounded">

        {{-- <a href="#" title="Add Skills" class="project_add" data-toggle="modal"

            data-target="#keyskils_add">ADD</a> --}}
            
            <br>

        <div class="">

                <?php 

                $keyskill=\App\KeySkill::where('user_id',$user->id)->get();

                ?>

            <ul class="list-inline my-0">

                @foreach($keyskill as $skill)

                <?php 

                $job_skill=\App\JobSkill::where('id',$skill->keyskill)->first();

                ?>
                

                <li class="list-inline-item terms mb-1">{{(isset($job_skill->job_skill)? $job_skill->job_skill:'')}}</li>

                @endforeach

            </ul>

        </div>

    </div>

    

    <!-- Key Skills modal START -->

    @include('user.forms.skill.skill_form')

    

    <div class="modal fade bs-modal-lg" id="edit_keyskill" tabindex="-1" role="dialog" aria-hidden="true">

  

    

        @include('user.forms.skill.skill_edit_form')

 
 </div>



 @push('scripts') 
 


 <script>

 

 function edit_keyskill(skill_id){







$("#edit_keyskill").modal();



loadfrontskillEditForm(skill_id);

}



function loadfrontskillEditForm(skill_id)

{

$.ajax({



type : "POST",

url : "{{route('get.front.keyskill.data',$user->id)}}",

data : {"skill_id":skill_id,"_token":"{{csrf_token()}}"},

datatype:'json',

success:function(json){



//alert('successfully get value');



$("#edit_keyskill").html(json.html);

}



});

}





 





 

     </script>

     

     

     

     

     

 

 

 

 @endpush