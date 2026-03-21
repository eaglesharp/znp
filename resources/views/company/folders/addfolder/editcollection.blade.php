<div class="modal-content mx-auto py-2">
    <!-- header -->
    <div class="modal-header pb-0">
        <h4 class="modal-title sign_head">Edit folder</h4>
        <p type="button" class="info" data-dismiss="modal"><img
                class="float-right modal_close-icon modal_crossarrow" src="asset/images/cancel.png"></p>
    </div>
    <!-- body -->
    <form action="" method="POST" autocomplete="off">
        @csrf
        <div class="modal-body">
            <input type="hidden" name="id" id="collection-id" value="{{$collection->id}}">
            <p class="mb-2 py-0 sign_fontsize">Name<span class="text-danger px-1">* </span></p>
            <input type="text" placeholder="Enter Name" class="px-3 py-2 signup_input w-100 rounded" id="name" requried='' maxlength="100" minlength="5" name="name" value="{{$collection->name}}">
            <div class="text-danger">
                <strong id="name-error" class="new_error_class" ></strong>
            </div>
            <p class="sign_fontsize pt-3 mb-2">Description (optional)</p>
            <textarea class="form-control" aria-label="With textarea" row="10" cols="50" name="description" id="description" value="">{{$collection->description}}</textarea>
            
        </div>
        <!-- footer -->
        <div class="modal-footer">
            <div class="col-6">
                <button type="submit" class="signin_button  px-3 py-2 rounded" id="edit_folder">Update</button>
            </div>
            <div class="col-6 text-right">
                <button type="button" class="btn btn btn-secondary py-2" data-dismiss="modal">cancel</button>
            </div>
        </div>
    </form>
</div>

<script>
    $(document).ready(function(){
        $('#edit_folder').click(function(e){
            // alert('hello');
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('update.collection') }}",
                method: 'post',
                data: {
                    _token:"{{ csrf_token() }}",
                    id:$("#collection-id").val(),
                    name: $('#name').val(),
                    description: $('#description').val(),
                },
                success: function(result){
                    console.log(result);
                    if(result.success) {
                        $('.alert-danger').hide();
                        $('#editcollection').modal('hide');
                        window.location.reload();
                        $("#update_message").show();
                        setTimeout(function() { $("#update_message").hide(); }, 5000);
                    }
                    if(result.errors)
                    {
                        $('#name-error').html( result.errors[0] );
                    }
                }
            });
        });
    });
</script>