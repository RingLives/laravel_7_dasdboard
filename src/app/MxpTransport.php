<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MxpTransport extends Model
{
    protected $table = "mxp_transports";

	protected $fillable = [
	'transport_name','transport_number','transport_date','invoice_id','product_id','company_id','group_id','user_id','is_deleted'
    ];
}
