<form class="form" id="previous_company_edit_form_id" method="POST" action="{{route('update.front.previous.company',[$user->id])}}" action="">{{ csrf_field() }}

    <div class="modal-body">



        <div class="row">

            <div class="col-lg-6">

                <label class="mb-2 pt-3 sign_fontsize">Previous Company Name<span

                        class="text-danger px-1">*</span></label>

                        

                        <select name="previous_company" class="w-100 pl-3 pr-4 py-2 form_control-arrow sign_fontsize  signup_input rounded js-example-tags">
                            <option value="" disabled selected>Select </option>

                            @foreach ($datas as $c_data)
                           <option value="{{ $c_data->id }}"

                            @isset($user->getprofileJobCity()->previous_company_id)  
                            
                            @if ($user->getprofileJobCity()->previous_company_id == $c_data->id)
                               selected
                            @endif

                            @endisset
                            >{{ $c_data->name }}</option>
                           @endforeach                       
                        
                          </select>
                {{-- <input type="text" class="w-100 signup_input rounded px-3 py-2" name="previous_company"   value="{{ old('previous_company', (isset($user->getprofileJobCity()->previous_company))? $user->getprofileJobCity()->previous_company:'') }}"> --}}

                <span class="help-block previous_company-error"></span>

            </div>

            <div class="col-lg-6">

                <label class="mb-2 pt-3 sign_fontsize">Current Designation<span

                        class="text-danger px-1">*</span></label>

                <input type="text"

                    class="w-100 signup_input rounded px-3 py-2 sign_fontsize" name="previous_desigination" value="{{ old('previous_desigination', (isset($user->getprofileJobCity()->previous_desigination))? $user->getprofileJobCity()->previous_desigination:'') }}">

                    <span class="help-block previous_desigination-error"></span>

            </div>

        </div>

        <div class="row">

            <div class="col-lg-6">

                <label class="mb-2 pt-3 sign_fontsize">Start date<span

                        class="text-danger px-1">* </span></label>

                <input type="text" id="previous_front_start1"

                    class=" w-100 signup_input rounded px-3 py-2 sign_fontsize" name="previous_start_date" value="{{ old('previous_start_date', (isset($user->getprofileJobCity()->previous_start_date))? $user->getprofileJobCity()->previous_start_date:'') }}"

                    placeholder="mm/yyyy">

                    <span class="help-block previous_start_date-error"></span> 

            </div>

            <div class="col-lg-6">

                <label class="mb-2 pt-3 sign_fontsize">End date<span

                        class="text-danger px-1">* </span></label>

                <input type="text"  id="previous_front_end1" class=" w-100 signup_input rounded px-3 py-2  sign_fontsize" name="previous_till_date" value="{{ old('previous_till_date', (isset($user->getprofileJobCity()->previous_till_date))? $user->getprofileJobCity()->previous_till_date:'') }}"

                    placeholder="mm/yyyy">

                    <span class="help-block previous_till_date-error"></span>

            </div>

        </div>

        <div class="row">

            <div class="col-lg-12">

                <label class="mb-2 pt-3 sign_fontsize">Type of Employment<span

                        class="text-danger px-1">* </span></label>

                <select name="previous_work_type"

                    class="w-100 pl-3 pr-4 py-2 form_control-arrow sign_fontsize  signup_input rounded">

                    <option value="" selected disabled hidden>Select</option>

                    <option   value="Contract" @if(isset($user->getprofileJobCity()->previous_work_type)) @if($user->getprofileJobCity()->previous_work_type=="Contract") selected @endif  @endif>Contract</option>

                    <option  value="Permanent" @if(isset($user->getprofileJobCity()->previous_work_type)) @if($user->getprofileJobCity()->previous_work_type=="Permanent") selected @endif  @endif>Permanent</option>

                    <option  value="Freelance" @if(isset($user->getprofileJobCity()->previous_work_type)) @if($user->getprofileJobCity()->previous_work_type=="Freelance") selected @endif  @endif>Freelance</option>

                </select>

                <span class="help-block previous_work_type-error"></span> 

            </div>

        </div>

        <div class="row">

            <div class="col-lg-12">

                <label class="mb-2 pt-3 sign_fontsize">Responsibilites<span

                        class="text-danger px-1">* </span></label>

                <textarea class="w-100 signup_input rounded px-3 py-2" name="previous_responsibilities" 

                    placeholder="Enter your Responsibilites">{{ old('previous_responsibilities', (isset($user->getprofileJobCity()->previous_responsibilities))? $user->getprofileJobCity()->previous_responsibilities:'') }}</textarea> 

                    <span class="help-block previous_responsibilities-error"></span>

            </div>

        </div>

        <div class="row">

            <div class="col-lg-12">

                <label class="mb-2 pt-3 sign_fontsize">No.of Projects handled in Case of

                    IT Experience<span class="text-danger px-1">* </span></label>

                <input type="number" min="0" max="50" onkeyup=imposeMinMax(this)

                    class="w-100 signup_input rounded px-3 py-2 sign_fontsize" name="previous_project_details" value="{{ old('previous_project_details', (isset($user->getprofileJobCity()->previous_project_details))? $user->getprofileJobCity()->previous_project_details:'') }}">

                    <span class="help-block previous_project_details-error"></span>

            </div>

        </div>

        <div class="row">

            <div class="col-lg-12">

                <label class="mb-2 pt-3 sign_fontsize">Reason for Job Change<span

                        class="text-danger px-1">*</span></label>

                <input type="text"

                    class="w-100 signup_input rounded px-3 py-2 sign_fontsize" name="previous_reason" value="{{ old('previous_reason', (isset($user->getprofileJobCity()->previous_reason))? $user->getprofileJobCity()->previous_reason:'') }}"> 

                    <span class="help-block previous_reason-error"></span> 

            </div>

        </div>

        <div class="row ">

            <div class="col-lg-12">

                <label class="mb-2 pt-3 sign_fontsize">CTC when you started in the

                    organization<span class="text-danger px-1">* </span></label>

                <input type="number" class="w-100 signup_input rounded px-3 py-2" name="previous_ctc_start" value="{{ old('previous_ctc_start', (isset($user->getprofileJobCity()->previous_ctc_start))? $user->getprofileJobCity()->previous_ctc_start:'') }}"> 

                <span class="help-block previous_ctc_start-error"></span>

            </div>

        </div>

        <div class="row">

            <div class="col-lg-12">

                <label class="mb-2 pt-3 sign_fontsize">CTC when you moved out of the

                    organization<span class="text-danger px-1">* </span></label>

                <input type="number" class="w-100 signup_input rounded px-3 py-2" name="previous_ctc_end" value="{{ old('previous_ctc_end', (isset($user->getprofileJobCity()->previous_ctc_end))? $user->getprofileJobCity()->previous_ctc_end:'') }}"> 

                <span class="help-block previous_ctc_end-error"></span>                 

            </div>

        </div>



    </div>

 

</form>