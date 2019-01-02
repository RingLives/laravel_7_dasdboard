<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    const DEFAULT_ACTIVE = 0;
    
    protected $attributes = [
        'is_active' => self::DEFAULT_ACTIVE,
    ];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
   
    protected $fillable = [
        'lan_name', 'lan_code', 'is_active',
    ];

    protected $table = "mxp_languages";

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'updated_at', 'created_at',
    ];
}
