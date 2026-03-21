@extends('admin.layouts.admin_layout')
@section('content')
@push('styles')

<link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">

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
                <li> <span>Locations</span> </li>
            </ul>
        </div>
        <!-- END PAGE BAR --> 
        <!-- BEGIN PAGE TITLE-->
        <h3 class="page-title">Manage Locations <small>Locations</small> </h3>
        <!-- END PAGE TITLE--> 
        <!-- END PAGE HEADER-->
        <div class="row">
            <div class="col-md-12"> 
                <!-- Begin: life time stats -->
                <div class="portlet light portlet-fit portlet-datatable bordered">
                    <div class="portlet-title">
                    <div class="row">
                    <form action="{{ route("location.category.create")}}" method="post">
                    @csrf
                    <div class="col-lg-8">
                    <label>Category</label>
                        <input type ="text" name="category" class="form-control" value="{{ $cate->category??'' }}">
                        @if($errors->has('category'))
                            <div class="error">{{ $errors->first('category') }}</div>
                        @endif

                        <input type="hidden" name="id" value="{{ $cate->id??'' }}">

                        </div>

                        <div class="col-lg-4" style="margin-top:25px">
                        <button class="btn btn-primary" type="submit">Submit</button>
                         <a class="btn btn-success" href="{{ url('admin/create-category-location') }}" type="submit">Add</a>
                    </div>
                    </div>
                    </form>
                    <div class="portlet-body">
                        <div class="table-container">
                            <form method="post" role="form" id="country-search-form">
                                <table class="table table-striped table-bordered table-hover"  id="countryDatatableAjax">
                                    <thead>   

                                    @php

                                    $category = \App\LocationCategory::latest()->get();


                                    @endphp                                     


                                        <tr role="row" class="heading">                                            
                                            <th>Category</th>                                          
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach($category as $cat)
                                        <tr>
                                            <td>{{$cat->category??''}}</td>
                                           <td><a href="{{ route('edit.category.location',$cat->id) }}" class="btn btn-primary" >Edit</a>
                                               
                                                    <a href="{{ route('delete.category.location',$cat->id) }}" class="btn btn-danger">Delete</
                                             </td>

                                        </tr>
                                        @endforeach

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
@endsection
@push('scripts') 
<script type="text/javascript" src=
"https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js">
     </script>
     <script src="https://cdn.datatables.net/plug-ins/1.10.11/sorting/date-eu.js" type="text/javascript"></script>
<script>
        $(document).ready(function() {
        $('#countryDatatableAjax').DataTable({ 
            "order": [[ 3, "desc" ]],
           
          //  "columnDefs": [ {"type": 'date', 'targets': [3] } ],



        });
    });
    
</script> 
@endpush