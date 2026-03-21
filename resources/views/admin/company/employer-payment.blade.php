@extends('admin.layouts.admin_layout')

@section('content')
@push('styles')

<link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">  
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
                                        <th>Plan</th>
                                        <th>Payment Date</th>    
                                        <th>Payment Id</th>   
                                                                        
                                       
                                        <th>Amount</th>
                                        <th>Package Start date</th>
                                        <th>Package End date</th>
                                        <th>Status</th>
                                        <th>Invoice</th>
                                     
                                    </tr>
                                </thead>
                                <tbody>
                                   
                                    @foreach ($payments as $payment)

                                    @php
                                        $plan = \App\Package::where('id',$payment->plan_id)->first();
                                    @endphp
                                   
                                        <tr>
                                            <td>{{$plan->package_title??''}}</td>
                                            <td>{{ \Carbon\Carbon::parse($payment->created_at ??'')->format('d/m/Y')}}</td>
                                        <td>{{ $payment->payment_id??'' }}</td> 
                                                                                  
                                       
                                        <td>{{ $payment->amount??'' }}</td>
                                        <td>@if($payment->payment_status == 1){{ \Carbon\Carbon::parse($company->package_start_date??'')->format('d/m/Y')}}@endif</td>
                                        <td>@if($payment->payment_status == 1){{ \Carbon\Carbon::parse($company->package_end_date??'')->format('d/m/Y')}}@endif</td>
                                        @if($payment->payment_status == 0)
                                        <td><span style="background-color:#ff4e4e; padding:5px;">Failed</span></td>
                                        @elseif($payment->payment_status == 1)
                                        <td><span style="background-color:#92ff92; padding:5px;">Success</span></td>
                                        @elseif($payment->payment_status == 2)
                                        <td><span style="background-color:#ff4e4e; padding:5px;">Declined</span></td>                                       
                                        @else
                                        <td></td>
                                        @endif
                                        <td>
                                            @if($payment->payment_status == 1)
                                            <div class="form-group">
                                                <div class="custom-control custom-switch">
                                                  <input type="checkbox" class="custom-control-input"
                                                   {{($payment->invoice_status) ? 'checked' : ''}}
                                                     onclick="changeUserStatus(event.target, {{ $payment->id }});">

                                                  <label class="custom-control-label pointer">@if($payment->invoice_status == 1) Enabled @else Disabled @endif</label>
                                               </div>
                                            </div>
                                            @endif

                                        </td>
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
     <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script>
  
    /* Initialization of datatable */
    $(document).ready(function() {
        $('#tableID').DataTable({ 
            // "order": [[ 3, "desc" ]],
           
            // "columnDefs": [ {"type": 'date', 'targets': [3] } ],
            "ordering": false


        });
    });
    
</script>
<script>

    function changeUserStatus(_this, id) {
        var status = $(_this).prop('checked') == true ? 1 : 0;
       
        $.post("{{ route('change.invoice.status') }}", {id: id, status: status , _method: 'POST', _token: '{{ csrf_token() }}'})
                .done(function (response) {
                    
                    if (response == 'ok')
                    {
                        location.reload();
                      
                    } else
                    {
                      location.reload();
                    }
                });
    }
    </script>
@endpush