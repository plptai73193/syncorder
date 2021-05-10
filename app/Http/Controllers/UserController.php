<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

use App\Models\User;

class UserController extends Controller
{
    public function index(Request $request){
        $api_username = $request->input('api_username');
        $secret_key = $request->input('secret_key');

        $users = DB::table('users')->where([
            "api_username" => $api_username,
        ])->get()->toArray();
        

        $insert_user = [
            "api_username" => $api_username,
            "secret_key" => $secret_key,
            "created_at" => date("Y-m-d H:i:s",time()),
            "updated_at" => date("Y-m-d H:i:s",time()),
        ];


        if(empty($users)){
            User::create($insert_user);
        } else {
            User::where('api_username', $api_username)->update($insert_user);
        }
    }
}