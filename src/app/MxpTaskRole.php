<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MxpTaskRole extends Model
{
    protected $table = 'mxp_task_role';
    protected $primaryKey = 'id_mxp_task_role';

    protected $fillable = [
		'role_id',
		'task'
	];
}
