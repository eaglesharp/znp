{!! APFrmErrHelp::showErrorsNotice($errors) !!}
@include('flash::message')
<div class="form-body"> 
    <div class="form-group"> <button class="btn purple btn-outline sbold" onclick="showProfilecertificateModal();"> Add Interview </button> </div>
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light portlet-fit bordered">
                <div class="portlet-title">
                    <div class="caption"> <i class=" icon-layers font-green"></i> <span class="caption-subject font-green bold uppercase">Interviews</span> </div>
                </div>
                <div class="portlet-body">
                    <div class="mt-element-card mt-element-overlay">
                        <div class="row" id="certificates_div"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




@push('css')
<style type="text/css">
    .datepicker>div {
        display: block;
    }
</style>
<link href="{{ asset('/') }}dropzone/dropzone.min.css" rel="stylesheet">
@endpush
@push('scripts') 
<script src="{{ asset('/') }}dropzone/dropzone.min.js"></script> 

<script>

$(document).ready(function(){

function showProfilecertificateModal()
{
    $("#add_interview").modal();

}


});


</script>

@endpush