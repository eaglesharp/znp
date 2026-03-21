{!! APFrmErrHelp::showErrorsNotice($errors) !!}

@include('flash::message')







<form class="form" id="add_edit_front_profile_language" method="POST" action="{{ route('store.language.profile', [$user->id]) }}">{{ csrf_field() }}

    <!-- body -->
   

    <div class="modal-body">

        <p id="success_id"  class="p-success px-0"></p>

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

                

                {!! Form::select('language_type', [''=>'Select language']+MiscHelper::getlanguagetypes(), $language, array('class'=>'w-100 pl-3 pr-4 py-2 form_control-arrow sign_fontsize  signup_input rounded', 'id'=>'language_id','required' => 'required')) !!} 

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

                    <input type="text" name="language" id="language" class="w-100 signup_input px-3 py-2 mb-2 rounded " placeholder="Language" value="{{$language}}" required>

                {{-- <input type="text" placeholder="Language" value="" requried

                    class="w-100 signup_input px-3 py-2 mb-2 rounded"></input> --}}

                    <span class="help-block language-error"></span>

         

                    

                    

            </div>

        </div>

       

        <div class="row no-gutters pt-2">

            <div class="col-4 col-sm-2">

                <input type="checkbox" name="language_level[]" value="1" id="lang_1" class="lang_checkbox" required>

                {{-- <input class="lang_checkbox" type="checkbox" id="flexCheckChecked"

                    checked> --}}

                    <label for="lang_1" class="pl-2 sign_fontsize">Read</label>

            </div>

            <div class="col-4 col-sm-2">

                <input type="checkbox" name="language_level[]" value="2"  id="lang_2" class="lang_checkbox">

                {{-- <input class="lang_checkbox" type="checkbox" id="flexCheckChecked"

                    checked> --}}

                    <label for="lang_2" class="pl-2 sign_fontsize">Write</label>

            </div>

            <div class="col-4 col-sm-2"><input type="checkbox" name="language_level[]" value="3"  id="lang_3" class="lang_checkbox">

                {{-- <input class="lang_checkbox" type="checkbox" id="flexCheckChecked"

                    checked> --}}

                    <label for="lang_3" class="pl-2 sign_fontsize">Speak</label>

            </div>

           

        </div>

        <span class="help-block language_level-error"></span>
       
    </div>
    

    <!-- footer -->

    <div class="modal-footer">

        <div class="col-12 text-right">

            <button type="button" class="btn btn btn-secondary py-1 mr-0 mr-sm-2"

                data-dismiss="modal">Cancel</button>

            <button type="button" class="btns_submit signin_button  px-3 py-1 rounded" id="saving" onClick="submitProfileLanguageForm();"

                data-toggle="modal" data-target="#create">Save</button>

        </div>

    </div>

    </form>



