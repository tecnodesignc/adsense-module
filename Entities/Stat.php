<?php

namespace Modules\Adsense\Entities;

use Illuminate\Database\Eloquent\Model;

class Stat extends Model
{

    protected $table = 'adsense__stats';
    protected $fillable = ['impression', 'click','ad_id'];


    public function space()
    {
        return $this->belongsTo(Ad::class);
    }
}
