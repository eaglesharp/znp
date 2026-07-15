<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CandidatePayment;
use App\Company;
use App\EmployerPayment;
use App\EmployerPaymenthistory;
use App\Package;
use App\ZnpPricingPlan;
use App\ZnpCompanySubscription;
use App\Services\ZnpSubscriptionService;
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

use Stripe\Charge;
use Stripe\Customer;
use Stripe\Stripe;
use App\Collection;

use App\Unlocked_users;
use Razorpay\Api\Errors\SignatureVerificationError;

use Illuminate\Support\Facades\Hash;





class CheckoutController extends Controller
{

    use CompanyTrait;

    use CompanyPackageTrait;

    const BASE_URL = 'https://api.stripe.com';

    private static function stripeSecret()
    {
        return config('stripe.stripe_secret') ?: config('services.stripe.secret');
    }

    private static function stripeKey()
    {
        return config('stripe.stripe_key') ?: config('services.stripe.key');
    }

    public function paymentpage(Request $request)
    {

        $user = User::where('id', Auth::user()->id)->first();

        return view('user.inc.stripe-payment');

    }

    public function layoffpaymentpage(Request $request)
    {


        $user = User::where('id', Auth::user()->id)->first();

        return view('user.inc.layoffpayment');

    }

    public function stripePaySuccess(Request $request)
    {

        $input = $request->all();

        // dd($request->total_amount);

        // Stripe::setApiKey(self::stripeSecret());

        // $customer = Customer::create(array(
        //     'email' => $request->stripeEmail,
        //     'source' => $request->stripeToken,
        //     'address' => [
        //          'line1' => 'Nexevo Technologies',
        //             'postal_code' => '560043',
        //             'city' => 'Bangalore',
        //             'state' => 'Karnataka',
        //             'country' => 'INR',
        //     ],

        // ));

        // $charge = Charge::create(array(
        //     'description' => '',
        //     'shipping' => [
        //         'name' => 'ZeroNoticePeriod LLC',
        //         'address' => [
        //             'line1' => 'Nexevo Technologies',
        //             'postal_code' => '560043',
        //             'city' => 'Bangalore',
        //             'state' => 'Karnataka',
        //             'country' => 'INR',
        //         ],
        //     ],
        //     'customer' => $customer->id,
        //     'amount' => $request->total_amount * 100,
        //     'currency' => 'usd',
        // ));  



        $stripe = new \Stripe\StripeClient(self::stripeSecret());

        Stripe::setApiKey(self::stripeSecret());

        $customer = Customer::create(
            array(
                'email' => $request->stripeEmail,
                'source' => $request->stripeToken,
                'address' => [
                    'line1' => 'Nexevo Technologies',
                    'postal_code' => '560043',
                    'city' => 'Bangalore',
                    'state' => 'Karnataka',
                    'country' => 'INR',
                ],

            )
        );

        $charge = $stripe->paymentIntents->create(
            [
                'amount' => $request->total_amount * 100,
                'currency' => 'inr',
                'payment_method_types' => ['card'],
                'customer' => $customer->id,


            ]
        );



        //dd($charge);

        if ($charge->id) {

            $final = CandidatePayment::create([
                'payment_id' => $charge->id,
                'user_id' => Auth::user()->id,
                'payment_status' => 1,
                'amount' => $request->total_amount,
                'type' => 1

            ]);

            $current = Carbon::now();

            $user = User::where('id', Auth::user()->id)->first();




            if ($user->package_id > 0) {

                $update_date = $user->package_end_date;
                $user->payment_status = 1;
                $user->package_start_date = $user->package_start_date;
                if ($update_date < $current) {
                    $package = $current;
                    $user->package_end_date = $package->addDays(30);
                } else {
                    $user->package_end_date = $update_date->addDays(30);
                }

                $user->package_id = 5;
                $user->save();

            } else {

                $user->payment_status = 1;
                $user->package_start_date = Carbon::now();
                $user->package_end_date = $current->addDays(30);
                $user->package_id = 5;
                $user->save();
            }
            $rand = Str::random(4);

            $invoice_no = $rand . '_' . date('Y-m-d');

            $gst = $request->total_amount * 18 / 100;

            $total_amount = $request->total_amount;

            $pdf = PDF::loadView('invoices.candidate-pdf-invoice', [

                'name' => $user->first_name,
                'email' => $user->email,
                'mobile' => $user->phone,
                'invoice_no' => $invoice_no,
                'amount' => $request->total_amount,
                'gst' => $gst,
                'total_amount' => $total_amount,
                'start_date' => $user->package_start_date,
                'end_date' => $user->package_end_date,
                'payment_id' => $charge->id


            ]);


            $invoiceName = 'Invoice' . '-' . time() . '_' . date('Y-m-d') . '.pdf';

            $pdf->save(public_path('invoices/' . $invoiceName));


            $data = [

                'title' => $request->input('email'),

                'subject' => 'Payment Success',

                'name' => $user->name,

                'gst' => 499 * 18 / 100,

                'total_amount' => number_format($total_amount, 2),

                'start_date' => $user->package_start_date,
                'end_date' => $user->package_end_date,
                'payment_id' => $charge->id


            ];

            $email = $user->email;

            Mail::send('emails.candidate_payment', $data, function ($message) use ($data, $email, $invoiceName) {

                $message->to($email)->from('info@zeronoticeperiod.com')

                    ->subject($data['subject']);

            });





            ///  dd('success');

            return redirect('/razor-thank-you');

        } {

            $Message = 'razorpay_signature failed For more information, please contact DelightLearning';
            return view('payment-failure', compact('Message'));
        }

    }




    public function stripePaylayoffPaySuccess(Request $request)
    {

        $input = $request->all();

        //  dd($request->total_amount);

        Stripe::setApiKey(self::stripeSecret());

        $customer = Customer::create(
            array(
                'email' => $request->stripeEmail,
                'source' => $request->stripeToken,
                'address' => [
                    'line1' => '9113 Ivalenes Hope Drive,',
                    'postal_code' => '78717',
                    'city' => 'Austin',
                    'state' => 'TX',
                    'country' => 'US',
                ],

            )
        );

        $charge = Charge::create(
            array(
                'description' => '',
                'shipping' => [
                    'name' => 'ZeroNoticePeriod LLC',
                    'address' => [
                        'line1' => '9113 Ivalenes Hope Drive,',
                        'postal_code' => '78717',
                        'city' => 'Austin',
                        'state' => 'TX',
                        'country' => 'US',
                    ],
                ],
                'customer' => $customer->id,
                'amount' => $request->total_amount * 100,
                'currency' => 'usd',
            )
        );

        //dd($charge);

        if ($charge->id) {

            $final = CandidatePayment::create([
                'payment_id' => $charge->id,
                'user_id' => Auth::user()->id,
                'payment_status' => 1,
                'amount' => $request->total_amount,
                'type' => 2

            ]);

            $current = Carbon::now();

            $user = User::where('id', Auth::user()->id)->first();




            if ($user->layoff_package_id > 0) {

                $update_date = $user->layoff_package_end_date;
                $user->layoff_payment_status = 1;
                $user->layoff_package_start_date = $user->layoff_package_start_date;
                if ($update_date < $current) {
                    $package = $current;
                    $user->layoff_package_end_date = $package->addDays(90);
                } else {
                    $user->layoff_package_end_date = $update_date->addDays(90);
                }

                $user->layoff_package_package_id = 6;
                $user->save();

            } else {

                $user->layoff_payment_status = 1;
                $user->layoff_package_start_date = Carbon::now();
                $user->layoff_package_end_date = $current->addDays(90);
                $user->layoff_package_id = 6;
                $user->save();
            }



            $rand = Str::random(4);

            $invoice_no = $rand . '_' . date('Y-m-d');

            $gst = $request->total_amount * 18 / 100;

            $total_amount = $request->total_amount;

            $pdf = PDF::loadView('invoices.candidate-layoffpdf-invoice', [

                'name' => $user->first_name,
                'email' => $user->email,
                'mobile' => $user->phone,
                'invoice_no' => $invoice_no,
                'amount' => $request->total_amount,
                'gst' => $gst,
                'total_amount' => $total_amount,
                'start_date' => $user->layoff_package_start_date,
                'end_date' => $user->layoff_package_end_date,
                'payment_id' => $charge->id


            ]);


            $invoiceName = 'Invoice' . '-' . time() . '_' . date('Y-m-d') . '.pdf';

            $pdf->save(public_path('invoices/' . $invoiceName));


            $data = [

                'title' => $request->input('email'),

                'subject' => 'Payment Success',

                'name' => $user->name,

                'gst' => 499 * 18 / 100,

                'total_amount' => number_format($total_amount, 2),

                'start_date' => $user->layoff_package_start_date,
                'end_date' => $user->layoff_package_end_date,
                'payment_id' => $charge->id


            ];

            $email = $user->email;

            Mail::send('emails.candidate_layoffpayment', $data, function ($message) use ($data, $email, $invoiceName) {

                $message->to($email)->from('info@zeronoticeperiod.com')

                    ->subject($data['subject']);

            });



            return response()->json([
                'success' => true,
                'message' => 'Payment successful',
            ], 200);

        } else {

            $user = User::where('id', Auth::user()->id)->first();
            $user->payment_status = 0;
            $user->save();

            return response()->json([
                'success' => false,
                'message' => 'Payment Failed!',
            ], 401);
        }
    }

