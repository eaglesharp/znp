<meta name="csrf-token" content="{{ csrf_token() }}">

<form class="form" id="edit_front_profile_education" method="PUT" action="{{ route('update.front.profile.education', [$user->id]) }}">{{ csrf_field() }}

    <div class="row">

        <div class="col-lg-12">

            <?php

            $profile_education = (isset($education) ? $education->degree_title : null);

        // echo $education;

        // $new = \App\ProfileEducation::where('user_id',$education->id)->get();

        // echo $new;

      
               $educationn = \App\Education::find($profile_education);

              //echo $educationn;

               

               $educations = \App\Education::all();



               ?>

               <input type="hidden" value="{{$education_id??''}}" name="education_id">

               

            <label class="mb-2 pt-2 sign_fontsize">Education<span

                    class="text-danger px-1"> *</span></label>

         <select id="education1" name="degree_title" class="w-100 pl-3 pr-4 py-2 form_control-arrow sign_fontsize  signup_input rounded dynamic new_dynamic">

            {{-- <option value="{{ $profile_education }}" selected disabled>{{(isset($educationn) ? $educationn->education : 'Select Education')}}</option> --}}

            

             @foreach($educations as $edu)

             <option value="{{$edu->id}}" @if(isset($newEducation)) @if($edu->id == $newEducation->degree_title) selected @endif  @endif> {{$edu->education}}</option>

             @endforeach

            

          

            </select>   

            

            <span class="help-block degree_title-error"></span>   

        </div>
        <div class="col-lg-12">

            <label class="mb-2 pt-2 sign_fontsize">Education Status</label>

            <select id="education_status" name="education_status" class="w-100 pl-3 pr-4 py-2 form_control-arrow sign_fontsize  signup_input rounded">

                <option selected disabled>Select Status</option>

                <option   value="Completed" @if(isset($newEducation)) @if($newEducation->education_status=="Completed") selected @endif  @endif>Completed</option>

                <option  value="Pursuing" @if(isset($newEducation)) @if($newEducation->education_status=="Pursuing") selected @endif  @endif>Pursuing</option>

                <option  value="Discontinued" @if(isset($newEducation)) @if($newEducation->education_status=="Discontinued") selected @endif  @endif>Discontinued</option>


            </select>



            <span class="help-block degree_title-error"></span>

        </div>
        <div class="col-lg-12">

            <label class="mb-2 pt-3 sign_fontsize">Course<span

                    class="text-danger px-1"> *</span></label> 

                    

                    <?php

                  $organization = (isset($newEducation) ? $newEducation->course : null);

                  

                  $courses=\App\Course::where('id',$organization)->first();


                  $collection_course = \App\Course::all();

                  foreach ($collection_course as $key => $value) {
                      # code...
                      $course_data[] = $value->course;
                  }

                

                  ?>

                

                <select id="course1" name="course" class="w-100 pl-3 pr-4 py-2 form_control-arrow sign_fontsize  signup_input rounded course dynamiccourse">

                    @if(isset($newEducation) && $newEducation->degree_title == 5)
                        <option value="no_input_needed">No Input Needed</option>
                    @else
                    <option value="{{(isset($newEducation) ? $newEducation->course : 'Select Course')}}">{{(isset($courses) ? $courses->course : 'Select Course')}}</option>
                    @endif
                  

                </select>            

              

                <span class="help-block course-error"></span> 

           

        </div>

    </div>

    <div class="row">
        
        <div class="col-lg-12">

            <label class="mb-2 pt-3 sign_fontsize">Specialization<span

                    class="text-danger px-1">*</span></label> 

                    <?php

                    $organization = (isset($newEducation) ? $newEducation->specilation : null);

                    

                    $spec=\App\specs::where('id',$organization)->first();

                   $specilation_all = \App\specs::all();

                   foreach ($specilation_all as $key => $value) {
                       # code...
                       $specilation_value[] = $value->specs;
                   }

                    ?>

                

            <select id="specs1" name="specilation" class="w-100 pl-3 pr-4 py-2 form_control-arrow sign_fontsize  signup_input rounded dynamicspecs">

                @if(isset($newEducation) && $newEducation->degree_title == 5)
                <option value="no_input_needed">No Input Needed</option>
                @else
                <option value="{{(isset($newEducation) ? $newEducation->specilation :'Select Specialization')}}">{{(isset($spec) ? $spec->specs :'Select Specialization')}}</option>
                @endif

                </select>

                {{-- <input class="form-control" id="specilation" placeholder="Select Specialization " name="specilation" type="text" value="{{(isset($profileEducation)? $profileEducation->specilation:'')}}"> --}}

                <span class="help-block specilation-error"></span>

           

           

        </div>

        <div class="col-lg-12">

            <label class="mb-2 pt-3 sign_fontsize">Year of Passing<span

                    class="text-danger px-1"> *</span></label>

                     <?php

                    $year_of_passing = (isset($newEducation) ? $newEducation->year_of_passing : null);

                  //  echo $year_of_passing;

                    ?>

                    {!! Form::select('year_of_passing1', [''=>'Select Year of Passing']+MiscHelper::getEstablishedIn(), $year_of_passing, array('class'=>'w-100 pl-3 pr-4 py-2 form_control-arrow sign_fontsize  signup_input rounded', 'id'=>'year_of_passing1')) !!}

                    <span class="help-block year_of_passing1-error"></span> 

            

        </div>



        <div class="col-lg-12">

            <label class="mb-2 pt-3 sign_fontsize"> University / College<span

                    class="text-danger px-1">*</span></label>

                     

                 

                    <?php

                 $profile_education = (isset($education) ? $education->degree_title : null);

           

                  // echo $profile_education;

                   $educationn = \App\Education::find($profile_education);


                    $organization = (isset($education) ? $education->organization : null);
                  //  echo $newEducation;
                    $degrees =\App\Degree::all();

                    foreach ($degrees as $key => $value) {
                        # code...
                        $universities[] = $value->educations;
                    
                    }
                    
                  //  $university_value = \App\Degree::find($organization);


                   // echo $university_value->educations;

                    ?>

            <select id="organizationid" name="organization" class="w-100 pl-3 pr-4 py-2 form_control-arrow sign_fontsize organization  signup_input rounded ">

            {{-- <option value="" selected disabled>{{(isset($university_value) ? $university_value->educations : 'Select University/College')}}</option> --}}
            
            @if(isset($newEducation) && $newEducation->degree_title == 5)
            <option value="no_input_needed">No Input Needed</option>
            @else
            @foreach($degrees as $university)
                <option value="{{$university->id}}" @if(isset($newEducation)) @if($university->id == $newEducation->organization) selected  @endif @endif > {{$university->educations}}</option>
            @endforeach
            @endif
        
            </select>

    {{-- {{ Form::select('city_bldg_id', $sources, null, ['id' => 'city_bldg_id', 'class' => 'form-control']) }} --}}

                    {{-- {!! Form::select('organization', [''=>'Select University / College']+$degrees, array('class'=>'w-100 pl-3 pr-4 py-2 form_control-arrow sign_fontsize  signup_input rounded', 'id'=>'organization')) !!} --}}

                    <span class="help-block organization-error"></span> 

            

        </div>

    </div>






    <div class="row">

        <div class="col-lg-12">

            <label class="mb-2 pt-3 sign_fontsize">Grade<span

                    class="text-danger px-1">*</span></label>

            <select name="degree_result" id="select_grade_achieved" onchange="getval(this);"

                class="w-100 pl-3 pr-4 py-2 form_control-arrow sign_fontsize grade-class  signup_input rounded">

                <option selected disabled>Select Grade</option>

                <option   value="1" @if(isset($newEducation)) @if($newEducation->degree_result=="1") selected @endif  @endif>Scale 10 Grading System</option>

                <option  value="2" @if(isset($newEducation)) @if($newEducation->degree_result=="2") selected @endif  @endif>Scale 4 Grading System</option>

                <option  value="3" @if(isset($newEducation)) @if($newEducation->degree_result=="3") selected @endif  @endif>% Marks out 100 Maximum</option>

                <option  value="4" @if(isset($newEducation)) @if($newEducation->degree_result=="4") selected @endif  @endif>Course requires a Pass</option>

            </select>

            <span class="help-block degree_result-error"></span>

        </div>

    </div>


    <div class="row" id="achiveGradehideedit1" @if(isset($newEducation) && $newEducation->degree_result == "1")@else style="display:none" @endif>
        <div class="col-lg-12">
            <label class="mb-2 pt-3 sign_fontsize">Grade Achieved<span class="text-danger px-1">*</span></label>
            <input type="text" name="grade_achieved1" value="{{(isset($newEducation)? $newEducation->grade_achieved1:'')}}"
                class="w-100 signup_input rounded px-3 py-2 sign_fontsize" requried
                placeholder="Marks/CGPA" min="0">
                
                <span class=""></span>
        </div>
    </div>

 

    <div class="row" id="achiveGradehideedit2" @if(isset($newEducation) && $newEducation->degree_result == "2")@else style="display:none" @endif>
        <div class="col-lg-12">
            <label class="mb-2 pt-3 sign_fontsize">Grade Achieved<span class="text-danger px-1">*</span></label>
            <input type="text" name="grade_achieved2" value="{{(isset($newEducation)? $newEducation->grade_achieved2:'')}}"
                class="w-100 signup_input rounded px-3 py-2 sign_fontsize" requried
                placeholder="Marks/CGPA" min="0">
                
                <span class=""></span>
        </div>
    </div>


    <div class="row" id="achiveGradehideedit3" @if(isset($newEducation) && $newEducation->degree_result == "3")@else style="display:none" @endif>
        <div class="col-lg-12">
            <label class="mb-2 pt-3 sign_fontsize">Grade Achieved<span class="text-danger px-1">*</span></label>
            <input type="text" name="grade_achieved3" value="{{(isset($newEducation)? $newEducation->grade_achieved3:'')}}"
                class="w-100 signup_input rounded px-3 py-2 sign_fontsize" requried
                placeholder="Marks/CGPA" min="0">
                
                <span class=""></span>
        </div>
    </div>


    <div class="row" id="achiveGradehideedit4" @if(isset($newEducation) && $newEducation->degree_result == "4")@else style="display:none" @endif>
        <div class="col-lg-12">
            <label class="mb-2 pt-3 sign_fontsize">Grade Achieved<span class="text-danger px-1">*</span></label>
            <input type="text" name="grade_achieved4" value="{{(isset($newEducation)? $newEducation->grade_achieved4:'')}}"
                class="w-100 signup_input rounded px-3 py-2 sign_fontsize" requried
                placeholder="Marks/CGPA" min="0">
                
                <span class=""></span>
        </div>
    </div>

   
</form>

<div class="success_msg1 success_msg21 " id="success_msg21"></div>



@push('scripts')
<script>

$('.organization').select2({
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

function getval(sel)
{
    

    var value= sel.value;

   if (value == 1) {
        $("#achiveGradehideedit1").show();
        $('#achiveGradehideedit2, #achiveGradehideedit3, #achiveGradehideedit4').hide();
    }
    else if (value == 2) {
        $('#achiveGradehideedit2').show();
        $('#achiveGradehideedit1, #achiveGradehideedit3, #achiveGradehideedit4').hide();
    }
    else if (value == 3) {
        $('#achiveGradehideedit3').show();
        $('#achiveGradehideedit1, #achiveGradehideedit2, #achiveGradehideedit4').hide();
    }
    else if (value == 4) {
        $('#achiveGradehideedit4').show();
        $('#achiveGradehideedit1, #achiveGradehideedit2, #achiveGradehideedit3').hide();
    }
    else {
        $('#achiveGradehideedit1, #achiveGradehideedit2, #achiveGradehideedit3, #achiveGradehideedit4').hide();
    }
    
}
    
   
        
</script>
@endpush