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

       // return dd($request);

    // $request->validate([
    //     'counter' =>'required||numeric|max:1000000',
    //     'counter1'=>'required|numeric|max:1000000'
        
    // ]);

    $request->validate(

[
    'counter'  =>'required|numeric|max:1000000',
    'counter1' => 'required|numeric|max:1000000'

],
[
    'counter.required'  => 'NON IT IMMEDIATE HIRES is required',
    'counter.max'       => 'NON IT IMMEDIATE HIRES may not be greater than 1000000',
    'counter1.required' => 'IT IMMEDIATE HIRES is required',
    'counter1.max'      => 'IT IMMEDIATE HIRES may not be greater than 1000000'
]

    );
    

     $counter=Counter::where('id',$request->counter_value)->first();

    // return $c;

    // return $query->where($column, 'like', '%'.$value.'%');

    

    

    // $counter=new Counter();

     $counter->counter_id=$request->id;

    $counter->counter=$request->counter;

    $counter->counter1=$request->counter1;

    $counter->update();

    

    

    return redirect()->back()->with('success','Successfully Updated');

    

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