    public function employerpaymentpage(Request $request)
    {

        if (! Auth::guard('company')->check()) {
            return redirect()->to(url()->previous() . '#success-section')->with('message12', 'Please Login as a Employer');
        }

        $company_id = Auth::guard('company')->user()->id;
        $employer = Company::where('id', $company_id)->first();

        $employer->payment_status = 0;
        $employer->payment_activity = 0;
        $employer->save();

        /* ── New ZNP job-posting plans (employer-job-pricing page) ── */
        if ($request->filled('znp_plan')) {
            $znpPlan = ZnpPricingPlan::active()->where('slug', $request->znp_plan)->firstOrFail();

            if (! $znpPlan->isPurchasableOnline()) {
                return redirect($znpPlan->checkoutUrl());
            }

            $total_amount = $znpPlan->totalWithGst();

            Session::put('znp_checkout_plan_id', $znpPlan->id);
            Session::put('plan', 'znp-' . $znpPlan->id);
            Session::put('amount', $total_amount);

            $package = (object) [
                'id'            => 'znp-' . $znpPlan->id,
                'package_title' => $znpPlan->name,
            ];

            return view('company.inc.payment', compact('package', 'total_amount', 'employer', 'znpPlan'));
        }

        /* ── Legacy packages table plans ── */
        $package = Package::where('id', $request->plan_id)->firstOrFail();

        $amount = $package->package_price;
        $gst = $amount * 18 / 100;
        $total_amount = $gst + $amount;

        Session::put('plan', $request->plan_id);
        Session::put('amount', $total_amount);
        Session::forget('znp_checkout_plan_id');

        return view('company.inc.payment', compact('package', 'total_amount', 'employer'));

    }

    public function employerPaySuccess(Request $request)
    {
        //  dd($request->all());
        $company = Auth::guard('company')->user();
        $employer = Company::where('id', Auth::guard('company')->user()->id)->first();

        $input = $request->all();



        $plan_package = Package::where('id', $request->plan_id)->first();
        $plan = $plan_package->package_title;
        $planid = $request->plan_id;

        // dd($payment);



        Stripe::setApiKey(self::stripeSecret());

        $customer = Customer::create(
            array(
                'email' => $request->stripeEmail,
                'source' => $request->stripeToken,
                'address' => [
                    'line1' => '9113 Ivalenes Hope Drive,',
                    'postal_code' => '78717',
                    'city' => 'Austin',
                    'state' => 'TX',
                    'country' => 'US',
                ],

            )
        );

        $charge = Charge::create(
            array(
                'description' => '',
                'shipping' => [
                    'name' => 'ZeroNoticePeriod LLC',
                    'address' => [
                        'line1' => '9113 Ivalenes Hope Drive,',
                        'postal_code' => '78717',
                        'city' => 'Austin',
                        'state' => 'TX',
                        'country' => 'US',
                    ],
                ],
                'customer' => $customer->id,
                'amount' => $request->total_amount * 100,
                'currency' => 'usd',
            )
        );

        //dd($charge);

        if ($charge->id) {

            //dd($employer);

            if ($employer->package_id > 0) {

                $package_id = $request->plan_id;

                $package = Package::find($package_id);

                $this->updateCompanyPackage($company, $package);

            } else {
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

            $invoice_no = $rand . '_' . date('Y-m-d');

            $gst = $package->package_price * 18 / 100;

            $total_amount = $gst + $package->package_price;

            $pdf = PDF::loadView('invoices.employer-pdf-invoice', [

                'name' => $employer->name,
                'email' => $employer->email,
                'mobile' => $employer->phone,
                'gstin' => $employer->gstin,
                'location' => $employer->location,
                'invoice_no' => $invoice_no,
                'amount' => number_format($package->package_price, 2),
                'gst' => number_format($gst, 2),
                'total_amount' => number_format($total_amount, 2),
                'plan' => $plan,
                'start_date' => $employer->package_start_date,
                'end_date' => $employer->package_end_date,
                'payment_id' => $charge->id
            ]);

            $invoiceName = 'Invoice' . '-' . time() . '_' . date('Y-m-d') . '.pdf';

            $pdf->save(public_path('invoices/' . $invoiceName));

            $gst = $package->package_price * 18 / 100;


            $final = EmployerPayment::create([
                'payment_id' => $charge->id,
                'company_id' => $employer->id,
                'payment_status' => 1,
                'payment_activity' => 1,
                'plan_id' => $planid,
                'amount' => $total_amount,
                'invoice' => $invoiceName,
                'invoice_status' => 0,
                'invoice_no' => $invoice_no

            ]);

            $employer_payment_history = EmployerPaymenthistory::create([

                'payment_id' => $charge->id,
                'amount' => $total_amount,
                'employer_id' => $employer->id,
                'plan' => $planid,
                'package_start_date' => $employer->package_start_date,
                'package_end_date' => $employer->package_end_date,
                'payment_status' => 1



            ]);

            $current = Carbon::now();

            $employer->payment_status = 1;
            $employer->payment_activity = 1;
            $employer->save();

            // dd($employer);


            $data = [

                'title' => $request->input('email'),

                'subject' => 'Payment Success',

                'plan' => $plan,
                'gst' => $gst,
                'original_amount' => number_format($package->package_price, 2),
                'amount' => number_format($request->total_amount, 2),

                'start_date' => $employer->package_start_date,
                'end_date' => $employer->package_end_date,
                'payment_id' => $charge->id,



            ];

            $email = $company->email;

            $emails = ['info@zeronoticeperiod.com', $email];
            Mail::send('emails.employer_payment', $data, function ($message) use ($data, $email) {

                $message->to($email)->from('employer@zeronoticeperiod.com')

                    ->subject($data['subject']);

            });

            return redirect('/razor-thank-you');


            //$final->status = $payment['status'];

            return response()->json([
                'success' => true,
                'message' => 'Payment successful',
            ], 200);





        } else {

            $user = Company::where('id', Auth::guard('company')->user()->id)->first();
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
        $user = Company::where('id', Auth::user()->id)->first();
        $user->payment_activity = 2;
        $user->save();
        return view('payment-failure');
    }



    public function xpressubmit(Request $request)
    {


        $input = $request->validate([
            'card_no' => 'required',
            'exp_month' => 'required',
            'exp_year' => 'required',
            'cvc' => 'required',

        ]);

        $input['transaction_id'] = Str::random(15);
        ; // random string for transaction id

        $payment_url = self::BASE_URL . '/v1/payment_methods';

        $payment_data = [
            'type' => 'card',
            'card[number]' => $input['card_no'],
            'card[exp_month]' => $input['exp_month'],
            'card[exp_year]' => $input['exp_year'],
            'card[cvc]' => $input['cvc'],
            'billing_details[address][country]' => "IN",
            'billing_details[email]' => auth()->user()->email,
            'billing_details[name]' => auth()->user()->first_name . ' ' . auth()->user()->last_name,
            'billing_details[phone]' => auth()->user()->phone,
        ];

        $payment_payload = http_build_query($payment_data);

        $payment_headers = [
            'Content-Type: application/x-www-form-urlencoded',
            'Authorization: Bearer ' . self::stripeSecret()
        ];

        // sending curl request
        // see last function for code
        $payment_body = $this->curlPost($payment_url, $payment_payload, $payment_headers);

        $payment_response = json_decode($payment_body, true);


        $orginal_amount = 499;

        $total_amount = ($orginal_amount + ($orginal_amount * 18) / 100);

        //  dd($total_amount);

        // dd($payment_response);

        if (isset($payment_response['id']) && $payment_response['id'] != null) {

            $request_url = self::BASE_URL . '/v1/payment_intents';

            $request_data = [
                'amount' => $total_amount * 100, // multiply amount with 100
                'currency' => "INR",
                'payment_method_types[]' => 'card',
                'payment_method' => $payment_response['id'],
                'confirm' => 'true',
                'capture_method' => 'automatic',
                'return_url' => route('stripeResponse'),
                'payment_method_options[card][request_three_d_secure]' => 'automatic',
            ];

            $request_payload = http_build_query($request_data);

            $request_headers = [
                'Content-Type: application/x-www-form-urlencoded',
                'Authorization: Bearer ' . self::stripeSecret()
            ];

            // another curl request
            $response_body = $this->curlPost($request_url, $request_payload, $request_headers);

            $response_data = json_decode($response_body, true);

            //  dd($response_data);

            // transaction required 3d secure redirect
            if (isset($response_data['next_action']['redirect_to_url']['url']) && $response_data['next_action']['redirect_to_url']['url'] != null) {

                return redirect()->away($response_data['next_action']['redirect_to_url']['url']);

                // transaction success without 3d secure redirect
            } elseif (isset($response_data['status']) && $response_data['status'] == 'succeeded') {

                return redirect()->route('stripeResponse')->with('success', 'Payment success.');

                // transaction declined because of error
            } elseif (isset($response_data['error']['message']) && $response_data['error']['message'] != null) {

                return redirect()->route('stripeResponse')->with('error', $response_data['error']['message']);

            } else {

                return redirect()->route('stripeResponse')->with('error', 'Something went wrong, please try again.');
            }

            // error in creating payment method
        } elseif (isset($payment_response['error']['message']) && $payment_response['error']['message'] != null) {

            return redirect()->route('stripeResponse')->with('error', $payment_response['error']['message']);

        }
    }


    private function curlPost($url, $data, $headers)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);

        curl_close($ch);

        return $response;
    }



