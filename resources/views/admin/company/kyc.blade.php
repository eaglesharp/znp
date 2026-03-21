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
                <li> <span>KYC Documents</span> </li>
            </ul>
        </div>
        <!-- END PAGE BAR --> 
        <!-- BEGIN PAGE TITLE-->
        <h3 class="page-title">Manage KYC Documents <small>Jobs</small> </h3>
        <!-- END PAGE TITLE--> 
        <!-- END PAGE HEADER-->
        <div class="row">
            <div class="col-md-12"> 
                <!-- Begin: life time stats -->
                <div class="portlet light portlet-fit portlet-datatable bordered">
                    <div class="portlet-title">
                        <div class="caption"> <i class="icon-settings font-dark"></i> <span class="caption-subject font-dark sbold uppercase">KYC Documents</span> </div>
                        <div class="actions "> 
                           

                            {{-- <a href="{{ route('create.job') }}" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-plus"></i> Add New Job</a>  --}}
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="table-container">
                            <form method="post" role="form" id="job-search-form">
                                <table class="table table-striped table-bordered table-hover"  id="jobDatatableAjax1">
                                    <thead>
                                        {{-- <tr role="row" class="filter">
                                            <td>{!! Form::select('company_id', ['' => 'Select Company']+$companies, null, array('id'=>'company_id', 'class'=>'form-control')) !!}</td>
                                            <td><input type="text" class="form-control" name="title" id="title" autocomplete="off" placeholder="Job title"></td>
                                            <td><input type="text" class="form-control" name="description" id="description" autocomplete="off" placeholder="Job description"></td>
                                            
                                           
                                        </tr> --}}
                                        <tr role="row" class="heading">
                                            <th>Document Type</th>
                                            <th>Document Downloads</th> 
                                            <th>Action</th>
                                                                             
                                           
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                        @foreach ($kycs as $kyc)
                                      
                                        <tr>
                                            <td>{{ $kyc->document_type }}</td>
                                            <td>
                                               @if ($kyc->selfie)
                                                    <a href="{{ asset('uploads/kyc_documents/'.$kyc->selfie) }}" class="line_change btn btn-primary" download>
                                                         Selfie <i class="fa fa-download" aria-hidden="true"></i>
                                                    </a>
                                                @endif 
                                                
                                                @if($kyc->document_type == "freelancer")
                                                <a href="{{ url('admin/kyc-document-download/'.$kyc->pancard) }}" target="_blank" rel="" class="line_change btn btn-primary">Pancard <i class="fa fa-download" aria-hidden="true"></i></a>
                                               
                                                <a href="{{ url('admin/kyc-document-download/'.$kyc->aadharcard) }}" target="_blank" rel="" class="line_change btn btn-primary pl-3">Aadhar card <i class="fa fa-download" aria-hidden="true"></i></a>
                                                @endif
                                               
                                               
                                                @if($kyc->document_type == "sole")
                                                <a href="{{ url('admin/kyc-document-download/'.$kyc->sole_gstcertificate) }}" target="_blank" rel="" class="line_change btn btn-primary">GST registration certificate <i class="fa fa-download" aria-hidden="true"></i></a>
                                               
                                                <a href="{{ url('admin/kyc-document-download/'.$kyc->sole_pancard) }}" target="_blank" rel="" class="line_change btn btn-primary pl-3">PAN Card Copy <i class="fa fa-download" aria-hidden="true"></i></a>

                                                <a href="{{ url('admin/kyc-document-download/'.$kyc->sole_aadharcard) }}" target="_blank" rel="" class="line_change btn btn-primary pl-3">Aadhar Copy <i class="fa fa-download" aria-hidden="true"></i></a>
                                                @endif
                                                
                                                @if($kyc->document_type == "partnership")
                                                <a href="{{ url('admin/kyc-document-download/'.$kyc->partnership_registrationcertificate) }}" target="_blank" rel="" class="line_change btn btn-primary">Registration Certificate <i class="fa fa-download" aria-hidden="true"></i></a>
                                               
                                                <a href="{{ url('admin/kyc-document-download/'.$kyc->partnership_pancard) }}" target="_blank" rel="" class="line_change btn btn-primary pl-3">PAN card <i class="fa fa-download" aria-hidden="true"></i></a>

                                                <a href="{{ url('admin/kyc-document-download/'.$kyc->partnership_aadharcard) }}" target="_blank" rel="" class="line_change btn btn-primary pl-3">Proof of Legal <i class="fa fa-download" aria-hidden="true"></i></a>
                                                @endif

                                                @if($kyc->document_type == "limited")
                                                <a href="{{ url('admin/kyc-document-download/'.$kyc->limited_certificateofincorporation) }}" target="_blank" rel="" class="line_change btn btn-primary">Certificate of Incorporation <i class="fa fa-download" aria-hidden="true"></i></a>
                                               
                                                <a href="{{ url('admin/kyc-document-download/'.$kyc->limited_pancardllp) }}" target="_blank" rel="" class="line_change btn btn-primary pl-3">PAN of LLP <i class="fa fa-download" aria-hidden="true"></i></a>

                                                @endif


                                                @if($kyc->document_type == "private")
                                                <a href="{{ url('admin/kyc-document-download/'.$kyc->private_certificateofincorporation) }}" target="_blank" rel="" class="line_change btn btn-primary">Certificate of incorporation <i class="fa fa-download" aria-hidden="true"></i></a>
                                               
                                                <a href="{{ url('admin/kyc-document-download/'.$kyc->private_pancardcompany) }}" target="_blank" rel="" class="line_change btn btn-primary pl-3">PAN card <i class="fa fa-download" aria-hidden="true"></i></a>

                                                <a href="{{ url('admin/kyc-document-download/'.$kyc->private_commencementcertificate) }}" target="_blank" rel="" class="line_change btn btn-primary pl-3">business commencement certificate <i class="fa fa-download" aria-hidden="true"></i></a>
                                             
                                                <a href="{{ url('admin/kyc-document-download/'.$kyc->private_proofofcompany) }}" target="_blank" rel="" class="line_change btn btn-primary pl-3">Proof of the company's name <i class="fa fa-download" aria-hidden="true"></i></a>

                                             
                                                @endif


                                            </td>  
                                               
                                            <td>


                                                @if($kyc->kyc_verified == 2)
                                                <a href="#" target="_blank" rel="" class="line_change btn btn-success pl-3 disabled">Approved <i class="fa fa-check" aria-hidden="true"></i></a>
                                                @else
                                                <a href="{{ url('admin/kyc-document-status/'.$kyc->id.'/2') }}" target="_blank" rel="" class="line_change btn btn-success pl-3">Approve <i class="fa fa-check" aria-hidden="true"></i></a>
                                                @endif

                                                @if($kyc->kyc_verified == 3)
                                                <a href="#" target="_blank" rel="" class="line_change btn btn-danger pl-3 disabled">Rejected <i class="fa fa-ban" aria-hidden="true"></i></a>
                                                @else
                                                <a href="{{ url('admin/kyc-document-status/'.$kyc->id.'/3') }}" target="_blank" rel="" class="line_change btn btn-danger pl-3">Reject <i class="fa fa-ban" aria-hidden="true"></i></a>
                                                @endif
                                             

                                                
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

@endpush