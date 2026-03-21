


<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <form class="form" id="add_edit_certificate" method="PUT" action="{{ route('update.certificate', [$certificate->id,$user->id]) }}">{{csrf_field()}}
            <input type="hidden" name="id" id="id" value="{{$certificate->id}}"/>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Edit certificate</h4>
            </div>
            @include('admin.user.forms.certifications.certificate_form')
            <div class="modal-footer">
                <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-large btn-primary" onclick="submitCertificateForm();">Update certificate <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></button>
            </div>
        </form>
    </div>
    <!-- /.modal-content --> 
</div>
<!-- /.modal-dialog --> 