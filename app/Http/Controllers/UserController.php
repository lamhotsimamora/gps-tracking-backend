<?php

namespace App\Http\Controllers;
use App\Models\Tracking;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function addCoordinate(Request $request)
    {
        $latitude = $request->latitude;
        $longitude = $request->longitude;

        $tracking = new Tracking;

        $tracking->latitude = $latitude;
        $tracking->longitude = $longitude;
        $tracking->date = date('Y-m-d');
        $tracking->time =  date('H:i:s');
        $tracking->id_user = 1;

        if ( $latitude!=null ||  $longitude!=null ){
            $tracking->save();
            return json_encode(array('result'=>true));
        }else{
            return json_encode(array('result'=>false));
        }
       
    }
}
