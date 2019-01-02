<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MxpUserRoleMenu extends Model
{
    //
    protected $table = "mxp_user_role_menu";

    protected $primaryKey = 'role_menu_id';

    protected $fillable = [
    	'role_menu_id', 'role_id', 'menu_id', 'is_active'
    ];
}
