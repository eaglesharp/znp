@extends('admin.layouts.admin_layout')
@section('content')
<style type="text/css">
    .table td, .table th {
        font-size: 12px;
        line-height: 2.42857 !important;
    }	
    .table-scrollable .dataTable td .btn-group, .table-scrollable .dataTable th .btn-group {
        position: relative !important;
    }
</style>
<div class="page-content-wrapper"> 
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content"> 
        <!-- BEGIN PAGE HEADER--> 
        <!-- BEGIN PAGE BAR -->
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li> <a href="{{ route('admin.home') }}">Home</a> <i class="fa fa-circle"></i> </li>
                <li> <span>Users</span> </li>
            </ul>
        </div>
        <!-- END PAGE BAR --> 
        <!-- BEGIN PAGE TITLE-->
        <h3 class="page-title">Manage Users <small>Users</small> </h3>
        <!-- END PAGE TITLE--> 
        <!-- END PAGE HEADER-->
        <div class="row">
            <div class="col-md-12"> 
                <!-- Begin: life time stats -->
                <div class="portlet light portlet-fit portlet-datatable bordered">
                    <div class="portlet-title">
                        <div class="caption"> <i class="icon-settings font-dark"></i> <span class="caption-subject font-dark sbold uppercase">Users</span> </div>
                        <div class="actions">
                            <a href="{{ route('create.user') }}" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-plus"></i> Add New User</a>
                            @if(APAuthHelp::check(['SUP_ADM']))
                            <a href="{{ route('bulkuseruploads') }}" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-plus"></i> Bulk User</a>

                            @endif
                            <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal"><i class="glyphicon glyphicon-plus"></i> Bulk Email</button>

                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="table-container">
                            <form method="post" role="form" id="user-search-form">
                                <table class="table table-striped table-bordered table-hover"  id="user_datatable_ajax">
                                    <thead>
                                        <tr role="row" class="filter">                  
                                            <td><input type="text" class="form-control" name="id" id="id" autocomplete="off" placeholder="Search id"></td>                    
                                            <td><input type="text" class="form-control" name="name" id="name" autocomplete="off" placeholder="Search Name"></td>
                                            <td><input type="text" class="form-control" name="email" id="email" autocomplete="off" placeholder="Search Email"></td>
                                            <td></td>
                                            <td></td>                                           
                                            <td></td>
                                            <td></td>
                                            <td width="50px"><button type="button" name="bulk_delete" id="bulk_delete" class="btn btn-danger btn-xs">Hide</button>
                                               Select All<input type="checkbox" name="select-all" id="select-all" />
                                            </td>

                                        </tr>
                                        <tr role="row" class="heading"> 
                                            <th>Id</th>                                        
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Recruiter</th>
                                            <th>Added Date</th> 
                                            <th>Updated Date</th>  
                                            <th>Added by</th>
                                            <th>Updated by</th>
                                            <th>Verified/Not Verified</th>
                                            <th>Checkbox</th>
                                            <th>Actions</th>                                                                           
                                        </tr>
                                    </thead>
                                    <tbody>
                                 
                                    </tbody>
                                </table></form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END CONTENT BODY --> 
</div>
<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
        <form method="post" id="sample_form" class="form-horizontal">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalLabel">Confirmation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h4 align="center" style="margin:0;">Are you sure you want to remove this data?</h4>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" name="ok_button" id="ok_button" class="btn btn-danger">OK</button>
            </div>
        </form>  
        </div>
        </div>
    </div>

    <!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
  
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">E-Mail</h5>
        </div>
        <div class="modal-body">

                <form  name="user-form" id="form" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="users[]" id="user_id" value="">
                <div class="mb-3">
                    <label class="form-label">Subject</label>
                    <input type="text" class="form-control" id="subject" name="subject" placeholder="subject" />
                </div>
                <div class="mb-3 pt-3" style="margin:30px 0px">
                    <label class="form-label">Message</label>
              
                    <textarea id="summernote" name="message" class="note-editable description"></textarea>
                   
                </div>
               

                <button type="button" id="form_Submit" class="btn btn-primary float-end">Submit</button>
                <!-- </div> -->
            </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>


 

