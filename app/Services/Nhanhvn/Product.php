<?php

namespace App\Services\Nhanhvn;

use App\Libs\Nhanhvn\NhanhService;
use App\Services\Nhanhvn\AbstractClass\NhanhServiceAbstract;

class Product extends NhanhServiceAbstract {
    
        
    /**
     * Get product list
     *
     * @param array $param
     *
     * @return array $result
     */
    public function getProducts($param){
        $result = [
            "success" => false,
            "data" => [],
            "msg" => [],
        ];

        $storeId = null;
        $service = $this->nhanhService;

        
        $api_params = [];
        if (!empty($param["page"])) {
            $api_params['page'] = $param["page"];
        }
        if (!empty($param["icpp"])) {
            $api_params['icpp'] = $param["limit"];
        }
        if (!empty($param["status"])) {
            $api_params['status'] = $param["status"];
        }

        $response = $service->sendRequest(NhanhService::URI_GET_PRODUCT_SEARCH, $api_params, $storeId);

        if($response->code) {
            $result["success"] = true;
            $result["data"] = $response->data;
        } else {
            $result["success"] = false;
        }
        
        if(isset($response->messages)) {
            foreach ($response->messages as $message) {
                $result["msg"][] = $message;
            }
        }

        return $result;
    }
}