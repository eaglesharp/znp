<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\User;
use App\Company;
use App\JobSkill;
use App\Location;
use App\NewsLetter;

use DB; 
class ActionController extends Controller
{
    public function searchresumes(Request $request)
    {
       $company_id = Auth::guard('company')->user()->id;

      
    }

    public function getuserdata(Request $request)
    {

      $user = User::where('id',$request->user)->first();

      return response()->json(['user'=>$user]);

     
    }
    public function getcompanydata(Request $request)
    {

      // dd($request->all());

       if($request->user == 'all')
       {
      
        return view('admin.activites.employer_activities');

       }else{

        $companydata = Company::where('id',$request->user)->first();
        

        return view('admin.activites.employer_search',compact('companydata'));

       }

    }
    
     public function getskills(Request $request)
    {
    
        $q = $request->query;
        
        if(strlen($request->get('query')) >= 2)
        {

   
        $data1 =  JobSkill::where('job_skill', 'LIKE', "%{$request->get('query')}%")->select('job_skill')->distinct()->get();
       
        $data = array();
        foreach ($data1 as $s) {
        
            array_push($data,$s->job_skill);
        }
        echo json_encode($data);
        
        }
      
     
    }
    public function searchskills(Request $request)
    {
    
        $q = $request->query;
        $qValue = $request->get('q');
       
        if(strlen($qValue) >= 2)
        {
            $data1 = JobSkill::whereRaw('LOWER(TRIM(job_skill)) LIKE ?', ["%{$qValue}%"])
            ->distinct()
            ->select('id', 'job_skill')
             ->groupBy('job_skill')
            ->take(10)
            ->get();
            //   dd($data1->toArray());
      
        return $data1;
        }else{
          return [];
        }

       
     
    }
    
    
    
    
    public function checkEmail(Request $request)
    {
        $email = $request->input('email');

      //  dd($request->all());

        $user = User::where('email', $email)->first();

        if ($user) {
            return response()->json([
                'exists' => true
            ]);
        } else {
            return response()->json([
                'exists' => false
            ]);
        }
    }
    
    
    public function searchcompanies(Request $request)
    {
        $data = DB::table('company_data')
                ->select('id', 'name')
                ->where('name', 'like', '%' . $request->input('q') . '%')
                ->get();

        return response()->json($data);
    }
    
    public function searchuniversity(Request $request)
    {
        $data = DB::table('degrees')
                ->select('id', 'educations')
                ->where('educations', 'like', '%' . $request->input('q') . '%')
                ->get();

        return response()->json($data);
    }



     public function searchlocations(Request $request)
    {
    
        $q = $request->query;
        
        if(strlen($request->get('query')) >= 2)
        {

   
      
        $data1 = Location::where('location', 'LIKE', "%{$request->get('query')}%")
                  ->select('location')
                  ->distinct()
                  ->take(2)
                  ->get();
                  

       
        $data = array();
        foreach ($data1 as $s) {
        
            array_push($data,$s->location);
        }
        echo json_encode($data);
        
        }
      
     
    }
    
    public function searchlocationsforprofile(Request $request)
    {
    
       $q = $request->query;
        
        if(strlen($request->get('q')) >= 2)
        {

   
      
        $data = Location::where('location', 'LIKE', "%{$request->get('q')}%")
                  ->select('location')
                  ->distinct()
                  ->get();

                  return response()->json($data);
        
        
        }
      
      
     
    }

    // For Jobs Listing Page and Job Creating Function

    public function searchlocationsforljob(Request $request)
    {
    
        $query = $request->get('query');
       
        $data = Location::where('location', 'LIKE', "%{$query}%")
        ->select('location')
        ->distinct()
        ->orderByRaw("CASE WHEN location LIKE '{$query}%' THEN 0 ELSE 1 END, location")
        ->take(10)
        ->pluck('location');
            
        return response()->json($data);
      
     
    }


    public function searchskillsposition(Request $request)
    {
        $query = $request->get('query');
    
        // if (strlen($query) >= 2) {
            $data = JobSkill::where('job_skill', 'LIKE', "%{$query}%")
                ->select('job_skill')
                ->distinct()
                ->orderByRaw("CASE WHEN job_skill LIKE '{$query}%' THEN 0 ELSE 1 END, job_skill")
                ->take(10)
                ->pluck('job_skill');
              
            
            return response()->json($data);
        // }

    }
    
    public function searchcvlocations(Request $request)
    {
        $query = $request->get('query');
    
        // if (strlen($query) >= 2) {
            $data = Location::where('location', 'LIKE', "%{$query}%")
                    ->select('location')
                    ->distinct()
                    ->orderByRaw("CASE WHEN location LIKE '{$query}%' THEN 0 ELSE 1 END, location")
                    ->take(10)
                    ->pluck('location');
              
            
            return response()->json($data);
        // }

    }
    public function searchcvskills(Request $request)
    {
        $query = $request->get('query');
        $data = JobSkill::where('job_skill', 'LIKE', "%{$request->get('query')}%")
        ->orderByRaw("CASE WHEN job_skill LIKE '{$query}%' THEN 0 ELSE 1 END, job_skill")
        ->groupBy('job_skill')
        ->take(10)
        ->pluck('job_skill');   
        return response()->json($data);

    }

    public function test(Request $request)
    {

        $arr2 = array_filter(array_map('strtolower', array_map('trim', explode(',', $request->tags))));
       dd($arr2);

        
    }

    public function newsletter(Request $request)
    {
       
        $validatedData = $request->validate([
            'email' => 'required|unique:news_letters,email'
        ], [
            'email.unique' => 'Already Subscribed'
        ]);
       // dd('test');

        $newsletter = new NewsLetter();
        $newsletter->email = $request->email;
        $newsletter->save();

      
        return redirect('newletter-thankyou');
    }
    


}
