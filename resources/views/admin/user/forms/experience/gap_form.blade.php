<div class="modal-body">

    <div class="form-body">

      

        <div class="form-group" id="div_reason">

            <label for="reason" class="bold">Reason</label> <span class="text-danger">*</span>

            <textarea name="reason" class="form-control" id="reason" placeholder="">{{(isset($profilegap)? $profilegap->reason:'')}}</textarea>

            <span class="help-block reason-error"></span> </div>

    </div>

</div>

<script>

    $(document).ready(function(){

      $(".datepickerr").datepicker({

         format: "yyyy",

         viewMode: "years", 

         minViewMode: "years",

         autoclose:true

      });   

    })

    

    

    </script>

    <script>

        $(document).ready(function(){

          $(".datepickermonth").datepicker({

             format: "mm",

             viewMode: "months", 

             minViewMode: "months",

             autoclose:true

          });   

        })

        

        

        </script>

