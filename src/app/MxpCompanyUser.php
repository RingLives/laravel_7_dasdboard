<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MxpCompanyUser extends Model
{
    protected $table = "mxp_users";
    protected $primaryKey = "user_id";    

	protected $fillable = [
	'user_id','first_name', 'type', 'email', 'phone_no', 'is_active', 'user_role_id'
	];
}
