<div class="modal-body">

    <div class="form-body">

        <div class="form-group" id="div_certificate_name">

            <label for="name" class="bold">Certification Name <span class="text-danger px-1">*</span></label>

            <input class="form-control" id="title" placeholder="Please Enter Your Certification Name" name="certificate_name" type="text" value="{{(isset($certificate) ? $certificate->certificate_name :'')}}">

            <span class="help-block certificate_name-error"></span> </div>

            

            <div class="form-group" id="div_certificate_agency">

                <label for="name" class="bold">Certification Agency/School <span class="text-danger px-1">*</span></label>

                <input class="form-control" id="agency" placeholder="Please Mention Your Certification agency" name="certificate_agency" type="text" value="{{(isset($certificate) ? $certificate->certificate_agency:'')}}" >

                <span class="help-block certificate_agency-error"></span> </div>

                

                <label for="year_of_passing" class="bold">Year of Certification</label> <span class="text-danger">*</span>

                <div class="row">

                   

                    <div class="form-group col-lg-6" id="div_year_of_passing">

                        

                        <?php

                        $date_completion = (isset($certificate) ? $certificate->year_of_passing : null);

                        ?>

                        {!! Form::select('year_of_passing', [''=>'Select Year']+MiscHelper::getEstablishedIn(), $date_completion, array('class'=>'form-control', 'id'=>'year_of_passing')) !!}

                        <span class="help-block year_of_passing-error"></span> </div>

                    

                        <div class="form-group col-lg-6" id="div_month_of_passing">

                            

                            <?php

                            $date_completion = (isset($certificate) ? $certificate->month_of_passing : null);

                            ?>

                            {!! Form::select('month_of_passing', [''=>'Select Month']+MiscHelper::getmonths(), $date_completion, array('class'=>'form-control', 'id'=>'month_of_passing')) !!}

                            <span class="help-block month_of_passing-error"></span> </div>

                            <div class="form-group col-lg-6" id="div_duration">

                                <label class="bold"> Duration</label> <span class="text-danger">*</span>   

                                <?php

                                $date_completion = (isset($certificate) ? $certificate->duration : null);

                                ?>

                                {!! Form::select('duration', [''=>'Select Duration']+MiscHelper::getduration(), $date_completion, array('class'=>'form-control', 'id'=>'duration')) !!}

                                <span class="help-block duration-error"></span> </div>

                    

                    

                    </div>

              

    </div>