    public function xpressresponse(Request $request)
    {
        $request_data = $request->all();

        //   dd($request_data);

        // if only stripe response contains payment_intent
        if (isset($request_data['payment_intent']) && $request_data['payment_intent'] != null) {

            // here we will check status of the transaction with payment_intents from stripe server
            $get_url = self::BASE_URL . '/v1/payment_intents/' . $request_data['payment_intent'];

            $get_headers = [
                'Authorization: Bearer ' . self::stripeSecret()
            ];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $get_url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $get_headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $get_response = curl_exec($ch);

            curl_close($ch);

            $get_data = json_decode($get_response, 1);

            //  dd($get_data);

            // get record of transaction from database
            // so we can verify with response and update the transaction status
            // $input = \DB::table('transactions')
            //     ->where('transaction_id', $transaction_id)
            //     ->first();

            // here you can check amount, currency etc with $get_data
            // which you can check with your database record
            // for example amount value check

            $orginal_amount = 499;

            $total_amount = ($orginal_amount + ($orginal_amount * 18) / 100);


            // succeeded means transaction success
            if (isset($get_data['status']) && $get_data['status'] == 'succeeded') {

                // dd('success');

                $final = CandidatePayment::create([
                    'payment_id' => $get_data['id'],
                    'user_id' => Auth::user()->id,
                    'payment_status' => 1,
                    'amount' => $total_amount,
                    'type' => 1

                ]);

                $current = Carbon::now();

                $user = User::where('id', Auth::user()->id)->first();




                if ($user->package_id > 0) {

                    $update_date = $user->package_end_date;
                    $user->payment_status = 1;
                    $user->package_start_date = $user->package_start_date;
                    if ($update_date < $current) {
                        $package = $current;
                        $user->package_end_date = $package->addDays(30);
                    } else {
                        $user->package_end_date = $update_date->addDays(30);
                    }

                    $user->package_id = 5;
                    $user->save();

                } else {

                    $user->payment_status = 1;
                    $user->package_start_date = Carbon::now();
                    $user->package_end_date = $current->addDays(30);
                    $user->package_id = 5;
                    $user->save();
                }
                $rand = Str::random(4);

                $invoice_no = $rand . '_' . date('Y-m-d');

                $gst = $orginal_amount * 18 / 100;

                //  $total_amount =$request->total_amount;

                $pdf = PDF::loadView('invoices.candidate-pdf-invoice', [

                    'name' => $user->first_name,
                    'email' => $user->email,
                    'mobile' => $user->phone,
                    'invoice_no' => $invoice_no,
                    'amount' => $orginal_amount,
                    'gst' => $gst,
                    'total_amount' => $total_amount,
                    'start_date' => $user->package_start_date,
                    'end_date' => $user->package_end_date,
                    'payment_id' => $get_data['id']


                ]);


                $invoiceName = 'Invoice' . '-' . time() . '_' . date('Y-m-d') . '.pdf';

                $pdf->save(public_path('invoices/' . $invoiceName));


                $data = [

                    'title' => $user->first_name,

                    'subject' => 'Payment Success',

                    'name' => $user->name,

                    'gst' => 499 * 18 / 100,

                    'total_amount' => number_format($total_amount, 2),

                    'start_date' => $user->package_start_date,
                    'end_date' => $user->package_end_date,
                    'payment_id' => $get_data['id']


                ];

                $email = $user->email;

                Mail::send('emails.candidate_payment', $data, function ($message) use ($data, $email, $invoiceName) {

                    $message->to($email)->from('info@zeronoticeperiod.com')

                        ->subject($data['subject']);

                });





                ///  dd('success');

                return redirect('/thank-you');

                //   return view('response')->with('success', 'Payment success.');

                // update here transaction for record something like this
                // $input = \DB::table('transactions')
                //     ->where('transaction_id', $transaction_id)
                //     ->update(['status' => 'success']);

            } elseif (isset($get_data['error']['message']) && $get_data['error']['message'] != null) {

                // dd('error');

                return view('payment-failure')->with('error', $get_data['error']['message']);

            } else {

                return view('payment-failure')->with('error', 'Payment request failed.');
            }
        } else {

            return redirect()->back()->with('error', 'Invalid Card Details');


            return view('payment-failure')->with('error', 'Payment request failed.');

        }
    }

    public function StripeThankYou(Request $request)
    {
        return view('stripe-thankyou');
    }

    //Stripe Layoff payment section

    public function stripelayoffpaymentpage(Request $request)
    {


        $user = User::where('id', Auth::user()->id)->first();

        return view('user.inc.stripelayoffpayment');

    }


