<?php

namespace Modules\Adsense\Entities;

use Illuminate\Database\Eloquent\Model;

class AdTranslation extends Model
{
    public $fillable = [
        'title',
        'uri',
        'url',
        'active',
        'custom_html'
    ];

    protected $table = 'adsense__ad_translations';
}
