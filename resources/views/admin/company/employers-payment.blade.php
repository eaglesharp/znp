@extends('admin.layouts.admin_layout')

@section('content')
@push('styles')

<link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    
@endpush

<style type="text/css">
    .table td, .table th {
        font-size: 12px;
        line-height: 2.42857 !important;
    }	

    @media (max-width:1400px) {
    table, .portlet-body {
    /* display: block; */
    width: 100%;
    overflow: auto;
  }
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
                <li> <span>Employer Payement History</span> </li>
            </ul>
        </div>
        <!-- END PAGE BAR --> 
        <!-- BEGIN PAGE TITLE-->
        {{-- <h3 class="page-title">Employers <small>Enquiry</small> </h3> --}}
        @if(session()->has('message'))
        
        <div class="alert alert-success">
        
            <ul>
        
                {{session()->get('message')}}
        
            </ul>
        
        </div>
        
        @endif
        @if(session()->has('newtext'))
        
        <div class="alert alert-success">
        
            <ul>
        
                {{session()->get('newtext')}}
        
            </ul>
        
        </div>
        
        @endif
        <!-- END PAGE TITLE--> 
        <!-- END PAGE HEADER-->
        <div class="row">
            <div class="col-md-12">     
                <!-- Begin: life time stats -->
                <div class="portlet light portlet-fit portlet-datatable bordered">
                    <div class="portlet-title">
                        <div class="caption"> <i class="icon-settings font-dark"></i> <span class="caption-subject font-dark sbold uppercase">Employer Payement History</span> </div>
                        
                    </div>
                    <div class="portlet-body">
                        <div class="table-container">
                            <table id="tableID" class="display" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Plan</th>
                                        <th>Payment Date</th>
                                        <th>Payment Id</th>
                                       
                                        <th>Email</th>
                                       
                                        <th>Amount</th>
                                        <th>Package Start date</th>
                                        <th>Package End date</th>
                                        <th>Status</th>
                                     
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        
                                    $payments = \App\CandidatePayment::latest()->get();
                                    // echo $payment;
                                    ?>
                                    @foreach ($employers as $employer)
                                    <?php
                                        
                                    $company = \App\Company::where('id',$employer->company_id)->first();
                                    $package = \App\Package::where('id',$employer->plan_id)->first();
                                    // echo $payment;
                                    ?>
                                        <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{$package->package_title??''}}</td>
                                        <td>{{ \Carbon\Carbon::parse($employer->created_at??'')->format('d/m/Y')}}</td>
                                        <td>{{ $employer->payment_id??'' }}</td>
                                       
                                        <td>{{$company->email??''}}</td>
                                       
                                        <td>{{ $employer->amount??'' }}</td>
                                        <td> @if($employer->payment_status == 1){{ \Carbon\Carbon::parse($employer->plan_start_date??'')->format('d/m/Y')}}@endif</td>
                                        <td> @if($employer->payment_status == 1){{ \Carbon\Carbon::parse($employer->plan_end_date??'')->format('d/m/Y')}}@endif</td>
                                        @if($employer->payment_status == 3)
                                        <td><span style="background-color:#5ca8ff; padding:5px;">Failed</span></td>
                                        @elseif($employer->payment_status == 1)
                                        <td><span style="background-color:#92ff92; padding:5px;">Success</span></td>
                                        @elseif($employer->payment_status == 0)
                                        <td><span style="background-color:#ff4e4e; padding:5px;">Failed</span></td>                                       
                                        @else
                                        <td></td>
                                        @endif
                                        </tr>
                                            
                                        @endforeach
                                </tbody>
                            </table>
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
  
    /* Initialization of datatable */
    $(document).ready(function() {
        $('#tableID').DataTable({ 
            // "order": [[ 3, "desc" ]],
            "ordering": false
           
            // "columnDefs": [ {"type": 'date', 'targets': [3] } ],


        });
    });
</script>

@endpush