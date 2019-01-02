<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mxp_role extends Model
{
    protected $table = "mxp_role";

	protected $fillable = [
	'name', 'company_id', 'cm_group_id', 'cm_super_admin_id', 'is_active'
    ];
}
