<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MxpCompany extends Model {
	
	protected $table = 'mxp_companies';
	protected $fillable = ['group_id', 'name', 'description', 'address', 'phone', 'is_active'];
}
