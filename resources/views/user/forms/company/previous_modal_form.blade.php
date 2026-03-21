<form class="form" id="previous_company_form_id" method="POST" action="{{route('store.front.previous.company',[$user->id])}}" action="">{{ csrf_field() }}

    <div class="modal-body">



        <div class="row">

            <div class="col-lg-6">

                <label class="mb-2 pt-3 sign_fontsize">Previous Company Name<span

                        class="text-danger px-1">*</span></label>

                  
                        <select name="previous_company" class="w-100 pl-3 pr-4 py-2 form_control-arrow sign_fontsize  signup_input rounded js-example-tags">
                             <option value="" disabled selected >Select </option>
                           @foreach ($datas as $c_data)
                           <option value="{{ $c_data->id }}">{{ $c_data->name }}</option>
                           @endforeach                       
                        
                          </select>

                {{-- <input type="text" class="w-100 signup_input rounded px-3 py-2" name="previous_company"> --}}

                <span class="help-block previous_company-error"></span>

            </div>

            <div class="col-lg-6">

                <label class="mb-2 pt-3 sign_fontsize">Previous Designation<span

                        class="text-danger px-1">*</span></label>

                <input type="text"

                    class="w-100 signup_input rounded px-3 py-2 sign_fontsize" name="previous_desigination">

                    <span class="help-block previous_desigination-error"></span>

            </div>

        </div>

        <div class="row">

            <div class="col-lg-6">

                <label class="mb-2 pt-3 sign_fontsize">Start date<span

                        class="text-danger px-1">* </span></label>

                <input type="text"

                    class=" w-100 signup_input rounded px-3 py-2 sign_fontsize"  id="previous_front_start" name="previous_start_date"

                    placeholder="mm/yyyy">

                    <span class="help-block previous_start_date-error"></span> 

            </div>

            <div class="col-lg-6">

                <label class="mb-2 pt-3 sign_fontsize">End date<span

                        class="text-danger px-1">* </span></label>

                <input type="text" class="w-100 signup_input rounded px-3 py-2 sign_fontsize" name="previous_till_date" id="previous_front_end"

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

                    <option selected disabled>Select Type of Employment</option>

                    <option>Contract</option>

                    <option>Freelance</option>

                    <option>Permanent</option>

                </select>

             

                <span class="help-block previous_work_type-error"></span> 

            </div>

        </div>

        <div class="row">

            <div class="col-lg-12">

                <label class="mb-2 pt-3 sign_fontsize">Responsibilites<span

                        class="text-danger px-1">* </span></label>

                <textarea class="w-100 signup_input rounded px-3 py-2" name="previous_responsibilities"

                    placeholder="Enter your Responsibilites"></textarea> 
                  

                    <span class="help-block previous_responsibilities-error"></span>

            </div>

        </div>

        <div class="row">

            <div class="col-lg-12">

                <label class="mb-2 pt-3 sign_fontsize">No.of Projects handled in Case of

                    IT Experience<span class="text-danger px-1">* </span></label>

                <input type="number" min="0" max="50" onkeyup=imposeMinMax(this)

                    class="w-100 signup_input rounded px-3 py-2 sign_fontsize" name="previous_project_details">

                    <span class="help-block previous_project_details-error"></span>

            </div>

        </div>

        <div class="row">

            <div class="col-lg-12">

                <label class="mb-2 pt-3 sign_fontsize">Reason for Job Change<span

                        class="text-danger px-1">*</span></label>

                <input type="text"

                    class="w-100 signup_input rounded px-3 py-2 sign_fontsize" name="previous_reason"> 

                    <span class="help-block previous_reason-error"></span> 

            </div>

        </div>

        <div class="row ">

            <div class="col-lg-12">

                <label class="mb-2 pt-3 sign_fontsize">CTC when you started in the

                    organization<span class="text-danger px-1">* </span></label>

                <input type="number" class="w-100 signup_input rounded px-3 py-2" name="previous_ctc_start"> 

                <span class="help-block previous_ctc_start-error"></span>

            </div>

        </div>

        <div class="row">

            <div class="col-lg-12">

                <label class="mb-2 pt-3 sign_fontsize">CTC when you moved out of the

                    organization<span class="text-danger px-1">* </span></label>

                <input type="number" class="w-100 signup_input rounded px-3 py-2" name="previous_ctc_end"> 

                <span class="help-block previous_ctc_end-error"></span>                 

            </div>

        </div>



    </div>

 

</form>

