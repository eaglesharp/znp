@extends('admin.layouts.admin_layout')
@section('content')
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
        @php
        $categories = \App\LocationCategory::latest()->get();
        $locations = \App\Location::latest()->get();
        @endphp
        <div class="row">
            <div class="col-md-12"> 
                <!-- Begin: life time stats -->
                <div class="portlet light portlet-fit portlet-datatable bordered">
                    <div class="portlet-title">
                       <form action="{{ route("create.location")}}" method="post">

                    @csrf

                    <input type="hidden" name="id" value="{{ $location->id??''}}">
                    <div class="col-lg-4">
                    <label>Category</label>
                       <select name="category" class="form-control">
                        @foreach($categories as $cat)
                           <option value="{{ $cat->id }}" @if(isset($location)) @if($location->category_id == $cat->id) selected @endif @endif>{{ $cat->category??'' }}</option>
                        @endforeach   
                       </select>
                        @if($errors->has('category'))
                            <div class="error">{{ $errors->first('category') }}</div>
                        @endif
                        
                    </div>
                     <div class="col-lg-4">
                    <label>Location</label>
                        <input type ="text" name="location" class="form-control" value="{{ $location->location??''}}">
                        @if($errors->has('location'))
                            <div class="error" style="color: red">{{ $errors->first('location') }}</div>
                        @endif
                        
                    </div>

                        <div class="col-lg-4" style="margin-top: 25px">
                        <button class="btn btn-primary" type="submit">Submit</button>
                        <a class="btn btn-success" href="{{ route('list.locations') }}" type="submit">Add</a>
                    </div>
                    </div>
                    </form>
                    </div>
                    <div class="portlet-body">
                        <div class="table-container">
                            <form method="post" role="form" id="country-search-form">
                                <table class="table table-striped table-bordered table-hover"  id="countryDatatableAjax">
                                    <thead>
                                      
                                        <tr role="row" class="heading">                                            
                                            <th>Category</th>
                                            <th>Location</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($locations as $location)
                                        <tr>
                                            @php
                                            $category = \App\LocationCategory::where("id",$location->category_id)->first();
                                            @endphp
                                            <td>{{ $category->category??'' }}</td>
                                            <td>{{ $location->location??'' }}</td>
                                            <td><a href="{{ route('edit.location',$location->id) }}" class="btn btn-primary" >Edit</a>
                                               
                                                    <a href="{{ route('delete.location',$location->id) }}" class="btn btn-danger">Delete</
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