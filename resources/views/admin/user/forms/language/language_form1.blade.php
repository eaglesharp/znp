<div class="modal-body">

    <div class="form-body">

        <div class="form-group" id="div_language_type">

            <label for="language_id" class="bold">Language Type <span class="text-danger px-1">*</span></label>

            <?php

            $language = (isset($profileLanguage) ? $profileLanguage->language_type : null);

            ?>

            {!! Form::select('language_type',MiscHelper::getlanguagetypes(), $language, array('class'=>'form-control admin_first', 'id'=>'language_id')) !!} 

            <span class="help-block language_type-error"></span> </div>

            

            <?php 



            $t=\App\Profilelanguage::where('user_id',$user->id) ->get();

            foreach($t as $s ){

           



            

            }

            ?>

          



           

            {{-- {{var_dump(in_array(2,$data))}}

            {{var_dump(in_array(3,$data))}} --}}

            {{-- <div class="form-group">

                <label  class="bold">Language Type<span class="text-danger px-1"> *</span></label>

                   <select class="form-control  ">

                       <option selected disabled>Select Type</option>

                       <option value="">Local</option>

                       <option>International</option>

                  

                   </select>

               </div>

                --}}

             {{-- <div class="form-group">

             <label class="bold">Language Type</label>

             {!! Form::select('language_type'[''=>'Select language type']+MiscHelper::getlanguagetype(),null,array('class'=>'form-control','id'=>'language_type'))  !!}

<span class="help-block language_type"></span>             

             </div>    --}}

                

               <div class="form-group" id="div_language">

               <label for="language" class="bold">Language <span class="text-danger px-1">*</span></label>

               <?php  

               $language=(isset($profileLanguage) ? $profileLanguage->language : '');

               ?>

              



               <input type="text" name="language" id="language" class="form-control " placeholder="Language" value="{{$language}}">

               <span class="help-block language-error">

               </div>

               <div class="form-group 1234567">
                   
               <div class="form-group" id="div_language_level">
                <div class="col-4 col-sm-2">

                    <?php 

                    $check=(isset($profileLanguage) ? $profileLanguage->language_level:'');

                   

                    $data=(isset($check) ? unserialize($check) : '');

                    

                    ?>

                    

                    <input class="lang_checkbox" type="checkbox"   name="language_level[]" id="flexCheckChecked checkbox1"

                    value="1"{{in_array(1,$data) ? 'checked' :null}} ><label class="pl-2 sign_fontsize">Read</label>

                </div>

                <div class="col-4 col-sm-2">  

                    <input class="lang_checkbox" type="checkbox"   name="language_level[]" id="flexCheckChecked checkbox2"

                    value="2"  {{in_array(2,$data) ? 'checked' :null}}><label class="pl-2 sign_fontsize">Write</label>

                </div>

                <div class="col-4 col-sm-2">

                    <input class="lang_checkbox" type="checkbox"   name="language_level[]" id="flexCheckChecked checkbox3"

                    value="3"  {{in_array(3,$data) ? 'checked' :null}} ><label class="pl-2 sign_fontsize">Speak</label>

                </div>
              
               
             </div>
      
             
            </div>
           
 

               

        {{-- <div class="form-group" id="di">

            <label for="language_level_id" class="bold">Language Level <span class="text-danger px-1">*</span></label>

            <?php

            $language_level_id = (isset($profileLanguage) ? $profileLanguage->language_level_id : null);

            ?>

            {!! Form::select('language_level_id', [''=>'Select Language Level']+$languageLevels, $language_level_id, array('class'=>'form-control', 'id'=>'language_level_id')) !!} <span class="help-block language_level_id-error"></span> </div> --}}

    </div>
    <span class="help-block language_level-error">
</div>