    public function layoffsubmit(Request $request)
    {


        $input = $request->validate([
            'card_no' => 'required',
            'exp_month' => 'required',
            'exp_year' => 'required',
            'cvc' => 'required',

        ]);

        $input['transaction_id'] = Str::random(15);
        ; // random string for transaction id

        $payment_url = self::BASE_URL . '/v1/payment_methods';

        $payment_data = [
            'type' => 'card',
            'card[number]' => $input['card_no'],
            'card[exp_month]' => $input['exp_month'],
            'card[exp_year]' => $input['exp_year'],
            'card[cvc]' => $input['cvc'],
            'billing_details[address][country]' => "IN",
            'billing_details[email]' => auth()->user()->email,
            'billing_details[name]' => auth()->user()->first_name . ' ' . auth()->user()->last_name,
            'billing_details[phone]' => auth()->user()->phone,
        ];

        $payment_payload = http_build_query($payment_data);

        $payment_headers = [
            'Content-Type: application/x-www-form-urlencoded',
            'Authorization: Bearer ' . self::stripeSecret()
        ];


        // sending curl request
        // see last function for code
        $payment_body = $this->curlPost($payment_url, $payment_payload, $payment_headers);

        $payment_response = json_decode($payment_body, true);


        $orginal_amount = 499;

        $total_amount = ($orginal_amount + ($orginal_amount * 18) / 100);

        //  dd($total_amount);

        // dd($payment_response);

        if (isset($payment_response['id']) && $payment_response['id'] != null) {

            $request_url = self::BASE_URL . '/v1/payment_intents';

            $request_data = [
                'amount' => $total_amount * 100, // multiply amount with 100
                'currency' => "INR",
                'payment_method_types[]' => 'card',
                'payment_method' => $payment_response['id'],
                'confirm' => 'true',
                'capture_method' => 'automatic',
                'return_url' => route('layoffstripeResponse'),
                'payment_method_options[card][request_three_d_secure]' => 'automatic',
            ];

            $request_payload = http_build_query($request_data);

            $request_headers = [
                'Content-Type: application/x-www-form-urlencoded',
                'Authorization: Bearer ' . self::stripeSecret()
            ];

            // another curl request
            $response_body = $this->curlPost($request_url, $request_payload, $request_headers);

            $response_data = json_decode($response_body, true);

            //  dd($response_data);

            // transaction required 3d secure redirect
            if (isset($response_data['next_action']['redirect_to_url']['url']) && $response_data['next_action']['redirect_to_url']['url'] != null) {

                return redirect()->away($response_data['next_action']['redirect_to_url']['url']);

                // transaction success without 3d secure redirect
            } elseif (isset($response_data['status']) && $response_data['status'] == 'succeeded') {

                return redirect()->route('layoffstripeResponse')->with('success', 'Payment success.');

                // transaction declined because of error
            } elseif (isset($response_data['error']['message']) && $response_data['error']['message'] != null) {

                return redirect()->route('layoffstripeResponse')->with('error', $response_data['error']['message']);

            } else {

                return redirect()->route('layoffstripeResponse')->with('error', 'Something went wrong, please try again.');
            }

            // error in creating payment method
        } elseif (isset($payment_response['error']['message']) && $payment_response['error']['message'] != null) {

            return redirect()->route('layoffstripeResponse')->with('error', $payment_response['error']['message']);

        }
    }


    public function layoffresponse(Request $request)
    {
        $request_data = $request->all();

        //   dd($request_data);

        // if only stripe response contains payment_intent
        if (isset($request_data['payment_intent']) && $request_data['payment_intent'] != null) {

            // here we will check status of the transaction with payment_intents from stripe server
            $get_url = self::BASE_URL . '/v1/payment_intents/' . $request_data['payment_intent'];

            $get_headers = [
                'Authorization: Bearer ' . self::stripeSecret()
            ];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $get_url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $get_headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $get_response = curl_exec($ch);

            curl_close($ch);

            $get_data = json_decode($get_response, 1);

            //  dd($get_data);

            // get record of transaction from database
            // so we can verify with response and update the transaction status
            // $input = \DB::table('transactions')
            //     ->where('transaction_id', $transaction_id)
            //     ->first();

            // here you can check amount, currency etc with $get_data
            // which you can check with your database record
            // for example amount value check

            $orginal_amount = 499;

            $total_amount = ($orginal_amount + ($orginal_amount * 18) / 100);


            // succeeded means transaction success
            if (isset($get_data['status']) && $get_data['status'] == 'succeeded') {

                // dd('success');

                $final = CandidatePayment::create([
                    'payment_id' => $get_data['id'],
                    'user_id' => Auth::user()->id,
                    'payment_status' => 1,
                    'amount' => $total_amount,
                    'type' => 2

                ]);

                $current = Carbon::now();

                $user = User::where('id', Auth::user()->id)->first();




                if ($user->layoff_package_id > 0) {

                    $update_date = $user->layoff_package_end_date;
                    $user->layoff_payment_status = 1;
                    $user->layoff_package_start_date = $user->layoff_package_start_date;
                    if ($update_date < $current) {
                        $package = $current;
                        $user->layoff_package_end_date = $package->addDays(90);
                    } else {
                        $user->layoff_package_end_date = $update_date->addDays(90);
                    }

                    $user->layoff_package_package_id = 6;
                    $user->save();

                } else {

                    $user->layoff_payment_status = 1;
                    $user->layoff_package_start_date = Carbon::now();
                    $user->layoff_package_end_date = $current->addDays(90);
                    $user->layoff_package_id = 6;
                    $user->save();
                }

                $rand = Str::random(4);

                $invoice_no = $rand . '_' . date('Y-m-d');

                $gst = $request->total_amount * 18 / 100;

                // $total_amount =$request->total_amount;

                $pdf = PDF::loadView('invoices.candidate-layoffpdf-invoice', [

                    'name' => $user->first_name,
                    'email' => $user->email,
                    'mobile' => $user->phone,
                    'invoice_no' => $invoice_no,
                    'amount' => $request->total_amount,
                    'gst' => $gst,
                    'total_amount' => $total_amount,
                    'start_date' => $user->layoff_package_start_date,
                    'end_date' => $user->layoff_package_end_date,
                    'payment_id' => $get_data['id']


                ]);


                $invoiceName = 'Invoice' . '-' . time() . '_' . date('Y-m-d') . '.pdf';

                $pdf->save(public_path('invoices/' . $invoiceName));


                $data = [

                    'title' => $request->input('email'),

                    'subject' => 'Payment Success',

                    'name' => $user->name,

                    'gst' => 499 * 18 / 100,

                    'total_amount' => number_format($total_amount, 2),

                    'start_date' => $user->layoff_package_start_date,
                    'end_date' => $user->layoff_package_end_date,
                    'payment_id' => $get_data['id']


                ];

                $email = $user->email;

                Mail::send('emails.candidate_layoffpayment', $data, function ($message) use ($data, $email, $invoiceName) {

                    $message->to($email)->from('info@zeronoticeperiod.com')

                        ->subject($data['subject']);

                });






                ///  dd('success');

                return redirect('/thank-you');

                //   return view('response')->with('success', 'Payment success.');

                // update here transaction for record something like this
                // $input = \DB::table('transactions')
                //     ->where('transaction_id', $transaction_id)
                //     ->update(['status' => 'success']);

            } elseif (isset($get_data['error']['message']) && $get_data['error']['message'] != null) {

                // dd('error');

                $user = User::where('id', Auth::user()->id)->first();
                $user->payment_status = 0;
                $user->save();


                return view('payment-failure')->with('error', $get_data['error']['message']);

            } else {

                $user = User::where('id', Auth::user()->id)->first();
                $user->payment_status = 0;
                $user->save();

                return view('payment-failure')->with('error', 'Payment request failed.');
            }
        } else {

            return redirect()->back()->with('error', 'Invalid Card Details');


            return view('payment-failure')->with('error', 'Payment request failed.');

        }
    }


