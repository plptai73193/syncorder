<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\BaseModel;
use App\Models\Log\MallAccessLog;

class User extends BaseModel
{
    protected $fillable = [
        "cafe24_mall_id",
        "api_username",
        "secret_key",
        "created_at",
        "updated_at",
    ];
}
