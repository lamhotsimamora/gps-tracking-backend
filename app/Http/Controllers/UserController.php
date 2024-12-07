<?php

namespace App\Http\Controllers;
use App\Models\Tracking;
use Illuminate\Http\Request;
use App\Models\Users;
use Illuminate\Support\Facades\DB;
class UserController extends Controller
{
    public function loginUserAndroid(Request $request){
        $username = $request->username;
        $password = _md5($request->password);

        $count = Users::where('username', $username)->where('password', $password)->count();

        $result['result'] = false;
        if ($count > 0) {
           $data =  DB::table('users')
                    ->where('username', $username)
                    ->where('password', $password)
                    ->get();

           
            $result['result'] = true;
            $result['data'] =  $data ;
        }
        return json_encode($result);
    }

    public function addCoordinate(Request $request)
    {
        $latitude = $request->latitude;
        $longitude = $request->longitude;
        $id_user = $request->id_user;

        $tracking = new Tracking;

        $tracking->latitude = $latitude;
        $tracking->longitude = $longitude;
        $tracking->date = date('Y-m-d');
        $tracking->time =  date('H:i:s');
        $tracking->id_user = $id_user;

        if ( $latitude!=null ||  $longitude!=null ){
            $tracking->save();
            return json_encode(array('result'=>true));
        }else{
            return json_encode(array('result'=>false));
        }
       
    }
}
