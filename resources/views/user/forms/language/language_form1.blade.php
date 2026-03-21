<form class="form" id="edit_front_profile_language" method="POST" action="{{ route('update.language.front.profile', [$user->id]) }}">{{ csrf_field() }}

    <!-- body -->

    <div class="modal-body">

        <p id="success_id"  class="p-success px-0 mb-0"></p>

        <div class="row mb-3">

            <div class="col-lg-12">

            

                <?php

                $language = (isset($profileLanguage) ? $profileLanguage->language_type : null);

               

                ?>

               

                

                

                <label class="mb-2  sign_fontsize">Language Type<span

                        class="text-danger px-1">* </span></label>

                {{-- <select

                    class="w-100 pl-3 pr-4 py-2 form_control-arrow sign_fontsize  signup_input rounded">

                    <option>Select Type</option>

                    <option>Local</option>

                    <option>International</option>

                </select> --}}

                

                {!! Form::select('language_type', [''=>'Select language']+MiscHelper::getlanguagetypes(), $language, array('class'=>'w-100 pl-3 pr-4 py-2 form_control-arrow sign_fontsize  signup_input rounded  language_id1 ', 'id'=>'language_id1')) !!} 

                <span class="help-block language_type-error"></span>

                

            </div>

        </div>

        <div class="row">

            <div class="col-lg-12">

                <label class="mb-2  sign_fontsize">Language<span class="text-danger px-1">*

                    </span></label>

                    <?php  

                    $language=(isset($profileLanguage) ? $profileLanguage->language : '');

                    ?>

                    <input type="text" name="language" id="language" class="w-100 signup_input px-3 py-2 mb-2 rounded " placeholder="Language" value="{{$language}}">

                {{-- <input type="text" placeholder="Language" value="" requried

                    class="w-100 signup_input px-3 py-2 mb-2 rounded"></input> --}}

                    <span class="help-block language-error"></span>

            </div>

        </div>

       

        <div class="row no-gutters pt-2">

            <div class="col-4 col-sm-2">

                <?php 

                    $check=(isset($profileLanguage) ? $profileLanguage->language_level:'');

                    

            

               

                    $data=(isset($check) ? unserialize($check) : '');

                    

                   //  print_r($data);

                    

                    ?>

                    {{-- {{var_dump(in_array(2,$data))}} --}}

                <input type="checkbox" name="language_level[]" value="1" class="lang_checkbox" @if($data){{in_array(1,$data) ? 'checked' :null}}@endif>

                {{-- <input class="lang_checkbox" type="checkbox" id="flexCheckChecked"

                    checked> --}}

                    <span class="pl-2 sign_fontsize">Read</span>

            </div>

            <div class="col-4 col-sm-2">

 

                <input type="checkbox" name="language_level[]" value="2" class="lang_checkbox" @if($data){{in_array(2,$data) ? 'checked' :null}}@endif>

                {{-- <input class="lang_checkbox" type="checkbox" id="flexCheckChecked"

                    checked> --}}

                    <span class="pl-2 sign_fontsize">Write</span>

            </div>

            <div class="col-4 col-sm-2"><input type="checkbox" name="language_level[]" value="3" class="lang_checkbox"  @if($data){{in_array(3,$data) ? 'checked' :null}}@endif>

                {{-- <input class="lang_checkbox" type="checkbox" id="flexCheckChecked"

                    checked> --}}

                    <span class="pl-2 sign_fontsize">Speak</span>

            </div>

            

        </div>

        <span class="help-block language_level-error"></span>

    </div>

   

    <!-- footer -->

    <div class="modal-footer">

        <div class="col-12 text-right">

            <button type="button" class="btn btn btn-secondary py-1 mr-0 mr-sm-2"

                data-dismiss="modal">Cancel</button>

            <button type="button" class="signin_button  px-3 py-1 rounded" onClick="updateProfileLanguageForm();"

                data-toggle="modal" data-target="#create" id="saving1">Save</button>

        </div>

    </div>

    </form>