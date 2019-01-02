<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MxpTranslationKey extends Model
{
    const DEFAULT_ACTIVE = 0;

    protected $attributes = [
        'is_active' => self::DEFAULT_ACTIVE,
    ];

    protected $table ="mxp_translation_keys";

    protected $primaryKey = 'translation_key_id';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'translation_key', 'is_active',
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
