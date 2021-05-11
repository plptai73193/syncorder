<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use App\Libs\Cafe24\Cafe24Token;
use App\Services\Nhanhvn\Product as Nhanhvn_Product;
use App\Models\User;
use App\Libs\Nhanhvn\NhanhService;

class UserController extends Controller
{
    public function index(Request $request){
        $api_username = $request->input('api_username');
        $secret_key = $request->input('secret_key');
        $users = DB::table('users')->where([
            "api_username" => $api_username,
        ])->get()->toArray();

        $insert_user = [
            'cafe24_mall_id' => $_REQUEST["cafe24_mall_id"],
            "api_username" => $api_username,
            "secret_key" => $secret_key,
            "created_at" => date("Y-m-d H:i:s",time()),
            "updated_at" => date("Y-m-d H:i:s",time()),
        ];

        if(empty($users)){

            $nhanh_product_obj = new Nhanhvn_Product($api_username, $secret_key);
            $_param = [];
            $_get_products = $nhanh_product_obj->getProducts($_param);
            if($_get_products['success']){
                echo 'success';
            } else {
                echo 'error';
            }
            
        } else {

            // User::where('api_username', $api_username)->update($insert_user);

        }

    }
}