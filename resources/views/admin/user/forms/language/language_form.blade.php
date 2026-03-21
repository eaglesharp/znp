<div class="modal-body">

    <div class="form-body">

        <div class="form-group" id="div_language_type">

            <label for="language_id" class="bold">Language Type <span class="text-danger px-1">*</span></label>

            <?php

            $language = (isset($profileLanguage) ? $profileLanguage->language_type : null);

            ?>

            {!! Form::select('language_type',[''=>'Select language']+MiscHelper::getlanguagetypes(), $language, array('class'=>'form-control admin_first', 'id'=>'language_id1')) !!} <span class="help-block language_type-error"></span> </div>

            

            

            

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

               

               {{-- <div class="row no-gutters pt-2">

                <div class="col-4 col-sm-2">

                    <input class="lang_checkbox" type="checkbox" id="flexCheckChecked"

                        ><span class="pl-2 sign_fontsize" name="language_level_id[]" value="1">Read</span>

                </div>

                <div class="col-4 col-sm-2">

                    <input class="lang_checkbox" type="checkbox" id="flexCheckChecked"

                        ><span class="pl-2 sign_fontsize" name="language_level_id[]" value="2" >Write</span>

                </div>

                <div class="col-4 col-sm-2">

                    <input class="lang_checkbox" type="checkbox" id="flexCheckChecked"

                        ><span class="pl-2 sign_fontsize" name="language_level_id[]" value="3">Speak</span>

                </div>

               

            </div> --}}

               

        <div class="form-group" id="div_language_level">

            <label for="language_level_id" class="bold">Language Level <span class="text-danger px-1">*</span></label>

            <?php

            $language_level_id = (isset($profileLanguage) ? $profileLanguage->language_level_id : null);

            ?>

                <div class="form-group">

                    <div class="col-4 col-sm-2">

                         <label><input type="checkbox" name="language_level[]" value="1"> Read</label>

                    </div>

                    <div class="col-4 col-sm-2">

                      <label><input type="checkbox" name="language_level[]" value="2"> Write</label>  

                    </div>

                    <div class="col-4 col-sm-2">

                       <label>

                            <input type="checkbox" name="language_level[]" value="3"> Speak

                        </label>

                    </div>

                </div>  

             

        </div>
      
    </div>
    <span class="help-block language_level-error" style="color:#a94442;"></span> 
</div>

