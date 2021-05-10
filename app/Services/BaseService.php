<?php

namespace App\Services;

use Symfony\Component\HttpFoundation\Response;

class BaseService {

    public function __construct(){}

    public function getError(Exception $e) {
        report($e);
        return response()->json([
            "success" => false,
            "code" => Response::HTTP_INTERNAL_SERVER_ERROR,
            "msg" => $e->getMessage(),
        ]);
    }
}