    public function employersubmit(Request $request)
    {

        //   dd($request->all());


        $input = $request->validate([
            'card_no' => 'required',
            'exp_month' => 'required',
            'exp_year' => 'required',
            'cvc' => 'required',
        ]);

        if (! $request->filled('znp_plan_id') && ! $request->filled('package_id')) {
            return redirect()->back()->with('error', 'Invalid plan selected.');
        }

        $input['transaction_id'] = Str::random(15);
        ; // random string for transaction id

        $payment_url = self::BASE_URL . '/v1/payment_methods';

        $payment_data = [
            'type' => 'card',
            'card[number]' => $input['card_no'],
            'card[exp_month]' => $input['exp_month'],
            'card[exp_year]' => $input['exp_year'],
            'card[cvc]' => $input['cvc'],
            'billing_details[address][country]' => "IN",
            'billing_details[email]' => auth()->guard('company')->user()->email,
            'billing_details[name]' => auth()->guard('company')->user()->name,
            'billing_details[phone]' => auth()->guard('company')->user()->phone,
        ];

        $payment_payload = http_build_query($payment_data);

        $payment_headers = [
            'Content-Type: application/x-www-form-urlencoded',
            'Authorization: Bearer ' . self::stripeSecret()
        ];

        // sending curl request
        // see last function for code
        $payment_body = $this->curlPost($payment_url, $payment_payload, $payment_headers);

        $payment_response = json_decode($payment_body, true);

        $isZnpPlan = $request->filled('znp_plan_id');
        $responseId = null;

        if ($isZnpPlan) {
            $znpPlan = ZnpPricingPlan::findOrFail($request->znp_plan_id);
            $total_amount = $znpPlan->totalWithGst();
            $responseId = 'znp-' . $znpPlan->id;
        } else {
            $package = Package::where('id', $request->package_id)->firstOrFail();
            $orginal_amount = $package->package_price;
            $total_amount = ($orginal_amount + ($orginal_amount * 18) / 100);
            $responseId = $request->package_id;
        }

        if (isset($payment_response['id']) && $payment_response['id'] != null) {

            $request_url = self::BASE_URL . '/v1/payment_intents';

            $request_data = [
                'amount' => $total_amount * 100, // multiply amount with 100
                'currency' => "INR",
                'payment_method_types[]' => 'card',
                'payment_method' => $payment_response['id'],
                'confirm' => 'true',
                'capture_method' => 'automatic',
                'return_url' => route('employerstripeResponse', $responseId),
                'payment_method_options[card][request_three_d_secure]' => 'automatic',
            ];

            $request_payload = http_build_query($request_data);

            $request_headers = [
                'Content-Type: application/x-www-form-urlencoded',
                'Authorization: Bearer ' . self::stripeSecret()
            ];

            // another curl request
            $response_body = $this->curlPost($request_url, $request_payload, $request_headers);

            $response_data = json_decode($response_body, true);

            //  dd($response_data);

            // transaction required 3d secure redirect
            if (isset($response_data['next_action']['redirect_to_url']['url']) && $response_data['next_action']['redirect_to_url']['url'] != null) {

                return redirect()->away($response_data['next_action']['redirect_to_url']['url']);

                // transaction success without 3d secure redirect
            } elseif (isset($response_data['status']) && $response_data['status'] == 'succeeded') {

                return redirect()->route('employerstripeResponse', $responseId)->with('success', 'Payment success.');

                // transaction declined because of error
            } elseif (isset($response_data['error']['message']) && $response_data['error']['message'] != null) {

                return redirect()->route('employerstripeResponse', $responseId)->with('error', $response_data['error']['message']);

            } else {

                return redirect()->route('employerstripeResponse')->with('error', 'Something went wrong, please try again.');
            }

            // error in creating payment method
        } elseif (isset($payment_response['error']['message']) && $payment_response['error']['message'] != null) {

            return redirect()->route('employerstripeResponse', $responseId)->with('error', $payment_response['error']['message']);

        }
    }


    /**
     * Stripe return handler for new ZNP job-posting plans.
     */
    protected function employerZnpResponse(Request $request, int $znpPlanId)
    {
        $request_data = $request->all();
        $employer = Company::where('id', Auth::guard('company')->user()->id)->first();
        $znpPlan = ZnpPricingPlan::findOrFail($znpPlanId);

        if (! isset($request_data['payment_intent']) || $request_data['payment_intent'] == null) {
            return redirect()->back()->with('error', 'Invalid Card Details');
        }

        $get_url = self::BASE_URL . '/v1/payment_intents/' . $request_data['payment_intent'];
        $get_headers = ['Authorization: Bearer ' . self::stripeSecret()];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $get_url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $get_headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $get_response = curl_exec($ch);
        curl_close($ch);

        $get_data = json_decode($get_response, true);

        if (! isset($get_data['status']) || $get_data['status'] !== 'succeeded') {
            $employer->payment_status = 0;
            $employer->save();

            $error = $get_data['error']['message'] ?? 'Payment request failed.';

            return view('payment-failure')->with('error', $error);
        }

        $paymentRef = $get_data['id'];

        if (ZnpCompanySubscription::where('payment_ref', $paymentRef)->exists()) {
            Session::put('employer_plan_payment', 'Employer Payment success');

            return redirect('/thank-you');
        }

        $company = Auth::guard('company')->user();
        $baseAmount = (float) $znpPlan->price;
        $gst = $baseAmount * (float) $znpPlan->gst_percent / 100;
        $total_amount = round($baseAmount + $gst, 2);
        $plan = $znpPlan->name;

        $subscription = app(ZnpSubscriptionService::class)->grantPlan(
            $company,
            $znpPlan,
            'stripe',
            $paymentRef,
            $total_amount,
            null,
            'Stripe PaymentIntent ' . $paymentRef
        );

        $rand = Str::random(4);
        $invoice_no = $rand . '_' . date('Y-m-d');

        $pdf = PDF::loadView('invoices.employer-pdf-invoice', [
            'name' => $employer->name,
            'email' => $employer->email,
            'mobile' => $employer->phone,
            'gstin' => $employer->gstin,
            'location' => $employer->location,
            'invoice_no' => $invoice_no,
            'amount' => number_format($baseAmount, 2),
            'gst' => number_format($gst, 2),
            'total_amount' => number_format($total_amount, 2),
            'plan' => $plan,
            'start_date' => optional($subscription->starts_at)->format('Y-m-d'),
            'end_date' => optional($subscription->expires_at)->format('Y-m-d'),
            'payment_id' => $paymentRef,
            'user_id' => '',
        ]);

        $invoiceName = 'Invoice' . '-' . time() . '_' . date('Y-m-d') . '.pdf';
        $pdf->save(public_path('invoices/' . $invoiceName));

        EmployerPayment::create([
            'payment_id' => $paymentRef,
            'company_id' => $employer->id,
            'payment_status' => 1,
            'payment_activity' => 1,
            'plan_id' => $znpPlan->id,
            'amount' => $total_amount,
            'invoice' => $invoiceName,
            'invoice_status' => 0,
            'invoice_no' => $invoice_no,
        ]);

        EmployerPaymenthistory::create([
            'payment_id' => $paymentRef,
            'amount' => $total_amount,
            'employer_id' => $employer->id,
            'plan' => $znpPlan->id,
            'package_start_date' => optional($subscription->starts_at)->format('Y-m-d'),
            'package_end_date' => optional($subscription->expires_at)->format('Y-m-d'),
            'payment_status' => 1,
        ]);

        $employer->payment_status = 1;
        $employer->payment_activity = 1;
        $employer->save();

        $data = [
            'title' => $request->input('email'),
            'subject' => 'Payment Success',
            'plan' => $plan,
            'gst' => $gst,
            'original_amount' => number_format($baseAmount, 2),
            'amount' => number_format($total_amount, 2),
            'start_date' => optional($subscription->starts_at)->format('Y-m-d'),
            'end_date' => optional($subscription->expires_at)->format('Y-m-d'),
            'payment_id' => $paymentRef,
        ];

        $email = $company->email;
        Mail::send('emails.employer_payment', $data, function ($message) use ($data, $email) {
            $message->to($email)->from('employer@zeronoticeperiod.com')
                ->subject($data['subject']);
        });

        Session::forget('znp_checkout_plan_id');
        Session::put('employer_plan_payment', 'Employer Payment success');

        return redirect('/thank-you');
    }


