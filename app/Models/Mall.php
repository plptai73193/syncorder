<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\BaseModel;
use App\Models\Log\MallAccessLog;

class Mall extends BaseModel
{
    protected $fillable = [
        "cafe_mall_id",
        "mall_name",
        "mall_url",
        "is_app_deleted",
        "is_app_expired",
        "app_expire_date",
        "access_token",
        "refresh_token",
        "created_at",
        "updated_at",
    ];

    public function accessLogs(){
        $this->hasMany(MallAccessLog::class);
    }
}
