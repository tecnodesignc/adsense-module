<?php namespace Modules\Adsense\Services;

use Illuminate\Support\Facades\URL;

class SpaceRenderer
{
    /**
     * @var int Id of the space to render
     */
    protected $spaceId;
    /**
     * @var string
     */
    private $startTag = '<div class="dd">';
    /**
     * @var string
     */
    private $endTag = '</div>';
    /**
     * @var string
     */
    private $ads = '';

    /**
     * @param Space $space
     * @param $ads
     * @return string
     */
    public function renderForSpace($space, $ads)
    {
        $this->spaceId = $space->id;

        $this->ads .= $this->startTag;
        $this->generateHtmlFor($ads);
        $this->ads .= $this->endTag;

        return $this->ads;
    }

    /**
     * Generate the html for the given items
     * @param $ads
     */
    private function generateHtmlFor($ads)
    {
        $this->ads .= '<ol class="dd-list">';
        foreach ($ads as $ad) {
            $this->ads .= "<li class='dd-item' data-id='{$ad->id}'>";
            $editLink = URL::route('admin.adsense.ad.edit', [$this->spaceId, $ad->id]);
            $this->ads .= <<<HTML
<div class="btn-group" role="group" aria-label="Action buttons" style="display: inline">
    <a class="btn btn-sm btn-info" style="float:left;" href="{$editLink}">
        <i class="fa fa-pencil"></i>
    </a>
    <a class="btn btn-sm btn-danger jsDeleteAd" style="float:left; margin-right: 15px;" data-item-id="{$ad->id}">
       <i class="fa fa-times"></i>
    </a>
</div>
HTML;
            $this->ads .= "<div class='dd-handle'>{$ad->title}</div>";
            $this->ads .= "<div><img class='img-responsive' src='".$ad->getImageUrl()."' /></div>";
            $this->ads .= '</li>';
        }
        $this->ads .= '</ol>';
    }

}