    public function employerresponse(Request $request, $package_id)
    {
        if (is_string($package_id) && strpos($package_id, 'znp-') === 0) {
            return $this->employerZnpResponse($request, (int) substr($package_id, 4));
        }

        $request_data = $request->all();
        $employer = Company::where('id', Auth::guard('company')->user()->id)->first();

        //dd($package_id);

        // if only stripe response contains payment_intent
        if (isset($request_data['payment_intent']) && $request_data['payment_intent'] != null) {

            // here we will check status of the transaction with payment_intents from stripe server
            $get_url = self::BASE_URL . '/v1/payment_intents/' . $request_data['payment_intent'];

            $get_headers = [
                'Authorization: Bearer ' . self::stripeSecret()
            ];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $get_url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $get_headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $get_response = curl_exec($ch);

            curl_close($ch);

            $get_data = json_decode($get_response, 1);

            //  dd($get_data);

            // get record of transaction from database
            // so we can verify with response and update the transaction status
            // $input = \DB::table('transactions')
            //     ->where('transaction_id', $transaction_id)
            //     ->first();

            // here you can check amount, currency etc with $get_data
            // which you can check with your database record
            // for example amount value check



            // succeeded means transaction success
            if (isset($get_data['status']) && $get_data['status'] == 'succeeded') {


                $company = Auth::guard('company')->user();


                $input = $request->all();

                $plan_package = Package::where('id', $package_id)->first();
                $plan = $plan_package->package_title;
                $planid = $package_id;



                if ($employer->package_id > 0) {



                    $package = Package::find($package_id);

                    $this->updateCompanyPackage($company, $package);

                } else {
                    // dd('package id is not there');

                    if ($package_id && $package_id > 0) {


                        $package = Package::find($package_id);

                        $this->addCompanyPackage($company, $package);

                        // $this->addCompanySearchPackage($company, $package);

                    }

                }


                $package = Package::find($package_id);

                $rand = Str::random(4);

                $invoice_no = $rand . '_' . date('Y-m-d');

                $gst = $package->package_price * 18 / 100;

                $total_amount = $gst + $package->package_price;

                $pdf = PDF::loadView('invoices.employer-pdf-invoice', [
                    'name' => $employer->name,
                    'email' => $employer->email,
                    'mobile' => $employer->phone,
                    'gstin' => $employer->gstin,
                    'location' => $employer->location,
                    'invoice_no' => $invoice_no,
                    'amount' => number_format($package->package_price, 2),
                    'gst' => number_format($gst, 2),
                    'total_amount' => number_format($total_amount, 2),
                    'plan' => $plan,
                    'start_date' => $employer->package_start_date,
                    'end_date' => $employer->package_end_date,
                    'payment_id' => $get_data['id'],
                    'user_id' => ''
                ]);

                $invoiceName = 'Invoice' . '-' . time() . '_' . date('Y-m-d') . '.pdf';

                $pdf->save(public_path('invoices/' . $invoiceName));

                $gst = $package->package_price * 18 / 100;


                $final = EmployerPayment::create([
                    'payment_id' => $get_data['id'],
                    'company_id' => $employer->id,
                    'payment_status' => 1,
                    'payment_activity' => 1,
                    'plan_id' => $planid,
                    'amount' => $total_amount,
                    'invoice' => $invoiceName,
                    'invoice_status' => 0,
                    'invoice_no' => $invoice_no

                ]);

                $employer_payment_history = EmployerPaymenthistory::create([

                    'payment_id' => $get_data['id'],
                    'amount' => $total_amount,
                    'employer_id' => $employer->id,
                    'plan' => $planid,
                    'package_start_date' => $employer->package_start_date,
                    'package_end_date' => $employer->package_end_date,
                    'payment_status' => 1



                ]);

                $current = Carbon::now();

                $employer->payment_status = 1;
                $employer->payment_activity = 1;
                $employer->save();


                $data = [

                    'title' => $request->input('email'),

                    'subject' => 'Payment Success',

                    'plan' => $plan,
                    'gst' => $gst,
                    'original_amount' => number_format($package->package_price, 2),
                    'amount' => number_format($total_amount, 2),

                    'start_date' => $employer->package_start_date,
                    'end_date' => $employer->package_end_date,
                    'payment_id' => $get_data['id'],



                ];

                $email = $company->email;

                $emails = ['employer@zeronoticeperiod.com', $email];
                Mail::send('emails.employer_payment', $data, function ($message) use ($data, $email) {

                    $message->to($email)->from('employer@zeronoticeperiod.com')

                        ->subject($data['subject']);

                });





                ///  dd('success');
                Session::put('employer_plan_payment', "Employer Payment success");

                return redirect('/thank-you');

                //   return view('response')->with('success', 'Payment success.');

                // update here transaction for record something like this
                // $input = \DB::table('transactions')
                //     ->where('transaction_id', $transaction_id)
                //     ->update(['status' => 'success']);

            } elseif (isset($get_data['error']['message']) && $get_data['error']['message'] != null) {

                // dd('error');


                $employer->payment_status = 0;
                $employer->save();


                return view('payment-failure')->with('error', $get_data['error']['message']);

            } else {


                $employer->payment_status = 0;
                $employer->save();

                return view('payment-failure')->with('error', 'Payment request failed.');
            }
        } else {

            return redirect()->back()->with('error', 'Invalid Card Details');


            return view('payment-failure')->with('error', 'Payment request failed.');

        }
    }

    public function InvoiceTest(Request $request)
    {
        return view('invoices.employer-pdf-invoice')->with([
            'name' => '$employer->name',
            'email' => ' $employer->email',
            'mobile' => ' $employer->phone',
            'gstin' => null,
            'location' => ' $employer->location',
            'invoice_no' => '$invoice_no',
            'amount' => number_format(100, 2),
            'gst' => number_format(100, 2),
            'total_amount' => number_format(100, 2),
            'plan' => '$plan',
            'start_date' => 2023 - 12 - 21,
            'end_date' => 2023 - 12 - 21,
            'payment_id' => "get_data['id']",
            'user_id' => 'confirm'
        ]);
    }


    public function employerbuycv(Request $request, $user_id)
    {



        if (!Auth::guard('company')->check()) {
            return redirect()->to(url()->previous() . '#success-section')->with('message12', 'Please Login as a Employer');
        }

        $company_id = Auth::guard('company')->user()->id;
        $package_price = 200;
        $package = (object) [
            'price' => 200,
            'package_title' => 'Single CV',
            'id' => '10'
        ];


        // $kyc_applied = Company::withCount('kycdocuments')
        // ->where('id', $company_id)
        // ->first();

        // if(!$kyc_applied->kycdocuments_count ||  $kyc_applied->kyc_verified == 3||  $kyc_applied->kyc_verified == 1){
        //     $data = [
        //         'kyc_applied'=> $kyc_applied->kycdocuments_count,
        //         'status'=> $kyc_applied->kyc_verified
        //     ] ;
        //     return view('company.warning',compact('data'));
        // }

        $employer = Company::where('id', $company_id)->first();


        $employer->payment_activity = 0;
        $employer->save();

        $amount = $package_price;
        $gst = $amount * 18 / 100;
        $total_amount = $gst + $amount;

        Session::put('plan', $package->price);

        Session::put('amount', $total_amount);
        $user = User::where('id', $user_id)
            // ->select('id','recorded_video')
            ->first();
        // $data = User::where('recorded_video','!=',null)
        // ->first();
        // dd( $data );

        return view('company.inc.buycvpayment', compact('employer', 'package', 'total_amount', 'user_id', 'user'));

    }


