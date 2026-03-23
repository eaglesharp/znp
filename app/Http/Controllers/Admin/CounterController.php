<?php



namespace App\Http\Controllers\Admin;



use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Counter;



class CounterController extends Controller

{

    public function indexcounter()

    {

        $counter=Counter::all();

    return view('admin.counters.counter')->with('counter',$counter);

    

    }

    

    public function storecounter(Request $request)
    {
        $request->validate([
            'counter'        => 'required|numeric|max:1000000',
            'counter1'       => 'required|numeric|max:1000000',
            'active_jobs'    => 'required|numeric|min:0|max:9999999',
            'permanent_jobs' => 'required|numeric|min:0|max:9999999',
            'contract_jobs'  => 'required|numeric|min:0|max:9999999',
            'fresher_jobs'   => 'required|numeric|min:0|max:9999999',
        ], [
            'counter.required'        => 'NON IT IMMEDIATE HIRES is required',
            'counter1.required'       => 'IT IMMEDIATE HIRES is required',
            'active_jobs.required'    => 'Active Jobs count is required',
            'permanent_jobs.required' => 'Permanent Jobs count is required',
            'contract_jobs.required'  => 'Contract Jobs count is required',
            'fresher_jobs.required'   => 'Fresher Jobs count is required',
        ]);

        $counter = Counter::where('id', $request->counter_value)->first();
        $counter->counter        = $request->counter;
        $counter->counter1       = $request->counter1;
        $counter->active_jobs    = $request->active_jobs;
        $counter->permanent_jobs = $request->permanent_jobs;
        $counter->contract_jobs  = $request->contract_jobs;
        $counter->fresher_jobs   = $request->fresher_jobs;
        $counter->save();

        return redirect()->back()->with('success', 'Successfully Updated');
    }

    

    public function editcounter( Request $request )

    {

    

    return $request;

    

    }

    

    public function updatecounter(Request $request)

    

    {

    

    return $request;

    

    

    }

    

}

