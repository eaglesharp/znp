    <meta name="csrf-token" content="{{ csrf_token() }}">

<form class="form" id="add_front_profile_education" method="POST" action="{{ route('store.front.profile.education', [$user->id]) }}">{{ csrf_field() }}

    <div class="row">

        <div class="col-lg-12">

            <?php

            $profile_education = (isset($profileEducation) ? $profileEducation->degree_title : null);

           

                

               $educationn = \App\Education::find($profile_education);

               $educations = \App\Education::all();

               

               ?>

            <label class="mb-2 pt-2 sign_fontsize">Education<span

                    class="text-danger px-1"> *</span></label>

         <select id="education1" name="degree_title" class="w-100 pl-3 pr-4 py-2 form_control-arrow sign_fontsize  signup_input rounded dynamic">

                <option value="" selected disabled>{{(isset($educationn) ? $educationn->education : 'Select Education')}}</option>
        

                 @foreach($educations as $edu)

                 <option value="{{$edu->id}}"> {{$edu->education}}</option>

                 @endforeach

          

            </select>   

            

            <span class="help-block degree_title-error"></span>   

        </div>

        <div class="col-lg-12">

            <label class="mb-2 pt-2 sign_fontsize">Education Status</label>

            <select id="education_status" name="education_status" class="w-100 pl-3 pr-4 py-2 form_control-arrow sign_fontsize  signup_input rounded">

                <option selected disabled>Select Status</option>

                <option   value="Completed" @if(old('education_status') == 'Completed')selected @endif>Completed</option>
    
                <option  value="Pursuing" @if(old('education_status') == 'Pursuing')selected @endif>Pursuing</option>
    
                <option  value="Discontinued" @if(old('education_status') == 'Discontinued')selected @endif>Discontinued</option>
    

            </select>   

            

            <span class="help-block degree_title-error"></span>   

        </div>

        <div class="col-lg-12">

            <label class="mb-2 pt-3 sign_fontsize">Course<span

                    class="text-danger px-1"> *</span></label> 

                    

                    <?php

                  $organization = (isset($profileEducation) ? $profileEducation->course : null);

                  

                  $course=\App\Course::where('id',$organization)->first();

                  $degrees =\App\Degree::all();

                

                  ?>

                

                <select id="course1" name="course" class="w-100 pl-3 pr-4 py-2 form_control-arrow sign_fontsize  signup_input rounded course dynamiccourse" >

                    <option value="" selected disabled>{{(isset($course) ? $course->course : 'Select Course')}}</option>

                  

                </select>            

              

                <span class="help-block course-error"></span> 

           

        </div>

    </div>

    <div class="row">

        <div class="col-lg-12">

            <label class="mb-2 pt-3 sign_fontsize">Specialization<span

                    class="text-danger px-1">*</span></label> 

           

            <select id="specs1" name="specilation" class="w-100 pl-3 pr-4 py-2 form_control-arrow sign_fontsize  signup_input rounded dynamicspecs">

                    <option value="" selected disabled>{{(isset($spec) ? $spec->specs :'Select Specialization')}}</option>

                

                </select>

                {{-- <input class="form-control" id="specilation" placeholder="Select Specialization " name="specilation" type="text" value="{{(isset($profileEducation)? $profileEducation->specilation:'')}}"> --}}

                <span class="help-block specilation-error"></span>

           

           

        </div>

        <div class="col-lg-12">

            <label class="mb-2 pt-3 sign_fontsize">Year of Passing<span

                    class="text-danger px-1"> *</span></label>

                     <?php

                    $year_of_passing = (isset($profileEducation) ? $profileEducation->year_of_passing : null);

                    ?>

                    {!! Form::select('year_of_passing1', [''=>'Select Year of Passing']+MiscHelper::getEstablishedIn(), $year_of_passing, array('class'=>'w-100 pl-3 pr-4 py-2 form_control-arrow sign_fontsize  signup_input rounded', 'id'=>'year_of_passing1')) !!}

                    <span class="help-block year_of_passing1-error"></span> 

            

        </div>

      

        <div class="col-lg-12">

            <label class="mb-2 pt-3 sign_fontsize"> University / College<span

                    class="text-danger px-1">*</span></label>


                        <select id="university" name="organization" class="w-100 pl-3 pr-4 py-2 form_control-arrow sign_fontsize  signup_input rounded ">

                        <option value="" selected disabled>Select University/College</option>

                        </select>

                       <span class="help-block organization-error"></span> 

            

        </div>

    </div>





    <div class="row">

        <div class="col-lg-12">

            <label class="mb-2 pt-3 sign_fontsize">Grade<span

                    class="text-danger px-1">*</span></label>

            <select name="degree_result" id="select_grade_achieved"

                class="w-100 pl-3 pr-4 py-2 form_control-arrow sign_fontsize  signup_input rounded">

                <option selected disabled>Select Grade</option>

                <option value="1">Scale 10 Grading System</option>

                <option value="2">Scale 4 Grading System</option>

                <option value="3">% Marks out 100 Maximum</option>
                
                <option value="4">Course requires a Pass</option>

            </select>

            <span class="help-block degree_result-error"></span>

        </div>

    </div>

    

    <div class="row" id="achiveGradehide1" style="display:none">
        <div class="col-lg-12">
            <label class="mb-2 pt-3 sign_fontsize">Grade Achieved<span class="text-danger px-1">*</span></label>
            <input type="text" name="grade_achieved1"
                class="w-100 signup_input rounded px-3 py-2 sign_fontsize" requried
                placeholder="Marks/CGPA" min="0">
                
                <span class=""></span>
        </div>
    </div>
    <div class="row" id="achiveGradehide2" style="display:none">
        <div class="col-lg-12">
            <label class="mb-2 pt-3 sign_fontsize">Grade Achieved<span class="text-danger px-1">*</span></label>
            <input type="text" name="grade_achieved2"
                class="w-100 signup_input rounded px-3 py-2 sign_fontsize" requried
                placeholder="Marks/CGPA" min="0">
                
                <span class=""></span>
        </div>
    </div>
    <div class="row" id="achiveGradehide3" style="display:none">
        <div class="col-lg-12">
            <label class="mb-2 pt-3 sign_fontsize">Grade Achieved<span class="text-danger px-1">*</span></label>
            <input type="text" name="grade_achieved3"
                class="w-100 signup_input rounded px-3 py-2 sign_fontsize" requried
                placeholder="Marks/CGPA" min="0">
                
                <span class=""></span>
        </div>
    </div>
    <div class="row" id="achiveGradehide4" style="display:none">
        <div class="col-lg-12">
            <label class="mb-2 pt-3 sign_fontsize">Grade Achieved<span class="text-danger px-1">*</span></label>
            <input type="text" name="grade_achieved4"
                class="w-100 signup_input rounded px-3 py-2 sign_fontsize" requried
                placeholder="Marks/CGPA" min="0">
                
                <span class=""></span>
        </div>
    </div>


    


</form>

<div class="success_msg1 success_msg22 " id="success_msg22"></div>

@push('scripts')
<script>

    
    $('#select_grade_achieved').change(function(){
    var value= this.value;
    if(this.value==1){
         $('#achiveGradehide1').show();
         $('#achiveGradehide2').hide();
         $('#achiveGradehide3').hide();
         $('#achiveGradehide4').hide();
        }
    else if(this.value==2){
         $('#achiveGradehide2').show();
         $('#achiveGradehide1').hide();
         $('#achiveGradehide3').hide();
         $('#achiveGradehide4').hide();
        }
    else if(this.value==3){
         $('#achiveGradehide3').show();
         $('#achiveGradehide2').hide();
         $('#achiveGradehide1').hide();
         $('#achiveGradehide4').hide();
        }
    else if(this.value==4){
         $('#achiveGradehide4').show();
         $('#achiveGradehide2').hide();
         $('#achiveGradehide3').hide();
         $('#achiveGradehide1').hide();
        }
    else{
         $('#achiveGradehide1').hide();
         $('#achiveGradehide2').hide();
         $('#achiveGradehide3').hide();
         $('#achiveGradehide4').hide();
        
         }
})
        
</script>
@endpush