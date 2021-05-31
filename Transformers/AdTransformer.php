<?php

namespace Modules\Adsense\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\User\Transformers\UserProfileTransformer;

class AdTransformer extends JsonResource
{
    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'space_id'=>$this->when($this->spaceId,$this->spaceId),
            'page_id'=>$this->when($this->pageId,$this->pageId),
            'title' => $this->when($this->title,$this->title),
            'caption' => $this->when($this->caption,$this->caption),
            'customHtml' => $this->when($this->custom_html,$this->custom_html),
            'imageUrl' => $this->getImageUrl(),
            'position'=>$this->when($this->position,$this->position),
            'target'=>$this->when($this->target,$this->target),
            'uri'=>$this->when($this->uri,$this->uri),
            'url'=>$this->when($this->url,$this->url),
            'active'=>$this->active,
            'external_image_url'=>$this->when($this->externalImageUrl,$this->externalImageUrl),


        ];

        $filter = json_decode($request->filter);
        if (isset($filter->allTranslations) && $filter->allTranslations) {
            // Get langs avaliables
            $languages = \LaravelLocalization::getSupportedLocales();

            foreach ($languages as $lang => $value) {
                $data[$lang]['title'] = $this->hasTranslation($lang) ?
                    $this->translate("$lang")['title'] : '';
                $data[$lang]['caption'] = $this->hasTranslation($lang) ?
                    $this->translate("$lang")['caption'] : '';
                $data[$lang]['uri'] = $this->hasTranslation($lang) ?
                    $this->translate("$lang")['uri'] ?? '' : '';
                $data[$lang]['url'] = $this->hasTranslation($lang) ?
                    $this->translate("$lang")['url'] : '';
                $data[$lang]['active'] = $this->hasTranslation($lang) ?
                    $this->translate("$lang")['active'] : '';
                $data[$lang]['custom_html'] = $this->hasTranslation($lang) ?
                    $this->translate("$lang")['custom_html'] : '';
            }
        }

        return $data;

    }
}
