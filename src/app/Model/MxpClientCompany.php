<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class MxpClientCompany extends Model
{
    protected $table = "mxp_users";
    protected $primaryKey = "user_id";    

	protected $fillable = [
	'user_id','first_name', 'type', 'email', 'phone_no', 'address', 'is_active', 'group_id', 'company_id'
	];
}
