<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MxpMenuTemp extends Model
{
    protected $table = "mxp_menu_temp";

    protected $fillable = [
    'name', 'route_name', 'description', 'icon', 'parent_id', 'is_active', 'order_id', 'created_at', 'updated_at'
    ];
}


