<?php
namespace App\Services\Cafe24\Mall;

use App\Services\BaseService;
use App\Models\Mall;
use App\Facades\Cafe24\Cafe24Api;

class MallService extends BaseService {

    /**
     * Use to create mall
     *
     * @param array $params
     * @param string $access_token
     *
     * @return array $result
     */
    public function createMall(array $params, $access_token){
        $result = [
            "success" => false,
            "data" => [],
            "errors" => [],
            "msg" => "",
        ];

        $cafe_mall_id = $params["cafe_mall_id"];
        $refresh_token = $params["refresh_token"];

        $endpoint_shops = "shops";
        $cf_params = [];
        $res_data = Cafe24Api::get($cafe_mall_id, $access_token, $endpoint_shops, $cf_params);
        
        if ($res_data["success"] == false) {
            $result = $res_data;
            return $result;
        } else {
            $data = $res_data["data"];
            $shops = $data->shops;
            if (count($shops) > 0) {
                foreach ($shops as $_shop) {
                    

                    //get default shop
                    if ($_shop->default == "T") {
                        $shop_name = $_shop->shop_name;
                        $mall_url = !empty($_shop->primary_domain) ? $_shop->primary_domain : $_shop->base_domain;
                        $insert_shop = [
                            "cafe_mall_id" => $cafe_mall_id,
                            "mall_name" => $shop_name,
                            "mall_url" => $mall_url,
                            "access_token" => $access_token,
                            "refresh_token" => $refresh_token,
                            "created_at" => time(),
                            "updated_at" => time(),
                        ];

                        //save Mall to database
                        $mall = Mall::create($insert_shop);
                        $result["data"] = $mall;
                        break;
                    }
                }
                $result["success"] = true;
            } else {
                $result["success"] = false;
                $result["msg"] = "Cafe24 Error!";
                return $result;
            }
        }
        return $result;
    }

    
    /**
     * Get mall and create if not exist
     *
     * @param array $params
     * @param string $access_token
     *
     * @return array $result
     */
    public function getMallAndCreate($params, $access_token){
        try {
            $result = [
                "success" => false,
                "data" => [
                    "is_first" => false,
                ],
                "msg" => "",
            ];
            
            
            $mall = $this->getMall($params);

            /*********** create mall if not existed ***********/
            if (empty($mall)) {
                if (empty($access_token)) {
                    $result["success"] = false;
                    $result["msg"] = "access_token is null";
                    return $result;
                } else {
                    $insert_mall = $this->createMall($params, $access_token);
                    if ($insert_mall["success"] === true) {
                        $mall = $insert_mall["data"];
                        $result["data"]["is_first"] = true;
                    } else {
                        $result = $insert_mall;
                        return $result;
                    }
                }
            }

            $result["success"] = true;
            $result["data"]["mall"] = $mall;
            return $result;

        } catch (Exception $e) {
            $this->getError($e);
        }
            
    }


    /**
     * Get malls
     *
     * @param array $params
     *
     * @return array $malls
     */
    public function getMalls($params){
        try {
            $mall_builder = $this->getMallQueryBuilder($params);
            $malls = $mall_builder->get();
            return $malls;

        } catch (Exception $e) {
            $this->getError($e);
        }
    }
    
    
    /**
     * Create Query_Builder to get malls
     *
     * @param array $params
     *
     * @return object $builder
     */
    public function getMallQueryBuilder($params){
        try {
            /*********** parammeter ***********/
            $cafe_mall_id = @$params["cafe_mall_id"];
            $mall_id = @$params["mall_id"];
            $whereRaw = @$params["whereRaw"];
            $columns = @$params["columns"];
            

            $result = [
                "success" => false,
                "data" => [
                    "is_first" => false,
                ],
                "msg" => "",
            ];
            
            $builder = Mall::query();

            /*********** search conditions  ***********/
            $conditions = [];
            
            /* search by cafe24 mall_id */
            if (!empty($cafe_mall_id)) {
                $conditions = ["cafe_mall_id" => $cafe_mall_id];
            }

            /* search by mall_id */
            if (!empty($mall_id)) {
                $conditions = ["id" => $mall_id];
            }
            $builder = $builder->where($conditions);


            /* search by dynamic conditions */
            if (!empty($whereRaw)) {
                $builder = $builder->whereRaw($whereRaw);
            }
            
            /* get columns  */
            if (!empty($columns)) {
                $builder->select($columns);
            }

            return $builder;

        } catch (Exception $e) {
            $this->getError($e);
        }
    }


	/**
     * Get mall
     *
     * @param array $params
     *
     * @return object $mall
     */
    public function getMall($params){
        try {
            $mall_builder = $this->getMallQueryBuilder($params);
            $mall = $mall_builder->first();
            return $mall;

        } catch (Exception $e) {
            $this->getError($e);
        }
    }

        
    /**
     * updateMall
     *
     * @param array $params
     *
     * @return void
     */
    public function updateMall($params){
        
    }
}