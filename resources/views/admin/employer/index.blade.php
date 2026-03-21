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
    display: block;
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
                <li> <span>Enquiry</span> </li>
            </ul>
        </div>
        <!-- END PAGE BAR --> 
        <!-- BEGIN PAGE TITLE-->
        <h3 class="page-title">Employers <small>Enquiry</small> </h3>
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
                        <div class="caption"> <i class="icon-settings font-dark"></i> <span class="caption-subject font-dark sbold uppercase">Employers</span> </div>
                        
                    </div>
                    <div class="portlet-body">
                        <div class="table-container">
                            <table id="tableID" class="display" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Company Name</th>
                                        <th>Offical Email</th>
                                        <th>Mobile/Landline</th>
                                        <th>Contact Person Name</th>
                                        <th>GSTIN</th>
                                        <th>Company/Recruitment Firm</th>
                                        <th>Pincode</th>
                                        <th>Package Name</th>
                                        <th>Enquiry Date</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($enquirydata as $enquirydata)

                                    
                                        
                                        <tr>
                                        <td>{{$enquirydata->company_name}}</td>
                                        <td>{{$enquirydata->email}}</td>
                                        <td>{{$enquirydata->mobile}}</td>
                                        <td>{{$enquirydata->person_name}}</td>
                                        <td>{{$enquirydata->gstin}}</td>
                                        <td>{{$enquirydata->size}}</td>
                                        <td>{{$enquirydata->pincode}}</td>
                                        @if($enquirydata->package_name == 17)
                                        <td>Trail</td>
                                        @elseif($enquirydata->package_name == 18)
                                        <td>Basic</td>
                                        @elseif($enquirydata->package_name == 19)
                                        <td>Standard</td>
                                        @elseif($enquirydata->package_name == 20)
                                        <td>Premium</td>
                                        @else
                                        <td></td>

                                        @endif


                                        <?php 
                                        $collection = \App\Company::all();
                                        
                                        foreach($collection as $value)
                                        {
                                            $value = $value->email;
                                        }
                                        
                                        $data = $collection->contains('email', $enquirydata->email);

               

                                        
                                        ?>
                                        <td>{{$enquirydata->created_at->format('d/m/y')}}</td>
                                        
                                       @if($data)
                                          <td>Registered</td>
                                       @else                                    
                                          <td> Not Registered</td>
                                        @endif
                                      
                                        <td>
                                            @if($data)

                                            <a href="{{url('admin/enquiry/'.$enquirydata->id)}}" class="btn btn-danger a-btn-slide-text" onclick="return confirm('Are you sure! you want to delete?')">
                                            
                                                <span><strong>Delete</strong></span>            
                                           </a>
                                           

                                          
                                            @else 
                                            <a href="{{url('admin/register-employer/'.$enquirydata->id)}}" class="btn btn-success a-btn-slide-text" onclick="return confirm('Are you sure to Add Registered Employer')">
                                       
                                                <span><strong>Confirm</strong></span>            
                                          </a>
                                          <a href="{{url('admin/enquiry/'.$enquirydata->id)}}" class="btn btn-danger a-btn-slide-text" onclick="return confirm('Are you sure! you want to delete?')">
                                            
                                            <span><strong>Delete</strong></span>            
                                       </a>
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

<script>
  
    /* Initialization of datatable */
    $(document).ready(function() {
        $('#tableID').DataTable({ 
            "order": [[ 3, "desc" ]],
           
            "columnDefs": [ {"type": 'date', 'targets': [3] } ],



        });
    });
</script>

@endpush