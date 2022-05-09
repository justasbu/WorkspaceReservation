<?php

namespace App\Http\Resources;

use App\Models\Workspace;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @param Request $request
 * @return array
 */
class ZoneResource extends JsonResource
{
    /**
     *
     * @param  $request
     * @return array
     */

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'city' => $this->city,
            'description' => $this->description,
            'workspaces' => WorkspaceResource::collection($this->workspaces)

        ];
    }


}
