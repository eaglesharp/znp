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
                             <a href="{{ route('bulkuseruploads') }}" class="btn btn-xs btn-success">Bulk User Upload</a>
                        </div>
                    
                    </div>
                    @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <div>{{$error}}</div>
                    @endforeach
                    @endif
                    @if(session('success'))
                    <p class="text-success font-bold">{{ session('success') }}</p>
                    @endif
                    {{-- @foreach ($data->all() as $item)
                        <div>{{$item}}</div>
                    @endforeach --}}
                       
                    @if(session()->has('error'))
                  
                       {{-- <div>{{$item}}</div> --}}
                   
                   <div class="alert alert-danger">
                    {{ session('error') }}
                   </div>
                   
                   @endif
                                                          
                                                       
                                                              
                                                            {{-- <div>{{$item}}</div> --}}
                                                        @if(isset($data))
                                                        
                                           
                                                        
                                                        
                                                        
                                                        @foreach($data as $t)
                                                        
                                                        <div class="alert alert-danger">
                                                            {{ $t }}
                                                        </div>
                                                                                                         
                                                         @endforeach   
                                                        @endif
                                                        
                
                
              

                    
                    <div class="form-group" id="div_summary">
                        <label for="summary" class="bold">Multiple Resume</label>(Note : The Pdf File Name Should be Candidates Email id )
                        <input type="file" name="file[]" id="file" class="form-control" required multiple>
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
@push('scripts') 
<script>
$("document").ready(function(){
    setTimeout(function(){
       $("div.alert").remove();
    }, 2000 ); // 5 secs

});
</script>




{{-- <script>
    @if(Session::has('newtext'))
        toastr.options =
        {
            "closeButton" : true,
            "progressBar" : true
        }
                toastr.success("{{ session('newtext') }}");
        @endif
        
        </script> --}}



{{-- @if(session()->has('error'))
    <div class="alert alert-danger">
        {{ session()->get('error') }}
    </div>
@endif --}}
@endpush