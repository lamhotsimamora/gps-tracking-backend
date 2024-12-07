<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tracking;
use App\Models\Admins;
use App\Models\Users;
use App\Models\ViewTracking;
use Illuminate\Support\Facades\DB;
class AdminController extends Controller
{
    public function addUser(Request $request){
        $username = $request->username;
        $password = $request->password;

        $user = new Users;

        $user->username = $username;
        $user->password = _md5($password);

        $user->save();

        return json_encode(array('result'=>true));
    }

    public function loadDataMap(Request $request)
    {       
            $id_user = $request->id_user;

            $data= DB::table('view_tracking')
            ->where('id_user',$id_user)
            ->orderBy('id', 'desc')
            ->first();
            return json_encode(array('result'=>true, 'data'=>$data));
    }

    public function loadAllDataMap(){
        $data= DB::table('view_tracking')
        ->orderBy('id', 'desc')
        ->get();
        return json_encode($data);
    }

    public function loadAllUser(){
        $data= DB::table('users')
        ->orderBy('id', 'desc')
        ->get();
        return json_encode($data);
    }

    public function deleteTracking(Request $request){
        $id = $request->id;

        $tracking = Tracking::find($id);

        return $tracking->delete();
    }

    public function deleteUser(Request $request){
        $id = $request->id;

        $users = Users::find($id);

        return $users->delete();
    }

    public function loginAdmin(Request $request){
        $username = $request->username;
        $password = _md5($request->password);

        $count = Admins::where('username', $username)->where('password', $password)->count();

        $result['result'] = false;
        if ($count > 0) {
            session(['admins' => true]);
            $result['result'] = true;
        }
        return json_encode($result);
    }
}
