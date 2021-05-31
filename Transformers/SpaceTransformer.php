<?php

namespace Modules\Adsense\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;


class SpaceTransformer extends JsonResource
{
  public function toArray($request)
  {


      $data = [
          'id' => $this->when($this->id, $this->id),
          'name'=>$this->when($this->name, $this->name),
          'system_name'=>$this->when($this->systemName, $this->systemName),
          'active'=>$this->when($this->active, $this->active)
          ];

      return $data;
  }
}
