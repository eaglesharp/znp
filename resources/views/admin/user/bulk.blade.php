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

                <form action="{{url('admin/bulkuserupload')}}" method="POST" enctype="multipart/form-data">

              @csrf

                <div class="portlet light bordered">

                    <div class="portlet-title">

                        <div class="caption font-red-sunglo">

                             <i class="icon-settings font-red-sunglo"></i> <span class="caption-subject bold uppercase">Bulk Users Upload</span> 

                             <a href="{{ route('bulkresume') }}" class="btn btn-xs btn-success">CV Upload</a>

                             <a href="{{ route('download.state') }}" class="btn btn-xs btn-success">Sample Bullk User</a>

                             {{-- <a href="{{ route('download.state') }}" class="btn btn-xs btn-success">State & City</a> --}}

                             {{-- <a href="{{ route('download.careerlevel') }}" class="btn btn-xs btn-success">Career Level</a> --}}

                             <a href="{{ route('download.languages') }}" class="btn btn-xs btn-success">id Details</a>

                             <a href="{{ route('download.industry') }}" class="btn btn-xs btn-success">Specilazion</a>

                             <a href="{{ route('download.degreetype') }}" class="btn btn-xs btn-success">Course</a>

                             <a href="{{ route('download.jobskills') }}" class="btn btn-xs btn-success">Key Skills</a>

                             <a href="{{ route('latest-company-export') }}" class="btn btn-xs btn-success">Latest Company</a>

                             

                             {{-- <a href="{{ route('download.country') }}" class="btn btn-xs btn-success">Country</a> --}}

                        </div>

                    

                    </div>

                    @if ($errors->any())

                    @foreach ($errors->all() as $error)

                    <div>

                    <span class="error" style="color:#a94442">{{$error}}</span></div>

                    @endforeach

                    

                    @endif

                    @if(session()->has('success'))

    <div class="alert alert-success">

        {{ session()->get('success') }}

    </div>

@endif

                    <div class="form-group" id="div_summary">

                        <label for="summary" class="bold">Excel</label>

                        <input type="file" name="file" id="file" class="form-control" required>

                        <span class="help-block summary-error"></span> </div>



                        <button type="submit" class="btn btn-large btn-primary" >Submit<i class="fa fa-arrow-circle-right" aria-hidden="true"></i></button>

                </div>

            </form>

            </div>

        </div>

    </div>

    <!-- END CONTENT BODY --> 

</div>

@endsection