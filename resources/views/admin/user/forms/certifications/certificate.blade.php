{!! APFrmErrHelp::showErrorsNotice($errors) !!}
@include('flash::message')
<div class="form-body"> 
    <div class="form-group"> <button class="btn purple btn-outline sbold" onclick="showProfilecertificateModal();"> Add Certificate </button> </div>
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light portlet-fit bordered">
                <div class="portlet-title">
                    <div class="caption"> <i class=" icon-layers font-green"></i> <span class="caption-subject font-green bold uppercase">Certificates</span> </div>
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
<div class="modal fade bs-modal-lg" id="add_certificate_modal" tabindex="-1" role="dialog" aria-hidden="true"></div>
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
<script type="text/javascript">
  $(document).ready(function(){
    showCertificates();
    
       
        });
    
        /**************************************************/
        function showProfilecertificateModal(){
        $("#add_certificate_modal").modal();
        loadcertificateForm();
        }
        function loadcertificateForm(){ 
        
      
        $.ajax({
        type: "POST",
                 url: "{{ route('get.certificate.certificate.form', $user->id) }}",
                data: {"_token": "{{ csrf_token() }}"},
                datatype: 'json',
                success: function (json) {
                $("#add_certificate_modal").html(json.html);              
                initdatepicker();
                }
        });
         }
         function submitCertificateForm() {
        var form = $('#add_edit_certificate');
        $.ajax({
        url     : form.attr('action'),
                type    : form.attr('method'),
                data    : form.serialize(),
                dataType: 'json',
                success : function (json){
                $ ("#add_certificate_modal").html(json.html);
                showCertificates();
                },
                error: function(json){
                if (json.status === 422) {
                var resJSON = json.responseJSON;
                $('.help-block').html('');
                $.each(resJSON.errors, function (key, value) {
                $('.' + key + '-error').html('<strong>' + value + '</strong>');
                $('#div_' + key).addClass('has-error');
                });
                } else {
                // Error
                // Incorrect credentials
                // alert('Incorrect credentials. Please try again.')
                }
                }
        });
        }
        
        
        
        function showcertificateEditModal(certificate_id)
        {
        $("#add_certificate_modal").modal();
        loadcertificateEditForm(certificate_id);
              
        }
        // function loadcertificateEditForm(certificate_id){
        // $.ajax({
        // type: "POST",
        //         url: "{{route('get.certificate.edit.form',$user->id)}}",
        //         data: {"certificate_id": certificate_id, "_token": "{{ csrf_token() }}"},
        //         datatype: 'json',
        //         success: function (json) {
        //         $("#add_certificate_modal").html(json.html);
        //         createDropZone();
        //         initdatepicker();
        //         }
        // });
        // }
        function loadcertificateEditForm(certificate_id)
        {
        $.ajax({
        type:"POST",
        url:"{{route('get.certificate.edit.form',$user->id)}}",
        data: {"certificate_id": certificate_id, "_token": "{{ csrf_token() }}"},
        datatype:'json',
        success:function(json){
        $("#add_certificate_modal").html(json.html);
        }
        
        });
          
        
        }
        
        
        
        
        function showCertificates()
        {
        $.post("{{ route('show.certificates', $user->id) }}", {user_id: {{$user->id}}, _method: 'POST', _token: '{{ csrf_token() }}'})
                .done(function (response) {
                $('#certificates_div').html(response);
                });
        }
        function delete_certificate(id) {
        if (confirm('Are you sure! you want to delete?')) {
        $.post("{{ route('delete.certificate') }}", {id: id, _method: 'DELETE', _token: '{{ csrf_token() }}'})
                .done(function (response) {
                if (response == 'ok')
                {
                $('#project_' + id).remove();
                } else
                {
                    showCertificates();
                }
                });
        }
        }
        

</script>
@endpush