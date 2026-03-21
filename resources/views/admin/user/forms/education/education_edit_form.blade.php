<meta name="csrf-token" content="{{ csrf_token() }}" />

<div class="modal-body">

    <div class="form-body">


          <?php

               $profile_education = (isset($profileEducation) ? $profileEducation->degree_title : null);

           

                

               $educationn = \App\Education::find($profile_education);



               $educations = \App\Education::all();

               ?>

               <input type="hidden" value="{{$education_id??''}}" name="education_id">   

                 

                

                <div class="form-group" id="div_degree_title">

                    <label for="year_of_passing" class="bold">Education <span class="text-danger px-1">*</span></label>

                 

                    <select id="degree_title" name="degree_title" class="form-control">

                      <option value="" selected disabled>{{(isset($educationn) ? $educationn->education : 'Select Education')}}</option>
                   
                        @if(isset($education))

                         @foreach($education as $edu)

                         <option value="{{$edu->id}}"> {{$edu->education}}</option>

                         @endforeach

                         @else

                          

                           @foreach($educations as $edu)



                            <option value="{{$edu->id}}" @if(isset($newEducation)) @if($edu->id == $newEducation->degree_title) selected @endif  @endif> {{$edu->education}}</option>



                           @endforeach

                         @endif

                    </select>     



                 {{-- {!! Form::select('degree_title', $edu, null, array('class'=>'form-control', 'id'=>'degree_title')) !!} --}}

                    

                    

                    <span class="help-block degree_title-error"></span> 

                    </div>


                    <div class="form-group" id="div_course">

                      <label for="course" class="bold">Course<span class="text-danger px-1">*</span></label>
      
                        <?php
      
                        $organization = (isset($profileEducation) ? $profileEducation->course : null);
      
                        
      
                        $courses=\App\Course::where('id',$organization)->first();
      
                      
      
                        ?>
      
                      
      
                      <select id="course" name="course" class="form-control course">
      
                          
                          <option value="{{(isset($newEducation) ? $newEducation->course : 'Select Course')}}"   >{{(isset($courses) ? $courses->course : 'Select Course')}}</option>
      
      
                      </select> 
        
      
                      <span class="help-block course-error"></span> 
      
                      </div>


                      <div class="form-group" id="div_specilation">

                        <label for="Specilation" class="bold">Specialization <span class="text-danger px-1">*</span></label>
        
                        <select id="specilation" name="specilation" class="form-control">
        
                            {{-- <option value="" selected disabled>{{(isset($spec) ? $spec->specs :'Select Specialization')}}</option> --}}
        
                            <option value="{{(isset($newEducation) ? $newEducation->specilation :'Select Specialization')}}"  >{{(isset($spec) ? $spec->specs :'Select Specialization')}}</option>
        
                        </select>
        
                        {{-- <input class="form-control" id="specilation" placeholder="Select Specialization " name="specilation" type="text" value="{{(isset($profileEducation)? $profileEducation->specilation:'')}}"> --}}
        
                        <span class="help-block specilation-error"></span> </div>

                

                

        <div class="form-group" id="div_year_of_passing1">

            <label for="year_of_passing" class="bold">Year of Passing <span class="text-danger px-1">*</span></label>

            <?php

            $year_of_passing = (isset($profileEducation) ? $profileEducation->year_of_passing : null);

            ?>

            {!! Form::select('year_of_passing1', [''=>'Select Year of Passing']+MiscHelper::getEstablishedIn(), $year_of_passing, array('class'=>'form-control', 'id'=>'year_of_passing')) !!}

            <span class="help-block year_of_passing1-error"></span> 

            </div>

            

            <div class="form-group" id="div_organization">

                <label for="organization" class="bold">University / College<span class="text-danger px-1">*</span></label>

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
  <select id="organization" name="organization" class=" form-control ">

   
    
    @foreach($degrees as $university)
    
    <option value="{{$university->id}}" @if(isset($newEducation)) @if($university->id == $newEducation->organization) selected  @endif @endif > {{$university->educations}}</option>
    
    @endforeach
    </select>

                <span class="help-block organization-error"></span> 

                </div>


             <?php

                $organization = (isset($profileEducation) ? $profileEducation->specilation : null);

                

                $spec=\App\specs::where('id',$organization)->first();

               

                ?>




        <div class="form-group" id="grade_achieved">

            <label for="degree_result" class="bold">Grade <span class="text-danger px-1">*</span></label>

            <select name="degree_result" id="select_grade_achieved"

                    class="form-control">



                <option selected disabled>Select Grade</option>


                 <option   value="1" @if(isset($newEducation)) @if($newEducation->degree_result=="1") selected @endif  @endif>Scale 10 Grading System</option>



                <option  value="2" @if(isset($newEducation)) @if($newEducation->degree_result=="2") selected @endif  @endif>Scale 4 Grading System</option>



                <option  value="3" @if(isset($newEducation)) @if($newEducation->degree_result=="3") selected @endif  @endif>% Marks out 100 Maximum</option>



                <option  value="4" @if(isset($newEducation)) @if($newEducation->degree_result=="4") selected @endif  @endif>Course requires a Pass</option>



            </select>

            <span class="help-block degree_result-error"></span> 
          </div>


         
          @if(isset($newEducation))
       
      
          <div class="row" id="achiveGradehide1" @if($newEducation->degree_result=="1") @else style="display:none" @endif>
              <div class="col-lg-12">
                  <label class="mb-2 pt-3 sign_fontsize">Grade Achieved<span class="text-danger px-1">*</span></label>
                  <input type="text" name="grade_achieved1" value="{{(isset($newEducation)? $newEducation->grade_achieved1:'')}}"
                      class="form-control" requried
                      placeholder="Marks/CGPA" min="0">
                      
                      <span class=""></span>
              </div>
          </div>
      
    

          
      
          <div class="row" id="achiveGradehide2" @if($newEducation->degree_result=="2") @else style="display:none" @endif>
              <div class="col-lg-12">
                  <label class="mb-2 pt-3 sign_fontsize">Grade Achieved<span class="text-danger px-1">*</span></label>
                  <input type="text" name="grade_achieved2" value="{{(isset($newEducation)? $newEducation->grade_achieved2:'')}}"
                      class="form-control" requried
                      placeholder="Marks/CGPA" min="0">
                      
                      <span class=""></span>
              </div>
          </div>
      
      
          <div class="row" id="achiveGradehide3" @if($newEducation->degree_result=="3") @else style="display:none" @endif>
              <div class="col-lg-12">
                  <label class="mb-2 pt-3 sign_fontsize">Grade Achieved<span class="text-danger px-1">*</span></label>
                  <input type="text" name="grade_achieved3" value="{{(isset($newEducation)? $newEducation->grade_achieved3:'')}}"
                      class="form-control" requried
                      placeholder="Marks/CGPA" min="0">
                      
                      <span class=""></span>
              </div>
          </div>
      
          <div class="row" id="achiveGradehide4" @if($newEducation->degree_result=="4") @else style="display:none" @endif>
              <div class="col-lg-12">
                  <label class="mb-2 pt-3 sign_fontsize">Grade Achieved<span class="text-danger px-1">*</span></label>
                  <input type="text" name="grade_achieved4" value="{{(isset($newEducation)? $newEducation->grade_achieved4:'')}}"
                      class="form-control" requried
                      placeholder="Marks/CGPA" min="0">
                      
                      <span class=""></span>
              </div>
          </div>
      
      @endif

    </div>

</div>

<script type=text/javascript>



$.ajaxSetup({

    headers: {

        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

    }

});



    $('#degree_title').change(function(){

    var degree_id = $(this).val(); 

    



    

    if(degree_id){

    

       

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

          $("#course").empty();

          $("#course").append('<option>Select course</option>');

          $.each(res,function(key,value){

            $("#course").append('<option value="'+value.id+'">'+value.course+'</option>');

          });

        

        }else{

          $("#course").empty();

        }

        }

      });

    }else{

      $("#course").empty();

      $("#specs").empty();

    }   

    });

    

    

    $('#course').on('change',function(){

   

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

          $("#specilation").empty();

          $("#specilation").append('<option>Select Specilization</option>');

          $.each(res,function(key,value){

            $("#specilation").append('<option value="'+value.id+'">'+value.specs+'</option>');

          });

        

        }else{

          $("#specilation").empty();

        }

        }

      });

    }else{

      $("#specilation").empty();

    }

      

    });


    
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



