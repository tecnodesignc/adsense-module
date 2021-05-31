<?php

namespace Modules\Adsense\Events;

use Modules\Adsense\Entities\Ad;
use Modules\Media\Contracts\StoringMedia;

class AdWasCreated implements StoringMedia
{

    /**
     * @var array
     */
    public $data;

    /**
     * @var Ad
     */
    public $ad;


    public function __construct($ad, array $data)
    {
        $this->data = $data;
        $this->ad = $ad;
    }


    /**
     * Return the entity
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getEntity()
    {
        return $this->ad;
    }


    /**
     * Return the ALL data sent
     * @return array
     */
    public function getSubmissionData()
    {
        return $this->data;
    }
}
