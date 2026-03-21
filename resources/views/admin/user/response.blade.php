@extends('admin.layouts.admin_layout')
@section('content')
<div class="page-content-wrapper"> 
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content"> 
        <!-- BEGIN PAGE HEADER--> 
        <!-- BEGIN PAGE BAR -->
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li> <a href="{{ route('admin.home') }}">Home</a> <i class="fa fa-circle"></i> </li>
                <li> <a href="{{ route('list.users') }}">Users</a> <i class="fa fa-circle"></i> </li>
                <li> <span>Add User</span> </li>
            </ul>
        </div>
        <!-- END PAGE BAR --> 
        <!-- BEGIN PAGE TITLE-->
        <!--<h3 class="page-title">Edit User <small>Users</small> </h3>-->
        <!-- END PAGE TITLE--> 
        <!-- END PAGE HEADER-->
        <br />
        @include('flash::message')
        <div class="row">
            <div class="col-md-12">
                <form action="{{url('admin/bulkuserresume')}}" method="POST" enctype="multipart/form-data">
              @csrf
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption font-red-sunglo">
                             <i class="icon-settings font-red-sunglo"></i> <span class="caption-subject bold uppercase">Bulk Users Resume Upload</span> 
                            
                        </div>
                    
                    </div>
                    @foreach($data1 as $data)
              
                    {{$data}}
                    @endforeach
                   
                </div>
            </form>
            </div>
        </div>
    </div>
    <!-- END CONTENT BODY --> 
</div>
@endsection