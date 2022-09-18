<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MonitorResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'manufacturer' => $this->manufacturer,
            'model' => $this->model,
            'disp_code' => $this->disp_code,
            'service_tag' => $this->service_tag,
            'serial' => $this->serial,
            'workspace_id' => $this->workspace_id
        ];
    }

}
