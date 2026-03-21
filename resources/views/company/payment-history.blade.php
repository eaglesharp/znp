@extends('layouts.app')

@section('content')

    <!-- Header start -->
    @push('styles')

<link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">  
@endpush

    @include('includes.header')

<style>
    .table .thead-dark th{
        background-color: #002e6e !important;
    }
    .specify{
        display: block !important;
    }
    .payment-success{
        background-color: #6ad26a;
        padding: 6px;
        border-radius: 20px;
        margin-top: 152px;
        color: aliceblue;
    }
    .payment-success1{
        background-color: red;
        padding: 6px;
        border-radius: 20px;
        margin-top: 152px;
        color: aliceblue;

    }
    
</style>
<section class="contact_bg-color">

    <div class="container ">

        <div class="row">

            <div class="col-lg-12 text-center pt-4 pt-sm-5 pb-sm-3">

                <div class="contact_head-color py-1">

                Payment History

                </div>

            </div>

        </div>

    </div>

</section>
    <section class="section_canddashboard section_empdashboard pb-3 pb-sm-5">

        <div class="container">

            <div class="row py-3">

                <div class="col-md-12">

                    <div class="dash_box p-xl-3">

                        <div class="row specify employe_dashboard-aligin" style="width: 98%;margin-left: 9px;">

                            <!-- <div class="col-md-3 py-2 py-lg-0 text-center vertical">

                               <a href="javascript:void(0);" class="cand_dtxt">Your Plan</a>

                                <h2 class="py-lg-2 mx-auto  canddash_head">$18</h2>

                                <div class="text-center pb-4 px-4">Access 150 candidate profile and resume</div>

                            </div> -->
                          
                            <div class="table-responsive">
                            <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Plan</th>
                                        <th>Payment Date</th>
                                        <th>Payment Id</th>
                                        <th>Amount</th>                                      
                                        <th>Package Start Date</th>
                                        <th>Package End Date</th>
                                        <th>Status</th>
                                        <th>Invoice</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($payments as $payment)
                                    <tr>

                                        @php
                                            $plan = \App\Package::where('id',$payment->plan_id)->first();
                                        @endphp
                                      
                                        <td>{{ $plan->package_title??'' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($payment->created_at??'')->format('d/m/Y') }}</td>
                                        <td>{{ $payment->payment_id??'' }}</td>
                                        <td>Rs {{ $payment->amount??'' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($company_detail->package_start_date??'')->format('d/m/Y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($company_detail->package_end_date ?? '')->addDays(30)->format('d/m/Y') }}
                                        </td>
                                        <td >@if($payment->payment_status == 1) <span class="payment-success">Success</span> @else<span class="payment-success1"> Failure </span> @endif</td>
                                        
                                        <td >@if($payment->invoice_status == 1)<a class="btn btn-primary" style="float:left;margin-right:20px;" href="{{url('download-invoice',$payment->payment_id)}}">Download</a>@endif</td>
                                        
                                       
                                    </tr>
                                    @endforeach
                                   
                                </tbody>
                            </table>
                        </div>

                        </div>

                        {{-- <div class="row employe_dashboard-aligin mt-md-5"> --}}


                        </div>

                        <!-- <div class="col-12 py-2 py-lg-0">



                        </div> -->

                    </div>

                </div>

            </div>

        </div>

    </section>







    @include('includes.footer')

@endsection

@push('scripts')





<script type="text/javascript" src=
"https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js">
     </script>


<script>
    $(document).ready(function() {
	//Only needed for the filename of export files.
	//Normally set in the title tag of your page.
	document.title='Simple DataTable';
	// DataTable initialisation
	$('#example').DataTable(
		{
			"dom": '<"dt-buttons"Bf><"clear">lirtp',
			"paging": true,
			"autoWidth": true,
            
            "ordering": false
			"buttons": [

			]
		}
	);
});
</script>

@endpush