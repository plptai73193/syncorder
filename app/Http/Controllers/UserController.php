<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use App\Libs\Cafe24\Cafe24Token;
use App\Services\Nhanhvn\Verify as Nhanhvn_Verify;
use App\Models\User;
use App\Libs\Nhanhvn\NhanhService;

class UserController extends Controller
{
    public function index(Request $request){
        dd($request->all());
        $api_username = $request->input('api_username');
        $secret_key = $request->input('secret_key');
        
        $mall_param = [
            "version" => '1.0',
            "apiUsername" => $api_username,
            "data" => '{}',
            "checksum" => md5(md5($secret_key . '{}') . '{}')
        ];

        
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://graph.nhanh.vn/api/shipping/location",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_POSTFIELDS => $mall_param,
        ));

        
        $response_curl = json_decode(curl_exec($curl), true);
        $err_curl = curl_error($curl);
        curl_close($curl);

        if($response_curl['code']){

            $users = DB::table('users')->where([
                "cafe24_mall_id" => $mall_id,
            ])->get()->toArray();

            $insert_user = [
                'cafe24_mall_id'        =>      $mall_id,
                "api_username"          =>      $api_username,
                "secret_key"            =>      $secret_key,
                "created_at"            =>      date("Y-m-d H:i:s",time()),
                "updated_at"            =>      date("Y-m-d H:i:s",time()),
            ];

            if(empty($users)){
                User::create($insert_user);
            } else {
                User::where('cafe24_mall_id', $mall_id)->update($insert_user);
            }
            echo '<h1>Your order is now synced to nhanh.vn</h1><p><a href="/login">Log out</a></p>';
        } else {
            echo '<h1>Account does not exist</h1><p><a href="/login">Back</a></p>';
        }
    }
}