@endsection
@push('scripts') 
<script>
    $(function () {
        var oTable = $('#user_datatable_ajax').DataTable({
            processing: true,
            serverSide: true,
            stateSave: true,
            searching: false,
            responsive: false,
            "order": [[0, "desc"]],
            /*		
             paging: true,
             info: true,
             */
            ajax: {
                url: '{!! route('fetch.data.users') !!}',
                data: function (d) {
                    d.id = $('input[name=id]').val();
                    d.name = $('input[name=name]').val();
                    d.email = $('input[name=email]').val();
                }
            }, columns: [
                /*{data: 'id_checkbox', name: 'id_checkbox', orderable: false, searchable: false},*/
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'recruiter', name: 'recruiter'},
                {data: 'created_at', name: 'created_at'},
                {data: 'updated_at', name: 'updated_at'},
                {data:'added',name:'added'},
                {data:'updated_by',name:'updated_by'},
                {data:'verify',name:'verify'},
                {data: 'checkbox', name: 'checkbox', orderable:false, searchable:false},
                {data: 'action', name: 'action', orderable: false, searchable: false}
               
            ]
        });
        $('#user-search-form').on('submit', function (e) {
            oTable.draw();
            e.preventDefault();
        });
        $('#id').on('keyup', function (e) {
            oTable.draw();
            e.preventDefault();
        });
        $('#name').on('keyup', function (e) {
            oTable.draw();
            e.preventDefault();
        });
        $('#email').on('keyup', function (e) {
            oTable.draw();
            e.preventDefault();
        });
    });
    function delete_user(id) {
        if (confirm('Are you sure! you want to delete?')) {
            $.post("{{ route('delete.user') }}", {id: id, _method: 'DELETE', _token: '{{ csrf_token() }}'})
                    .done(function (response) {
                        if (response == 'ok')
                        {
                            var table = $('#user_datatable_ajax').DataTable();
                            table.row('user_dt_row_' + id).remove().draw(false);
                        } else
                        {
                            var table = $('#user_datatable_ajax').DataTable();
                            table.row('user_dt_row_' + id).remove().draw(false);
                        }
                    });
        }
    }
    function make_active(id) {
        $.post("{{ route('make.active.user') }}", {id: id, _method: 'PUT', _token: '{{ csrf_token() }}'})
                .done(function (response) {
                    if (response == 'ok')
                    {
                        var table = $('#user_datatable_ajax').DataTable();
                        table.row('user_dt_row_' + id).remove().draw(false);
                        $('#onclick_active_' + id).attr("onclick", "make_not_active(" + id + ")");
                        $('#onclick_active_' + id).html("<i class=\"fa fa-check-square-o\" aria-hidden=\"true\"></i>Make InActive");
                    } else
                    {
                        var table = $('#user_datatable_ajax').DataTable();
                        table.row('user_dt_row_' + id).remove().draw(false);
                        $('#onclick_active_' + id).attr("onclick", "make_not_active(" + id + ")");
                        $('#onclick_active_' + id).html("<i class=\"fa fa-check-square-o\" aria-hidden=\"true\"></i>Make InActive");
                    }
                });
    }
    function make_not_active(id) {
        $.post("{{ route('make.not.active.user') }}", {id: id, _method: 'PUT', _token: '{{ csrf_token() }}'})
                .done(function (response) {
                    if (response == 'ok')
                    {
                        var table = $('#user_datatable_ajax').DataTable();
                        table.row('user_dt_row_' + id).remove().draw(false);
                        $('#onclick_active_' + id).attr("onclick", "make_active(" + id + ")");
                        $('#onclick_active_' + id).html("<i class=\"fa fa-square-o\" aria-hidden=\"true\"></i>Make Active");
                    } else
                    {
                        var table = $('#user_datatable_ajax').DataTable();
                        table.row('user_dt_row_' + id).remove().draw(false);
                        $('#onclick_active_' + id).attr("onclick", "make_active(" + id + ")");
                        $('#onclick_active_' + id).html("<i class=\"fa fa-square-o\" aria-hidden=\"true\"></i>Make Active");
                    }
                });
    }
    function make_verified(id) {
        $.post("{{ route('make.verified.user') }}", {id: id, _method: 'PUT', _token: '{{ csrf_token() }}'})
                .done(function (response) {
                    if (response == 'ok')
                    {
                        var table = $('#user_datatable_ajax').DataTable();
                            table.row('user_dt_row_' + id).remove().draw(false);
                        $('#onclick_verified_' + id).attr("onclick", "make_not_verified(" + id + ")");
                        $('#onclick_verified_' + id).html("<i class=\"fa fa-check-square-o\" aria-hidden=\"true\"></i>Verified");
                    } else
                    {
                        var table = $('#user_datatable_ajax').DataTable();
                            table.row('user_dt_row_' + id).remove().draw(false);
                        $('#onclick_verified_' + id).attr("onclick", "make_not_verified(" + id + ")");
                        $('#onclick_verified_' + id).html("<i class=\"fa fa-check-square-o\" aria-hidden=\"true\"></i>Verified");
                    }
                });
    }
    function make_not_verified(id) {
        $.post("{{ route('make.not.verified.user') }}", {id: id, _method: 'PUT', _token: '{{ csrf_token() }}'})
                .done(function (response) {
                    if (response == 'ok')
                    {
                        var table = $('#user_datatable_ajax').DataTable();
                        table.row('user_dt_row_' + id).remove().draw(false);
                        $('#onclick_verified_' + id).attr("onclick", "make_verified(" + id + ")");
                        $('#onclick_verified_' + id).html("<i class=\"fa fa-square-o\" aria-hidden=\"true\"></i>Not Verified");
                    } else
                    {
                        var table = $('#user_datatable_ajax').DataTable();
                        table.row('user_dt_row_' + id).remove().draw(false);
                        $('#onclick_verified_' + id).attr("onclick", "make_verified(" + id + ")");
                        $('#onclick_verified_' + id).html("<i class=\"fa fa-square-o\" aria-hidden=\"true\"></i>Not Verified");
                    }
                });
    }



    $(document).ready(function() {

        
        $('#form_Submit').click(function(e){

            var id = []; 

            document.getElementById('form_Submit').innerHTML = 'Sending..';

            e.preventDefault();


            $( '#user_id-error' ).html( "" );


            $( '#subject-error' ).html( "" );


                    $.ajaxSetup({

                        headers: {

                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')

                        }

                    });

                    $('.users_checkbox:checked').each(function(){ 
                        id.push($(this).val()); 
                    });

                     if(id.length > 0) { 



                            $.ajax({

                            url: "{{ route('email.admin_send_bulkemail_users') }}",

                            method: 'POST',

                            data: {

                            user_id:id,

                            _token:"{{ csrf_token() }}",

                            subject: $('#subject').val(),             

                            description: $('.description').val(),
                           


                                },

                                        success: function(result){

                                        console.log(result);

                                        document.getElementById('form_Submit').innerHTML = 'Send';

                                        if(result.success) {

                                            $('.alert-danger').hide();

                                            $('#myModal').modal('hide');

                                            $('#user_id').val('');

                                            $('#name').val('');

                                            $('#subject').val('');

                                            $('#summernote').val('');

                                            
                                            var checkbox = $(".users_checkbox");

                                            var selectall = $("#select_all");



                                            $('input[type=checkbox]').each(

                                                function (index, checkbox) {

                                                    if (index != 0) {

                                                        checkbox.checked = false;

                                                    }

                                                });




                                        }

                                        if(result.errors)

                                        {
                                            document.getElementById('form_Submit').innerHTML = 'Send'


                                            if(result.errors.user_id){

                                                $( '#mail_user_id-error' ).html( result.errors.user_id[0] );

                                            }

                                            if(result.errors.subject){

                                                $( '#subject-error' ).html( result.errors.subject[0] );

                                            }


                                        }


                                        },



                            });

                        }

                        });


     $(document).on('click', '#bulk_delete', function(){
        var id = [];
        if(confirm("Are you sure you want to Hide this data from Employers list?"))
        {
            $('.users_checkbox:checked').each(function(){
                id.push($(this).val());
            });
            if(id.length > 0)
            {
                $.ajax({
                    url:"{{ route('users.softdelete')}}",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    method:"get",
                    data:{id:id},
                    success:function(data)
                    {
                        console.log(data);
                        
                       location.reload();
                    },
                    error: function(data) {
                        var errors = data.responseJSON;
                        console.log(errors);
                    }
                });
            }
            else
            {
                alert("Please select atleast one checkbox");
            }
        }
    });


     // Listen for click on toggle checkbox
$('#select-all').click(function(event) {   
    if(this.checked) {
        // Iterate each checkbox
        $(':checkbox').each(function() {
            this.checked = true;                        
        });
    } else {
        $(':checkbox').each(function() {
            this.checked = false;                       
        });
    }
    loadvalue();
}); 

function loadvalue()
        {

            var array = new Array();
            var checkbox = $(".users_checkbox:checked");


            if (checkbox) {


                var check = checkbox.map(function(){

                    array.push($(this).val());

                });

            }

            $("#user_id").val(array);
            console.log(array);
    

        }

       });

</script> 
@endpush