    public function employerbuycvsubmit(Request $request)
    {




        $input = $request->validate([
            'card_no' => 'required',
            'exp_month' => 'required',
            'exp_year' => 'required',
            'cvc' => 'required',

        ]);

        $input['transaction_id'] = Str::random(15);
        ; // random string for transaction id

        $payment_url = self::BASE_URL . '/v1/payment_methods';

        $payment_data = [
            'type' => 'card',
            'card[number]' => $input['card_no'],
            'card[exp_month]' => $input['exp_month'],
            'card[exp_year]' => $input['exp_year'],
            'card[cvc]' => $input['cvc'],
            'billing_details[address][country]' => "IN",
            'billing_details[email]' => auth()->guard('company')->user()->email,
            'billing_details[name]' => auth()->guard('company')->user()->name,
            'billing_details[phone]' => auth()->guard('company')->user()->phone,
        ];

        $payment_payload = http_build_query($payment_data);

        $payment_headers = [
            'Content-Type: application/x-www-form-urlencoded',
            'Authorization: Bearer ' . self::stripeSecret()
        ];

        // sending curl request
        // see last function for code
        $payment_body = $this->curlPost($payment_url, $payment_payload, $payment_headers);

        $payment_response = json_decode($payment_body, true);

        if ($request->video_interview_check == '1') {
            $video_interview_amount = config('payment.video_interview.amount');

            $package = (object) [
                'package_price' => 200 + $video_interview_amount,
                'package_title' => 'Single CV',
                'id' => '10'
            ];


            $employer_payment = new EmployerPayment();
            $employer_payment->payment_method = config('payment.payment_method.single_cv');
            $employer_payment->company_id = auth()->guard('company')->user()->id;
            $employer_payment->singlecv_videointerview = 1;
            $employer_payment->payment_status = 0;
            $employer_payment->save();

        } else {
            $video_interview_amount = '';
            $package = (object) [
                'package_price' => 200,
                'package_title' => 'Single CV',
                'id' => '10'
            ];


            $employer_payment = new EmployerPayment();
            $employer_payment->payment_method = config('payment.payment_method.single_cv');
            $employer_payment->company_id = auth()->guard('company')->user()->id;
            $employer_payment->payment_status = 0;
            $employer_payment->singlecv_videointerview = 0;
            $employer_payment->save();

        }





        Session::put('video_interview_check', $request->video_interview_check);
        Session::put('video_interview_amount', $video_interview_amount);

        $orginal_amount = $package->package_price;

        // dd($orginal_amount);

        $total_amount = ($orginal_amount + ($orginal_amount * 18) / 100);

        // dd($total_amount);

        $user_id = $request->user_id;


        if (isset($payment_response['id']) && $payment_response['id'] != null) {

            $request_url = self::BASE_URL . '/v1/payment_intents';

            $request_data = [
                'amount' => $total_amount * 100, // multiply amount with 100
                'currency' => "INR",
                'payment_method_types[]' => 'card',
                'payment_method' => $payment_response['id'],
                'confirm' => 'true',
                'capture_method' => 'automatic',
                'return_url' => route('view-applicant-profile', $user_id),
                'payment_method_options[card][request_three_d_secure]' => 'automatic',
            ];

            $request_payload = http_build_query($request_data);

            $request_headers = [
                'Content-Type: application/x-www-form-urlencoded',
                'Authorization: Bearer ' . self::stripeSecret()
            ];

            // another curl request
            $response_body = $this->curlPost($request_url, $request_payload, $request_headers);

            $response_data = json_decode($response_body, true);



            //  dd($response_data);

            // transaction required 3d secure redirect
            if (isset($response_data['next_action']['redirect_to_url']['url']) && $response_data['next_action']['redirect_to_url']['url'] != null) {

                return redirect()->away($response_data['next_action']['redirect_to_url']['url']);

                // transaction success without 3d secure redirect
            } elseif (isset($response_data['status']) && $response_data['status'] == 'succeeded') {

                return redirect()->route('view-applicant-profile', $user_id)->with('success', 'Payment success.');

                // transaction declined because of error
            } elseif (isset($response_data['error']['message']) && $response_data['error']['message'] != null) {

                return redirect()->route('view-applicant-profile', $user_id)->with('error', $response_data['error']['message']);

            } else {

                return redirect()->route('view-applicant-profile')->with('error', 'Something went wrong, please try again.');
            }

            // error in creating payment method
        } elseif (isset($payment_response['error']['message']) && $payment_response['error']['message'] != null) {

            return redirect()->route('view-applicant-profile', $user_id)->with('error', $payment_response['error']['message']);

        }
    }


    public function employerbuyinterview(Request $request, $user_id)
    {


        if (!Auth::guard('company')->check()) {
            return redirect()->to(url()->previous() . '#success-section')->with('message12', 'Please Login as a Employer');
        }

        $company_id = Auth::guard('company')->user()->id;
        $package_price = config('payment.video_interview.amount');
        $package = (object) [
            'price' => $package_price,
            'package_title' => 'Video Interview',
            'id' => '11'
        ];

        $employer = new EmployerPayment();
        $employer->payment_method = config('payment.payment_method.video_interview');
        $employer->company_id = $company_id;
        $employer->payment_status = 0;
        $employer->save();

        $amount = $package_price;
        $gst = $amount * 18 / 100;
        $total_amount = $gst + $amount;

        Session::put('plan', $package->price);

        Session::put('amount', $total_amount);

        return view('company.inc.buyvideointerviewpayment', compact('package', 'total_amount', 'user_id'));

    }

    public function employerbuyinterviewsubmit(Request $request)
    {

        //dd($request->all());


        $input = $request->validate([
            'card_no' => 'required',
            'exp_month' => 'required',
            'exp_year' => 'required',
            'cvc' => 'required',

        ]);

        $input['transaction_id'] = Str::random(15);
        ; // random string for transaction id

        $payment_url = self::BASE_URL . '/v1/payment_methods';

        $payment_data = [
            'type' => 'card',
            'card[number]' => $input['card_no'],
            'card[exp_month]' => $input['exp_month'],
            'card[exp_year]' => $input['exp_year'],
            'card[cvc]' => $input['cvc'],
            'billing_details[address][country]' => "IN",
            'billing_details[email]' => auth()->guard('company')->user()->email,
            'billing_details[name]' => auth()->guard('company')->user()->name,
            'billing_details[phone]' => auth()->guard('company')->user()->phone,
        ];

        $payment_payload = http_build_query($payment_data);

        $payment_headers = [
            'Content-Type: application/x-www-form-urlencoded',
            'Authorization: Bearer ' . self::stripeSecret()
        ];

        // sending curl request
        // see last function for code
        $payment_body = $this->curlPost($payment_url, $payment_payload, $payment_headers);

        $payment_response = json_decode($payment_body, true);

        $video_interview_amount = config('payment.video_interview.amount');
        $package = (object) [
            'package_price' => $video_interview_amount,
            'package_title' => config('payment.video_interview.title'),
            'id' => config('payment.video_interview.id')
        ];


        Session::put('video_interview_amount', $video_interview_amount);

        $orginal_amount = $package->package_price;

        // dd($orginal_amount);

        $total_amount = ($orginal_amount + ($orginal_amount * 18) / 100);

        // dd($total_amount);

        $user_id = $request->user_id;



        if (isset($payment_response['id']) && $payment_response['id'] != null) {

            $request_url = self::BASE_URL . '/v1/payment_intents';

            $request_data = [
                'amount' => $total_amount * 100, // multiply amount with 100
                'currency' => "INR",
                'payment_method_types[]' => 'card',
                'payment_method' => $payment_response['id'],
                'confirm' => 'true',
                'capture_method' => 'automatic',
                'return_url' => route('view-applicant-profile', $user_id),
                'payment_method_options[card][request_three_d_secure]' => 'automatic',
            ];

            $request_payload = http_build_query($request_data);

            $request_headers = [
                'Content-Type: application/x-www-form-urlencoded',
                'Authorization: Bearer ' . self::stripeSecret()
            ];

            // another curl request
            $response_body = $this->curlPost($request_url, $request_payload, $request_headers);

            $response_data = json_decode($response_body, true);



            //  dd($response_data);

            // transaction required 3d secure redirect
            if (isset($response_data['next_action']['redirect_to_url']['url']) && $response_data['next_action']['redirect_to_url']['url'] != null) {

                return redirect()->away($response_data['next_action']['redirect_to_url']['url']);

                // transaction success without 3d secure redirect
            } elseif (isset($response_data['status']) && $response_data['status'] == 'succeeded') {

                return redirect()->route('view-applicant-profile', $user_id)->with('success', 'Payment success.');

                // transaction declined because of error
            } elseif (isset($response_data['error']['message']) && $response_data['error']['message'] != null) {

                return redirect()->route('view-applicant-profile', $user_id)->with('error', $response_data['error']['message']);

            } else {

                return redirect()->route('view-applicant-profile')->with('error', 'Something went wrong, please try again.');
            }

            // error in creating payment method
        } elseif (isset($payment_response['error']['message']) && $payment_response['error']['message'] != null) {

            return redirect()->route('view-applicant-profile', $user_id)->with('error', $payment_response['error']['message']);

        }
    }

