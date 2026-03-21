<?php



namespace App\Http\Controllers;



use Illuminate\Http\Request;

use App\Price;

use App\Package;

use Illuminate\Support\Str;

use Illuminate\Support\Facades\Route;

use App\Company;

use Illuminate\Support\Facades\Mail;

use Illuminate\Support\Facades\Hash;

use App\Traits\CompanyTrait;

use App\Traits\CompanyPackageTrait;

use App\EmployerPayment;

use Illuminate\Support\Facades\Auth;

use Barryvdh\DomPDF\Facade as PDF;



class PriceController extends Controller

{

    use CompanyTrait;

    use CompanyPackageTrait;

  



    public function indexPrice()

    {

        $packages=Package::get()->take(4);

        

        //return dd($packages);

        


        

        return view('pricing')->with('packages',$packages);

        

    }

    public function indexwhyus()

    {

        return view('whyus');

    }

    

    public function indexplan()

    {

    

    $packages=Package::get()->take(3);

    

  

        return view('plan')->with('packages',$packages);

    }



    /**

     * Store a newly created resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\Response

     */

    public function companyredirect($id)
    {
       
        if($id == 17)
        {
          $plan = 'Trial';
        }
        if($id == 18)
        {
            $plan = 'Basic';
        }
        if($id == 19)
        {
            $plan = 'Standard';
    
        }
        if($id == 20)
        {
            $plan = 'Premium';
        }
      // dd($plan);

            if(Auth::guard('company')->check())
        {
          
        }else{
            return redirect('employer-login');
        }

        $company_id = Auth::guard('company')->user()->id;
        $package = Package::where('id', $id)->first() ;
         $employer = Company::where('id',$company_id)->first();
        // dd( (int)($package->package_price));   
    
        $employer->payment_status = 0;
        $employer->payment_activity = 0;
        $employer->save();

        if(empty($package->package_price))
        {
            $price = 0;
       
        }else{

            $price = $package->package_price;

        }
// dd($price);
       
    
        $final = EmployerPayment::create([
         
            'company_id' => $company_id,
            'payment_status' => 0,
            'payment_activity' => 0,       
            'amount' => $price,
            'plan_id' => $plan
    
        ]);


        $gst = $price*18/100;

        $total_amount = $gst+$price;
        // $total_amount  = $price;
        //  dd($total_amount);

        return view('company.inc.payment',compact('package','total_amount'));


    }

 

    

  

    //    $this->validate(

    //     $request, 
    //     [
    //         'company_name'=>'required',
    
    //         'email' =>'required|email',
        
    //         'mobile'  => 'required|numeric|digits:10',

    //         'person_name'=>'required',
    
    //         'size' =>'required',

    //         'pincode'=>'required|numeric|digits:6',
    
    //         'gstin' =>'max:15',

    //         'terms'=>'required',
    
    //       //  'package_name' =>'required',
    //     ],
    //     [
    
    //         'company_name.required' => ' Company Name is required',
    //         'email.required' => ' Email is required',
    //         'mobile.required' => ' Mobile/Landline is required',
    //         'person_name.required' => ' Contact Person Name is required',
    //         'size.required' => ' Company/Recruitment Firm is required',
    //         'pincode.required' => 'Pin Code is required',
    //         'gstin.max' => ' The maximum limit is 15 characters',
    //         'terms.required' => ' Terms and Conditions is required',
    //       //  'package_name.required' => ' Confirm New Password is required',
           
    //     ],
    // );

       

       

       

    //    if($request->promotional){

    

    //         $promotional=1;

    //    }else{

    //         $promotional=0;

    //    }

       

    //    $enquirydata=new Price();

       

    //    $enquirydata->company_name = $request->company_name;

    //    $enquirydata->email        = $request->email;

    //    $enquirydata->mobile       = $request->mobile;

    //    $enquirydata->person_name  = $request->person_name;

    //    $enquirydata->gstin         = $request->gstin;

    //    $enquirydata->size         = $request->size;

    //    $enquirydata->pincode      = $request->pincode;

    //    $enquirydata->promotional  = $promotional;

    //    $enquirydata->terms        = $request->terms;

    //    $enquirydata->package_name = $request->package_name;

    //    $enquirydata->slug = Str::slug($request->company_name, '-') ;

    //    $enquirydata->status = 0;

    // //    $enquirydata->slug = Str::slug($enquirydata->company_name, '-') . '-' . $company_name->id;

    //    $enquirydata->save();

       

    //    return response()->json(array('success' => true, 'status' => 200), 200);

       

    // //  return redirect()->route('pricing')->with('message','Data added Successfully');

    //    // return redirect()->back()->with('message','form submitted successfully');


}

