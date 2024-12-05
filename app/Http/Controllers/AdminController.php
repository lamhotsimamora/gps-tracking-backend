<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tracking;
use App\Models\ViewTracking;

class AdminController extends Controller
{
    public function loadDataMap()
    {
        $data = Tracking::where('date', date('Y-m-d'))->get();
        if (count($data)>0){
            return json_encode(array('result'=>true, 'data'=>$data[0]));
        }else{
            return json_encode(array('result'=>false));;
        }
    }

    public function loadAllDataMap(){
        return json_encode(ViewTracking::all());
    }

    public function deleteTracking(Request $request){
        $id = $request->id;

        $tracking = Tracking::find($id);

        return $tracking->delete();
    }
}
