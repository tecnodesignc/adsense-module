<?php
namespace Modules\Adsense\Entities;

use Illuminate\Database\Eloquent\Model;

class Space extends Model
{
    protected $fillable = [
        'name',
        'system_name',
        'active'
    ];

    protected $table = 'adsense__spaces';

    public function ads()
    {
        return $this->hasMany(Ad::class)->orderBy('position', 'asc');
    }
}
