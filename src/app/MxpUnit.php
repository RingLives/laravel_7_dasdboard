<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MxpUnit extends Model
{
    protected $table = "mxp_unit";

	protected $fillable = [
	'name', 'company_id', 'com_group_id', 'user_id', 'is_active', 'is_deleted'
    ];
}
