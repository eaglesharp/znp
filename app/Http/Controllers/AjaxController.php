<?php

namespace App\Http\Controllers;

use DB;
use Input;
use Form;
use App\Helpers\MiscHelper;
use App\Helpers\DataArrayHelper;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\Controller;
use App\Traits\CountryStateCity;

class AjaxController extends Controller
{

    use CountryStateCity;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function filterDefaultStates(Request $request)
    {
        $country_id = $request->input('country_id');
        $state_id = $request->input('state_id');
        $new_state_id = $request->input('new_state_id', 'state_id');
        $states = DataArrayHelper::defaultStatesArray($country_id);
        $dd = Form::select('state_id', ['' => __('Select State')] + $states, $state_id, array('id' => $new_state_id, 'class' => 'form-control'));
        echo $dd;
    }

    public function filterDefaultCities(Request $request)
    {
        $state_id = $request->input('state_id');
        $city_id = $request->input('city_id');
        $cities = DataArrayHelper::defaultCitiesArray($state_id);
        $dd = Form::select('city_id', ['' => 'Select City'] + $cities, $city_id, array('id' => 'city_id', 'class' => 'form-control'));
        echo $dd;
    }
    public function filterDefaultStates1(Request $request)
    {
        $country_id = $request->input('country_id');
        $state_id = $request->input('state_id');
        $new_state_id = $request->input('new_state_id', 'state_id');
        $states = DataArrayHelper::defaultStatesArray($country_id);
        $dd = Form::select('state_id1', ['' => __('Select State')] + $states, $state_id, array('id' => 'state_id1', 'class' => 'form-control'));
        echo $dd;
    }

    public function filterDefaultCities1(Request $request)
    {
        $state_id = $request->input('state_id');
        $city_id = $request->input('city_id');
        $cities = DataArrayHelper::defaultCitiesArray($state_id);
        $dd = Form::select('city_id1', ['' => 'Select City'] + $cities, $city_id, array('id' => 'city_id1', 'class' => 'form-control'));
        echo $dd;
    }

    /*     * ***************************************** */

    public function filterLangStates(Request $request)
    {
        $country_id = $request->input('country_id');
        $state_id = $request->input('state_id');
        $new_state_id = $request->input('new_state_id', 'state_id');
        $states = DataArrayHelper::langStatesArray($country_id);
        $dd = Form::select('state_id', ['' => __('Select State')] + $states, $state_id, array('id' => $new_state_id, 'class' => 'form-control'));
        echo $dd;
    }

    public function filterLangCities(Request $request)
    {
        $state_id = $request->input('state_id');
        $city_id = $request->input('city_id');
        $cities = DataArrayHelper::langCitiesArray($state_id);

        $dd = Form::select('city_id', ['' => 'Select City'] + $cities, $city_id, array('id' => 'city_id', 'class' => 'form-control'));
        echo $dd;
    }

    /*     * ***************************************** */

    public function filterStates(Request $request)
    {
        $country_id = $request->input('country_id');
        $state_id = $request->input('state_id');
        $new_state_id = $request->input('new_state_id', 'state_id');
        $states = DataArrayHelper::langStatesArray($country_id);
        $dd = Form::select('state_id[]', ['' => __('Select State')] + $states, $state_id, array('id' => $new_state_id, 'class' => 'form-control'));
        echo $dd;
    }

    public function filterCities(Request $request)
    {
        $state_id = $request->input('state_id');
        $city_id = $request->input('city_id');
        $cities = DataArrayHelper::langCitiesArray($state_id);

        $dd = Form::select('city_id[]', ['' => 'Select City'] + $cities, $city_id, array('id' => 'city_id', 'class' => 'form-control'));
        echo $dd;
    }

    /*     * ***************************************** */

    public function filterDegreeTypes(Request $request)
    {
        $degree_level_id = $request->input('degree_level_id');
        $degree_type_id = $request->input('degree_type_id');

        $degreeTypes = DataArrayHelper::langDegreeTypesArray($degree_level_id);

        $dd = Form::select('degree_type_id', ['' => 'Select degree type'] + $degreeTypes, $degree_type_id, array('id' => 'degree_type_id', 'class' => 'form-control'));
        echo $dd;
    }
    
    
    public function filterEducation(Request $request)
    
    {
    
    
    
        $states = DB::table("courses")
        ->where("education_id",$request->degree)
        ->get();
        
        
   
        return response()->json($states);
        
    }    
    
    
    
    public function filterEducation1(Request $request)
    {
    return "hello";
    
    }
    
    
    public function filterSpecs(Request $request)
    
    
    {
    
    
    
    $specs=DB::table("specs")->where("course_id",$request->course)->get();
    
    return response()->json($specs);
    
    
    }
    
    function fetchadmin(Request $request)
    {
     if($request->get('query'))
     {
      $query = $request->get('query');
  
      $data = DB::table('job_skills')
        ->where('job_skill', 'LIKE', "%{$query}%")
        ->get();
        // $data[] =$data;
        // return response()->json($data);
        // $array = (array) $query;
        // $data = array_merge($array,$data);
        // return response()->json($data);
        return response()->json(['data'=> $data, 'query'=>$query]);
    //   $output = '<ul class="dropdown-menu" style="display:block; position:relative">';
    //   foreach($data as $row)
    //   {
    //    $output .= '
    //    <li><a href="#">'.$row->job_skill.'</a></li>
    //    ';
    //   }
    //   $output .= '</ul>';
    //   echo $output;
    echo $data;
     }
    }
    

    public function ajax(Request $request)
    {
        return dd('hello');
    }

}
