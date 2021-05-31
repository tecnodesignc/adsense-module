<?php

namespace Modules\Adsense\Presenters;

interface AdsensePresenterInterface
{
    /**
     * @param string $spaceName
     * @return string rendered space
     */
    public function render($spaceName);
}
