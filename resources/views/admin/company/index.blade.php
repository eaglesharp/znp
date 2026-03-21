@extends('admin.layouts.admin_layout')

@section('content')

<style type="text/css">
    .table td, .table th {
        font-size: 12px;
        line-height: 2.42857 !important;
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
                <li> <span>Employers</span> </li>
            </ul>
        </div>
        <!-- END PAGE BAR --> 
        <!-- BEGIN PAGE TITLE-->
        <h3 class="page-title">Manage Employers <small>Employers</small> </h3>
        <!-- END PAGE TITLE--> 
        <!-- END PAGE HEADER-->
        <div class="row">
            <div class="col-md-12"> 
                <!-- Begin: life time stats -->
                <div class="portlet light portlet-fit portlet-datatable bordered">
                    <div class="portlet-title">
                        <div class="caption"> <i class="icon-settings font-dark"></i> <span class="caption-subject font-dark sbold uppercase">Employers</span> </div>
                        <div class="actions">
                             <a href="{{ route('create.company') }}" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-plus"></i> Add New Employer</a>
                                  <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal"><i class="glyphicon glyphicon-plus"></i> Bulk Email</button>

                            </div>
                    </div>
                    <div class="portlet-body">
                        <div class="table-container">
                            <form method="post" role="form" id="datatable-search-form">
                                <table class="table table-striped table-bordered table-hover"  id="companyDatatableAjax">
                                    <thead>
                                        <tr role="row" class="filter">
                                            <td><input type="text" class="form-control" name="id" id="id" autocomplete="off" placeholder="Search id"></td>
                                            <td><input type="text" class="form-control" name="name" id="name" autocomplete="off" placeholder="Employer Name"></td>
                                            <td><input type="text" class="form-control" name="email" id="email" autocomplete="off" placeholder="Employer Email"></td>
                                            <td><select name="is_active" id="is_active" class="form-control">
                                                    <option value="-1">Is Active?</option>
                                                    <option value="1" selected="selected">Active</option>
                                                    <option value="0">In Active</option>
                                                </select></td>
                                             
                                            <td style="display: none"><select name="is_featured" id="is_featured" class="form-control">
                                                    <option value="-1">Is Featured?</option>
                                                    <option value="1">Featured</option>
                                                    <option value="0">Not Featured</option>
                                                </select></td>
                                            <td></td>
                                            <td></td>
                                            <td width="50px">
                                                Select All<input type="checkbox" name="select-all" id="select-all" />
                                             </td>
                                            <td></td>
                                            
                                        </tr>
                                        <tr role="row" class="heading">
                                            <th>Id</th> 
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Is Active?</th> 
                                            <th >Plan/ Quota</th>
                                            <th style="display: none">Is Featured?</th>
                                            <th style="width: 149px">phone</th>
                                            <th>Checkbox</th>
                                            <th style="width: 149px">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                             
                                    </tbody>
                                </table>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END CONTENT BODY --> 
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
              
                    <textarea id="summernote" name="message"  class="note-editable description"></textarea>
                   
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

 
        $('#form_Submit').click(function(e){

  

                document.getElementById('form_Submit').innerHTML = 'Sending..';

                e.preventDefault();


                $( '#user_id-error' ).html( "" );


                $( '#subject-error' ).html( "" );


                        $.ajaxSetup({

                            headers: {

                                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')

                            }

                        });

     
        $.ajax({

            url: "{{ route('email.adminsendbulkemail') }}",

            method: 'POST',

            data: {

                user_id:$('#user_id').val(),

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

                    $('.subject').val('');

                    $('.description').val('');

                    
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

});


     

    $(function () {
        var oTable = $('#companyDatatableAjax').DataTable({
            processing: true,
            serverSide: true,
            stateSave: true,
            searching: false,
            
            // aaSorting: [[2, 'asc']],
            // "aaSorting": [[ 3, "desc" ]],
            /*		
             "order": [[1, "asc"]],            
             paging: true,
             info: true,
             */
            ajax: {
                url: '{!! route('fetch.data.companies') !!}',
                data: function (d) {
                    d.name = $('#id').val();
                    d.name = $('#name').val();
                    d.email = $('#email').val();
                    d.is_active = $('#is_active').val();
                    d.is_featured = $('#is_featured').val();
                }
            }, columns: [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'is_active', name: 'is_active'},
                {data: 'jobs_quota', name: 'jobs_quota'},

                {data:'phone', name: 'phone',orderable: false, searchable: false},
                {data: 'checkbox', name: 'checkbox', orderable:false, searchable:false},
                {data: 'action', name: 'action', orderable: false, searchable: false},
                
            ]
        });
        $('#datatable-search-form').on('submit', function (e) {
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
        $('#is_active').on('change', function (e) {
            oTable.draw();
            e.preventDefault();
        });
        $('#is_featured').on('change', function (e) {
            oTable.draw();
            e.preventDefault();
        });
    });
    function deleteCompany(id) {
        var msg = 'Are you sure! you want to delete?';
        if (confirm(msg)) {
            $.post("{{ route('delete.company') }}", {id: id, _method: 'DELETE', _token: '{{ csrf_token() }}'})
                    .done(function (response) {
                        if (response == 'ok')
                        {
                            // var table = $('#companyDatatableAjax').DataTable();
                            // table.draw();
                        } else
                        {
                            var table = $('#companyDatatableAjax').DataTable();
                            table.draw();
                        }
                    });
        }
    }
    function makeActive(id) {
        $.post("{{ route('make.active.company') }}", {id: id, _method: 'PUT', _token: '{{ csrf_token() }}'})
                .done(function (response) {
                    if (response == 'ok')
                    {
                        var table = $('#companyDatatableAjax').DataTable();
                        table.row('companyDtRow' + id).remove().draw(false);
                    } else
                    {
                        var table = $('#companyDatatableAjax').DataTable();
                        table.row('companyDtRow' + id).remove().draw(false);
                    }
                });
    }
    function makeNotActive(id) {
        $.post("{{ route('make.not.active.company') }}", {id: id, _method: 'PUT', _token: '{{ csrf_token() }}'})
                .done(function (response) {
                    if (response == 'ok')
                    {
                        var table = $('#companyDatatableAjax').DataTable();
                        table.row('companyDtRow' + id).remove().draw(false);
                    } else
                    {
                        var table = $('#companyDatatableAjax').DataTable();
                        table.row('companyDtRow' + id).remove().draw(false);
                    }
                });
    }
    function makeFreeze(id) {
        $.post("{{ route('make.freeze.company') }}", {id: id, _method: 'PUT', _token: '{{ csrf_token() }}'})
                .done(function (response) {
                    if (response == 'ok')
                    {
                        var table = $('#companyDatatableAjax').DataTable();
                        table.row('companyDtRow' + id).remove().draw(false);
                    } else
                    {
                        var table = $('#companyDatatableAjax').DataTable();
                        table.row('companyDtRow' + id).remove().draw(false);
                    }
                });
    }
    function makeNotFreeze(id) {
        $.post("{{ route('make.not.freeze.company') }}", {id: id, _method: 'PUT', _token: '{{ csrf_token() }}'})
                .done(function (response) {
                    if (response == 'ok')
                    {
                        var table = $('#companyDatatableAjax').DataTable();
                        table.row('companyDtRow' + id).remove().draw(false);
                    } else
                    {
                        var table = $('#companyDatatableAjax').DataTable();
                        table.row('companyDtRow' + id).remove().draw(false);
                    }
                });
    }
    function makeFeatured(id) {
        $.post("{{ route('make.featured.company') }}", {id: id, _method: 'PUT', _token: '{{ csrf_token() }}'})
                .done(function (response) {
                    if (response == 'ok')
                    {
                        var table = $('#companyDatatableAjax').DataTable();
                        table.row('companyDtRow' + id).remove().draw(false);
                    } else
                    {
                    
                        alert('Request Failed!');
                    }
                });
    }
    function makeNotFeatured(id) {
        $.post("{{ route('make.not.featured.company') }}", {id: id, _method: 'PUT', _token: '{{ csrf_token() }}'})
                .done(function (response) {
                    if (response == 'ok')
                    {
                        var table = $('#companyDatatableAjax').DataTable();
                        table.row('companyDtRow' + id).remove().draw(false);
                    } else
                    {
                        alert('Request Failed!');
                    }
                });
    }
</script> 
@endpush