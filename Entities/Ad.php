<?php namespace Modules\Adsense\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Modules\Media\Support\Traits\MediaRelation;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\App;

class Ad extends Model
{
    use Translatable, MediaRelation;

    public $translatedAttributes = [
        'title',
        'uri',
        'url',
        'active',
        'custom_html',
    ];

    protected $fillable = [
        'space_id',
        'position',
        'target',
        'title',
        'uri',
        'url',
        'active',
        'external_image_url',
        'custom_html',
    ];
    protected $table = 'adsense__ads';

    /**
     * @var string
     */
    private $linkUrl;

    /**
     * @var string
     */
    private $imageUrl;

    public function space()
    {
        return $this->belongsTo(Space::class);
    }

    public function stat()
    {
        return $this->hasMany(Stat::class);
    }

    /**
     * returns space image src
     * @return string|null full image path if image exists or null if no image is set
     */
    public function getImageUrl()
    {
        if($this->imageUrl === null) {
            if($this->custom_html){
                $this->imageUrl=$this->custom_html;
            }
        elseif (isset($this->files[0]) && !empty($this->files[0]->path)) {
                $this->imageUrl = $this->filesByZone('adImage')->first()->path_string;
            }
            elseif (!empty($this->external_image_url)) {
                $this->imageUrl = $this->external_image_url;
            }
        }

        return $this->imageUrl;
    }


    /**
     * returns space link URL
     * @return string|null
     */
    public function getLinkUrl()
    {
        if ($this->linkUrl === null) {
            if (!empty($this->url)) {
                $this->linkUrl = $this->url;
            } elseif (!empty($this->uri)) {
                $this->linkUrl = '/' . locale() . '/' . $this->uri;
            } elseif (!empty($this->page)) {
                $this->linkUrl = route('page', ['uri' => $this->page->slug]);
            }
        }

        return $this->linkUrl;
    }
}
