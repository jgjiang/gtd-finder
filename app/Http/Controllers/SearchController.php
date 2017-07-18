<?php

namespace App\Http\Controllers;

use App\HCG;
use App\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;



class SearchController extends Controller
{

    public function show(){

        $keyword = Input::get('keyword');

        $msg = 'No Details found. Try to search again!';
        $countries = array_unique(DB::table('patient')->pluck('nationality')->all()); // array_unique 去重数据

        $country_data = [];
        foreach ($countries as $key => $country){
            array_push($country_data,array('id'=>$country));
        }

        $areas = json_encode($country_data);

        if ($keyword != '') {
            $results = DB::table('patient')
                ->join('hcg', 'patient.pid', '=', 'hcg.pid')
                -> where('patient.pid',$keyword)
                ->orWhere ( 'hcg_value', 'LIKE', '%' . $keyword. '%' )
                -> select('*')
                ->paginate(6);

            $results->appends (array ('keyword' => $keyword));

            if (count($results)>0){
                return view('index',['results'=>$results,'areas'=>$areas ]);
            }


        }

        return view('index',['msg'=>$msg,'areas'=>$areas]);

    }

    public function displayMap(){

        $countries = array_unique(DB::table('patient')->pluck('nationality')->all()); // array_unique 去重数据

        $country_data = [];
        foreach ($countries as $key => $country){
           array_push($country_data,array('id'=>$country));
        }

        $areas = json_encode($country_data);

        return view('index',['areas'=>$areas]);
    }
}