    public function cvpurchasestripeResponse(Request $request, $user_id)
    {
        $request_data = $request->all();



        //dd($package_id);

        // if only stripe response contains payment_intent
        if (isset($request_data['payment_intent']) && $request_data['payment_intent'] != null) {

            // here we will check status of the transaction with payment_intents from stripe server
            $get_url = self::BASE_URL . '/v1/payment_intents/' . $request_data['payment_intent'];

            $get_headers = [
                'Authorization: Bearer ' . self::stripeSecret()
            ];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $get_url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $get_headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $get_response = curl_exec($ch);

            curl_close($ch);

            $get_data = json_decode($get_response, 1);



            // succeeded means transaction success
            if (isset($get_data['status']) && $get_data['status'] == 'succeeded') {


                $company = Auth::guard('company')->user();
                $employer = Company::where('id', Auth::guard('company')->user()->id)->first();

                $input = $request->all();

                $video_interview_check = Session::get('video_interview_check');

                $employer_payment = EmployerPayment::where('company_id', $employer->id)->orderBy('id', 'desc')->first();

                if ($employer_payment->payment_method == 2) {
                    if ($video_interview_check == '1') {
                        $video_interview_amount = Session::get('video_interview_amount');

                        $package = (object) [
                            'package_price' => 200 + $video_interview_amount,
                            'package_title' => 'Single CV',
                            'id' => '10'
                        ];

                    } else {

                        $package = (object) [
                            'package_price' => 200,
                            'package_title' => 'Single CV',
                            'id' => '10'
                        ];

                    }
                } elseif ($employer_payment->payment_method == 3) {
                    $package = (object) [
                        'package_price' => config('payment.video_interview.amount'),
                        'package_title' => config('payment.video_interview.title'),
                        'id' => config('payment.video_interview.id')
                    ];
                }

                // dd($employer_payment->payment_method);



                $plan = $package->package_title;
                $planid = $package->id;
                $user = User::findOrFail($user_id);
                $confirm = $user->first_name . '_' . $user->id;


                $rand = Str::random(4);

                $invoice_no = $rand . '_' . date('Y-m-d');

                $today = date('Y-m-d');

                $gst = $package->package_price * 18 / 100;

                $total_amount = $gst + $package->package_price;

                $pdf = PDF::loadView('invoices.employer-pdf-invoice', [

                    'name' => $employer->name,
                    'email' => $employer->email,
                    'mobile' => $employer->phone,
                    'gstin' => $employer->gstin,
                    'location' => $employer->location,
                    'invoice_no' => $invoice_no,
                    'amount' => number_format($package->package_price, 2),
                    'gst' => number_format($gst, 2),
                    'total_amount' => number_format($total_amount, 2),
                    'plan' => $plan,
                    'start_date' => $today,
                    'end_date' => date('Y-m-d', strtotime($today . ' +30 days')),
                    'payment_id' => $get_data['id'],
                    'user_id' => $confirm
                ]);

                // dd($pdf);

                $invoiceName = 'Invoice' . '-' . time() . '_' . date('Y-m-d') . '.pdf';

                $pdf->save(public_path('invoices/' . $invoiceName));

                $gst = $package->package_price * 18 / 100;

                //  dd($gst);


                $final = $employer_payment->update([
                    'payment_id' => $get_data['id'],
                    'payment_status' => 1,
                    'payment_activity' => 1,
                    'plan_id' => $planid,
                    'amount' => $total_amount,
                    'invoice' => $invoiceName,
                    'invoice_status' => 1,
                    'invoice_no' => $invoice_no,
                    'plan_start_date' => $today,
                    'plan_end_date' => date('Y-m-d', strtotime($today . ' +30 days')),
                    'user_id' => $user->id

                ]);

                $employer_payment_history = EmployerPaymenthistory::create([

                    'payment_id' => $get_data['id'],
                    'amount' => $total_amount,
                    'employer_id' => $employer->id,
                    'plan' => $planid,
                    'package_start_date' => $today,
                    'package_end_date' => date('Y-m-d', strtotime($today . ' +30 days')),
                    'payment_status' => 1



                ]);

                $current = Carbon::now();

                $employer->payment_status = 1;
                $employer->payment_activity = 1;
                $employer->save();


                $data = [

                    'title' => $request->input('email'),
                    'subject' => 'Payment Success',
                    'plan' => $plan,
                    'gst' => $gst,
                    'original_amount' => number_format($package->package_price, 2),
                    'amount' => number_format($total_amount, 2),
                    'start_date' => $today,
                    'end_date' => date('Y-m-d', strtotime($today . ' +30 days')),
                    'payment_id' => $get_data['id'],
                    'user_id' => $confirm

                ];
                //  dd($data);

                $email = $company->email;

                $emails = ['employer@zeronoticeperiod.com', $email];
                Mail::send('emails.employer_payment', $data, function ($message) use ($data, $email) {

                    $message->to($email)->from('employer@zeronoticeperiod.com')

                        ->subject($data['subject']);

                });

                $c_id = Auth::guard('company')->user()->id;

                $com = Company::where('id', $c_id)->first();



                $unlock = Unlocked_users::where('company_id', Auth::guard('company')->user()->id)->where('unlocked_users_ids', $user_id)->first();

                if (empty($unlock)) {
                    $unlock = new Unlocked_users();

                    $unlock->company_id = Auth::guard('company')->user()->id;

                    $unlock->unlocked_users_ids = $user_id;

                    $unlock->save();

                    $com->availed_verified_cv_access += 1;

                    $com->availed_cvs_quota += 1;

                    $com->free_cv_access += 1;

                    $com->save();

                }


                if (!$employer_payment->payment_method == 3) {

                    $no_profile_views = $user->no_profile_views + 1;

                    $user->no_profile_views = $no_profile_views;

                    $user->update();

                }



                $collections = Collection::where('user_id', Auth::guard('company')->user()->id)->get();

                $profileCv = $user->getDefaultCv();
                //  dd($user->id);



                session()->put('user_id_data', $user->id);

                return redirect('razor-thank-you');


                //   return view('user.applicant_profile')

                //                   ->with('user', $user)

                //                   ->with('profileCv', $profileCv)

                //                   ->with('page_title', $user->getName())

                //                   ->with('form_title', 'Contact ' . $user->getName())

                //                   ->with('collections',$collections);



            } elseif (isset($get_data['error']['message']) && $get_data['error']['message'] != null) {

                // dd('error');

                $employer = Company::where('id', Auth::guard('company')->user()->id)->first();
                $employer->payment_status = 0;
                $employer->save();


                return view('payment-failure')->with('error', $get_data['error']['message']);

            } else {

                $employer = Company::where('id', Auth::guard('company')->user()->id)->first();
                $employer->payment_status = 0;
                $employer->save();

                return view('payment-failure')->with('error', 'Payment request failed.');
            }
        } else {

            return redirect()->back()->with('error', 'Invalid Card Details');


            return view('payment-failure')->with('error', 'Payment request failed.');

        }
    }






}
