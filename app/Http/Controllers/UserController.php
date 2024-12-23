<?php

namespace App\Http\Controllers;
use App\Models\Tracking;
use Illuminate\Http\Request;
use App\Models\Users;
use Illuminate\Support\Facades\DB;
class UserController extends Controller
{
    public function loginUserWeb(Request $request){
        $username = $request->username;
        $password = _md5($request->password);

        $count = Users::where('username', $username)->where('password', $password)->count();

        $result['result'] = false;
        if ($count > 0) {
            $data =  $data= DB::table('users')
                                ->where('username',$username)
                                ->where('password',$password)
                                ->get();
            $id_user =$data[0]->{'id'};

            session(['users' => true]);
            session(['id_user' => $id_user]);
            $result['result'] = true;
        }
        return json_encode($result);
    }

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

    public function loadAllData(Request $request){
        $id_user = $request->session()->get('id_user');
        $data= DB::table('view_tracking')
            ->where('id_user',$id_user)
            ->orderBy('id', 'desc')
            ->get();
        return json_encode($data);
    }

    public function userLoadMap(Request $request){
        $id_user = $request->session()->get('id_user');
        $data= DB::table('view_tracking')
                    ->where('id_user',$id_user)
                    ->orderBy('id', 'desc')
                    ->first();
        return json_encode($data);
    }
}
