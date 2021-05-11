<?php

namespace App\Services\Nhanhvn;

use App\Libs\Nhanhvn\NhanhService;
use App\Services\Nhanhvn\AbstractClass\NhanhServiceAbstract;

class Order extends NhanhServiceAbstract {
    
        
    /**
     * Create order
     *
     * @param array $param
     *
     * @return array $result
     */
    public function createOrder($param){
        $result = [
            "success" => false,
            "data" => [],
            "msg" => [],
        ];
        $storeId = null;
        
        $service = $this->nhanhService;
        $response = $service->sendRequest(NhanhService::URI_ORDER_ADD, $param, $storeId);
        
        if ($response->code) {
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

    
    /**
     * Update order
     *
     * @param array $param
     *
     * @return array $result
     */
    public function updateOrder($param){
        $result = [
            "success" => false,
            "data" => [],
            "msg" => [],
        ];
        
        $storeId = null;

        $service = $this->nhanhService;
        $response = $service->sendRequest(NhanhService::URI_ORDER_UPDATE, $param, $storeId);
        

        if ($response->code) {
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