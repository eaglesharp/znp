<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CandidatePayment;
use App\Company;
use App\EmployerPayment;
use App\EmployerPaymenthistory;
use App\Package;
use Illuminate\Support\Facades\Auth;
use Razorpay\Api\Api;
use App\User;
use Illuminate\Support\Carbon;
use App\Traits\CompanyTrait;
use Illuminate\Support\Facades\Mail;
// use PDF;
use Barryvdh\DomPDF\Facade as PDF;
use App\Traits\CompanyPackageTrait;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\Session;

class RazorpayController extends Controller
{
    use CompanyTrait;

    use CompanyPackageTrait;

    // public function razorPaySuccess(Request $request){
    //      dd($request->input());
    //     $data = [
    //               'user_id' => '1',
    //               'payment_id' => $request->payment_id,
    //               'amount' => $request->amount,
    //            ];
    //     // $getId = Payment::insertGetId($data);  
    //     $arr = array('msg' => 'Payment successfully credited', 'status' => true);
    //     return Response()->json($arr);    
    //     }
        public function RazorThankYou()
        {
            
               if(Auth::check())
            {
               
              
                return view('thankyou');

            }
          
            
            if(Auth::guard('company'))
            {
                
               
              
                return view('employerthankyou');
            }
         
       
        }

        public function paymentfailure()
        {
            
            if(Auth::check())
            {
                $user = User::where('id',Auth::user()->id)->first();
               
                $user->payment_status = 0;
                $user->save();
                $final = CandidatePayment::create([
                   
                    'user_id' => $user->id,
                    'payment_status' => 0,
                    'amount' => 299                 
                  
        
                ]);
                return view('payment-failure');

            }
            if(Auth::guard('company'))
            {
             //   dd('yes company');
                $company = Company::where('id',Auth::guard('company')->user()->id)->first();
                $total_amount = Session::get('amount');
                $plan  = Session::get('plan');
                // dd($plan);
                $final = EmployerPayment::create([
     
                    'company_id' => $company->id,
                    'payment_status' => 0,
                    'payment_activity' => 0,       
                    'amount' => $total_amount,
                    'plan_id' => $plan
            
                ]);
                $company->payment_status = 2;
                $company->save();
                return view('employer-payment-failure');
            }
    
        }
    public function razorlayoffPaySuccess(Request $request)
    {

        $input = $request->all();

       // dd($input);

        $api = new Api('rzp_test_jwhINIWE9ZqYHY','csZeV7lBneXenANsjQuxnzzi');

        $payment = $api->payment->fetch($input['razorpay_payment_id']);

        if (($payment['status'] == "captured") || ($payment['status'] == "authorized")) {

            $final = CandidatePayment::create([
                'payment_id' => $input['razorpay_payment_id'],
                'user_id' => Auth::user()->id,
                'payment_status' => 1,
                'amount' => $input['totalAmount'],
                'type' => 2

            ]);

            $current = Carbon::now();

            $user = User::where('id',Auth::user()->id)->first();




            if($user->layoff_package_id > 0)
            {

                $update_date = $user->layoff_package_end_date;
                $user->layoff_payment_status = 1;
                $user->layoff_package_start_date = $user->layoff_package_start_date;
                if($update_date < $current)
                {
                    $package = $current;
                    $user->layoff_package_end_date = $package->addDays(90);
                }else{
                    $user->layoff_package_end_date = $update_date->addDays(90);
                }

                $user->layoff_package_package_id = 6;
                $user->save();

            }else{

                $user->layoff_payment_status = 1;
                $user->layoff_package_start_date = Carbon::now();
                $user->layoff_package_end_date = $current->addDays(90);
                $user->layoff_package_id = 6;
                $user->save();
            }



            $rand = Str::random(4);

            $invoice_no = $rand.'_'.date('Y-m-d');

            $gst = $input['totalAmount']*18/100;

            $total_amount =$input['totalAmount'];

            $pdf = PDF::loadView('invoices.candidate-layoffpdf-invoice',[

                'name' => $user->first_name,
                'email' => $user->email,
                'mobile' => $user->phone,
                'invoice_no' => $invoice_no,
                'amount' => $input['totalAmount'],
                'gst'  => $gst,
                'total_amount' => $total_amount,
                'start_date' => $user->layoff_package_start_date,
                'end_date'  => $user->layoff_package_end_date,
                'payment_id' => $input['razorpay_payment_id']


            ]);


            $invoiceName = 'Invoice'.'-'.time().'_'.date('Y-m-d').'.pdf';

            $pdf->save(public_path('invoices/'. $invoiceName));


            $data = [

                'title' =>   $request->input('email'),

                'subject'  => 'Payment Success',

                'name' => $user->name,

                'gst' => 499*18/100,

                'total_amount' => number_format($total_amount, 2),

                'start_date' => $user->layoff_package_start_date,
                'end_date'  => $user->layoff_package_end_date,
                'payment_id' => $input['razorpay_payment_id']


            ];

            $email = $user->email;

            Mail::send('emails.candidate_layoffpayment', $data, function($message) use ($data,$email,$invoiceName) {

                $message->to($email)->from('info@zeronoticeperiod.com') 

                    ->subject($data['subject']);

            });



            $final->status = $payment['status'];

            return response()->json([
                'success' => true,
                'message' => 'Payment successful',
            ], 200);

        } else {

            $user = User::where('id',Auth::user()->id)->first();
            $user->payment_status = 0;
            $user->save();

            return response()->json([
                'success' => false,
                'message' => 'Payment Failed!',
            ], 401);
        }
    }
          
public function razorPaySuccess(Request $request)
{

    $input = $request->all();

    $api = new Api('rzp_test_jwhINIWE9ZqYHY','csZeV7lBneXenANsjQuxnzzi');
   
    $payment = $api->payment->fetch($input['razorpay_payment_id']);

    if (($payment['status'] == "captured") || ($payment['status'] == "authorized")) {
  
        $final = CandidatePayment::create([
            'payment_id' => $input['razorpay_payment_id'],
            'user_id' => Auth::user()->id,
            'payment_status' => 1,
            'amount' => $input['totalAmount'],
            'type' => 1
            
        ]);

        $current = Carbon::now();

        $user = User::where('id',Auth::user()->id)->first();

        


        if($user->package_id > 0)
        {

            $update_date = $user->package_end_date;
            $user->payment_status = 1;
            $user->package_start_date = $user->package_start_date;
            if($update_date < $current)
            {
                $package = $current;
                $user->package_end_date = $package->addDays(30);
            }else{
                $user->package_end_date = $update_date->addDays(30);
            }
            
            $user->package_id = 5;
            $user->save();

        }else{

            $user->payment_status = 1;
            $user->package_start_date = Carbon::now();
            $user->package_end_date = $current->addDays(30);
            $user->package_id = 5;
            $user->save();
        }
        $rand = Str::random(4);    

        $invoice_no = $rand.'_'.date('Y-m-d');

        $gst = $input['totalAmount']*18/100;

        $total_amount =$input['totalAmount'];

        $pdf = PDF::loadView('invoices.candidate-pdf-invoice',[

            'name' => $user->first_name,
            'email' => $user->email,
            'mobile' => $user->phone,
            'invoice_no' => $invoice_no,
            'amount' => $input['totalAmount'],
            'gst'  => $gst,
            'total_amount' => $total_amount,       
            'start_date' => $user->package_start_date,
            'end_date'  => $user->package_end_date,
            'payment_id' => $input['razorpay_payment_id']


        ]);


        $invoiceName = 'Invoice'.'-'.time().'_'.date('Y-m-d').'.pdf';

        $pdf->save(public_path('invoices/'. $invoiceName));


        $data = [

            'title' =>   $request->input('email'),

            'subject'  => 'Payment Success',

            'name' => $user->name,

            'gst' => 299*18/100,
            
             'total_amount' => number_format($total_amount, 2), 
             
             'start_date' => $user->package_start_date,
            'end_date'  => $user->package_end_date,
            'payment_id' => $input['razorpay_payment_id']


        ];

        $email = $user->email;

        Mail::send('emails.candidate_payment', $data, function($message) use ($data,$email,$invoiceName) {

            $message->to($email)->from('info@zeronoticeperiod.com')

            ->subject($data['subject']);

          });

         
          
        $final->status = $payment['status'];

            return response()->json([
                'success' => true,
                'message' => 'Payment successful',
            ], 200);
       
    } else {

        $user = User::where('id',Auth::user()->id)->first();
        $user->payment_status = 0;
        $user->save();

        return response()->json([
            'success' => false,
            'message' => 'Payment Failed!',
        ], 401);
    }
}


public function paymentpage(Request $request)
{

    $user = User::where('id',Auth::user()->id)->first();
    // if($user->payment_status == 1)
    // {
    //     return redirect()->back()->with('message12','Already Purchased');
    // }else{

    // $user->payment_status = 0;
    // $user->save();


    return view('user.inc.payment');

    // }
    
}
    public function layoffpaymentpage(Request $request)
    {

        $user = User::where('id',Auth::user()->id)->first();

        return view('user.inc.layoffpayment');

    }

public function employerpaymentpage(Request $request)
{

// return dd($request->plan_id);

     
    if(Auth::guard('company')->check())
    {
        // if($request->plan_id == 'Trail')
        // {
        //     return redirect()->to(url()->previous() . '#success-section')->with('message12', 'You are already in Trail Plan');

        // }
    }else{
        return redirect()->to(url()->previous() . '#success-section')->with('message12', 'Please Login as a Employer');
    }
    
   $company_id = Auth::guard('company')->user()->id;
    $package = Package::where('id', $request->plan_id)->first() ;
     $employer = Company::where('id',$company_id)->first();
   //  dd($package->package_price);   

   

    $employer->payment_status = 0;
    $employer->payment_activity = 0;
    $employer->save();

    $amount = $package->package_price;
    $gst = $amount*18/100;

    $total_amount = $gst+$amount;

    Session::put('plan', $request->plan_id );

    Session::put('amount', $total_amount );



    return view('company.inc.payment',compact('package','total_amount'));

    
    
}

public function employerPaySuccess(Request $request)
{
  //  dd($request->all());
    $company = Auth::guard('company')->user();
    $employer = Company::where('id',Auth::guard('company')->user()->id)->first();

  $input = $request->all();

    $api = new Api('rzp_test_jwhINIWE9ZqYHY','csZeV7lBneXenANsjQuxnzzi');
   //  $api = new Api("rzp_live_10zpY9T178kCcp", "t27Cm688uhbLEFZkjGvvHWTX");

    $payment = $api->payment->fetch($input['razorpay_payment_id']);

    $plan_package = Package::where('id',$request->plan_id)->first();
    $plan = $plan_package->package_title;
    $planid = $request->plan_id;

   // dd($payment);

 

    if (($payment['status'] == "captured") || ($payment['status'] == "authorized")) {
        
        //dd($employer);

        if($employer->package_id > 0)
        {
          
            $package_id = $request->plan_id;
    
            $package = Package::find($package_id);
           
            $this->updateCompanyPackage($company, $package);

        }else{
            // dd('package id is not there');

            if ($request->plan_id && $request->plan_id > 0) {

                $package_id = $request->plan_id;
    
                $package = Package::find($package_id);
    
                 $this->addCompanyPackage($company, $package);
    
                // $this->addCompanySearchPackage($company, $package);
    
            }

        }

        $package_id = $request->plan_id;

        $package = Package::find($package_id);
       
        $rand = Str::random(4);    

        $invoice_no = $rand.'_'.date('Y-m-d');

        $gst = $package->package_price*18/100;

        $total_amount = $gst+$package->package_price;

        $pdf = PDF::loadView('invoices.employer-pdf-invoice',[

            'name' => $employer->name,
            'email' => $employer->email,
            'mobile' => $employer->phone,
            'invoice_no' => $invoice_no,
            'amount' => number_format($package->package_price, 2),
            'gst'  => number_format($gst, 2),
            'total_amount' => number_format($total_amount, 2),
            'plan' => $plan,
            'start_date' => $employer->package_start_date,
            'end_date'  => $employer->package_end_date,
            'payment_id'  => $input['razorpay_payment_id']


        ]);

       $invoiceName = 'Invoice'.'-'.time().'_'.date('Y-m-d').'.pdf';

       $pdf->save(public_path('invoices/'. $invoiceName));

       $gst = $input['totalAmount']*18/100;

  
        $final = EmployerPayment::create([
            'payment_id' => $input['razorpay_payment_id'],
            'company_id' => $employer->id,
            'payment_status' => 1,
            'payment_activity' => 1,
            'plan_id'=>$planid,
            'amount' => $total_amount,
            'invoice' => $invoiceName,
            'invoice_status' => 0,
            'invoice_no' => $invoice_no

        ]);

        $employer_payment_history = EmployerPaymenthistory::create([

            'payment_id' =>  $input['razorpay_payment_id'],
            'amount' =>  $total_amount,
            'employer_id'=> $employer->id,
            'plan'=> $planid,
            'package_start_date'=>$employer->package_start_date,
            'package_end_date'=>$employer->package_end_date,
            'payment_status' => 1
    


        ]);

        $current = Carbon::now();      
        
        $employer->payment_status = 1;
        $employer->payment_activity = 1;
        $employer->save();


     
          





        $data = [

            'title' =>   $request->input('email'),

            'subject'  => 'Payment Success',

            'plan'  => $plan,
            'gst' => $gst,
            'original_amount' => number_format($package->package_price, 2),
            'amount' => number_format($input['totalAmount'], 2),
            
            'start_date'=>$employer->package_start_date,
            'end_date'=>$employer->package_end_date,
            'payment_id' =>  $input['razorpay_payment_id'],



        ];

        $email = $company->email;

        $emails = ['jayabharathi.nexevo@gmail.com',$email ];
        Mail::send('emails.employer_payment', $data, function($message) use ($data,$email) {

            $message->to($email)->from('employer@zeronoticeperiod.com')

            ->subject($data['subject']);

          });




        //$final->status = $payment['status'];

            return response()->json([
                'success' => true,
                'message' => 'Payment successful',
            ], 200);

   
    


    } else {

        $user = Company::where('id',Auth::guard('company')->user()->id)->first();
        $user->payment_status = 0;
        $user->save();

        return response()->json([
            'success' => false,
            'message' => 'Payment Failed!',
        ], 401);
    }
}

public function employerpaymentfailure()
{
    $user = Company::where('id',Auth::user()->id)->first();
    $user->payment_activity = 2;
    $user->save();
    return view('payment-failure');
}

}
