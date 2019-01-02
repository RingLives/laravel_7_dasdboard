<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MxpTranslation extends Model
{

    const DEFAULT_TRANS = '';
    const DEFAULT_ACTIVE = 0;

    protected $table ="mxp_translations";

    protected $primaryKey = 'translation_id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $attributes = [
            'translation' => self::DEFAULT_TRANS,
            'is_active' => self::DEFAULT_ACTIVE,
        ];

    protected $fillable = [
        'translation', 'translation_key_id','lan_code','is_active',
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
