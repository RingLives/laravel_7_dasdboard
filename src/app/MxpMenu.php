<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MxpMenu extends Model
{
    protected $table = "mxp_menu";

    protected $fillable = [
    'menu_id', 'name', 'route_name', 'description', 'parent_id', 'is_active', 'order', 'created_at', 'updated_at'
    ];
}
