

    <form class="form" id="current_company_form_id" method="POST" action="{{ route('store.current.front.company.form', [$user->id]) }}">  {{ csrf_field() }}

 

    <div class="modal-body">



        <div class="row">

            <div class="col-lg-6">

                <label class="mb-2 pt-3 sign_fontsize">Current Company Name<span

                        class="text-danger px-1">*</span></label>
                  

                        <select name="current_company" class="w-100 pl-3 pr-4 py-2 form_control-arrow sign_fontsize  signup_input rounded js-example-tags latestcom">
                           @foreach ($datas as $c_data)
                           <option value="{{ $c_data->id }}">{{ $c_data->name }}</option>
                           @endforeach                       
                        
                          </select>
                          
                    
                {{-- <input type="text" name="current_company" class="w-100 signup_input rounded px-3 py-2"> --}}

                <span class="help-block current_company-error"></span> 

            </div>

            <div class="col-lg-6">

                <label class="mb-2 pt-3 sign_fontsize">Current Designation<span

                        class="text-danger px-1">*</span></label>

                <input type="text" name="current_desigination"

                    class="w-100 signup_input rounded px-3 py-2 sign_fontsize">

                    <span class="help-block current_desigination-error"></span>

            </div>

        </div>

        <div class="row">

            <div class="col-lg-6">

                <label class="mb-2 pt-3 sign_fontsize">Start date<span

                        class="text-danger px-1">* </span></label>

                <input type="text" name="current_start_date" id="current_date_id"

                    class=" w-100 signup_input rounded px-3 py-2 sign_fontsize"

                    placeholder="mm/yyyy">

                    <span class="help-block current_start_date-error"></span>

            </div>

            <div class="col-lg-6">

                <label class="mb-2 pt-3 sign_fontsize">Till date<span

                        class="text-danger px-1">* </span></label>

                <p id="date1"

                    class="w-100 signup_input rounded px-3 py-2 sign_fontsize"></p>

            </div>

        </div>

        <div class="row">

            <div class="col-lg-12">

                <label class="mb-2 pt-3 sign_fontsize">Type of Employment<span

                        class="text-danger px-1">*</span></label>

                <select name="current_work_type" id="type_employment"

                    class="w-100 pl-3 pr-4 py-2 form_control-arrow sign_fontsize  signup_input rounded">

                    <option selected disabled>Select Type of Employment</option>

                    <option value="Contract">Contract</option>

                    <option value="Freelance">Freelance</option>

                    <option value="Permanent">Permanent</option>

                </select>    

                <span class="help-block current_work_type-error"></span>

            </div>

        </div>

        <div class="row">

            <div class="col-lg-12">

                <label class="mb-2 pt-3 sign_fontsize">Responsibilites<span

                        class="text-danger px-1">* </span></label>

                <textarea class="w-100 signup_input rounded px-3 py-2" name="current_responsibilities"

                    placeholder="Enter your Responsibilites"></textarea>

                    <span class="help-block current_responsibilities-error"></span>

            </div>

        </div>

        <div class="row">

            <div class="col-lg-12">

                <label class="mb-2 pt-3 sign_fontsize">Project Details<span

                        class="text-danger px-1">* </span></label>

                <textarea class="w-100 signup_input rounded px-3 py-2" name="current_project_details"></textarea>

                <span class="help-block current_project_details-error"></span>

            </div>

        </div>

        <div class="row">

            <div class="col-lg-12">

                <label class="mb-2 pt-3 sign_fontsize">Reason for Job Change<span

                        class="text-danger px-1">*</span></label>

                <input type="text" name="current_reason"

                    class="w-100 signup_input rounded px-3 py-2 sign_fontsize"> 

                    <span class="help-block current_reason-error"></span>

            </div>

        </div>

        <div class="row ">

            <div class="col-lg-12">

                <label class="mb-2 pt-3 sign_fontsize">CTC when you started in the

                    organization<span class="text-danger px-1">* </span></label>

                <input type="number" class="w-100 signup_input rounded px-3 py-2" name="current_ctc_start" min="0">

                <span class="help-block current_ctc_start-error"></span>

            </div>

        </div>

        <div class="row">

            <div class="col-lg-12">

                <label class="mb-2 pt-3 sign_fontsize">CTC when you moved out of the

                    organization<span class="text-danger px-1">* </span></label>

                <input type="number" class="w-100 signup_input rounded px-3 py-2" name="current_ctc_end" min="0">

                <span class="help-block current_ctc_end-error"></span>

            </div>

        </div>

    </div>



</form>



