<?php

namespace App\Services\Nhanhvn\AbstractClass;

use App\Libs\Nhanhvn\NhanhService;

abstract class NhanhServiceAbstract {
    protected $nhanhService;
    
    public function __construct($apiUsername, $secretKey){
        $this->nhanhService = new NhanhService();

        $this->nhanhService->setApiUsername($apiUsername);

        $this->nhanhService->setSecretKey($secretKey);
    }
    
}