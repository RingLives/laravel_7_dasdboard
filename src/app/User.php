<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    //use Notifiable;

    protected $table ="mxp_users";

    protected $primaryKey = 'user_id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // protected $fillable = [
    //     'name', 'email', 'password',
    // ];

    protected $fillable = [
        'user_id', 'first_name', 'middle_name', 'last_name', 'type', 'group_id', 'company_id', 'email', 'password', 'phone_no', 'remember_token', 'is_active', 'user_role_id','address'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'updated_at', 'created_at',
    ];
}
