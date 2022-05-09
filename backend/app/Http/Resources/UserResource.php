<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'email' => $this->email,
            'role' => $this->role,
            'created_at' => date("m-d-Y H:i", strtotime($this->created_at)),
            'updated_at' => date("m-d-Y H:i", strtotime($this->updated_at)),
            'reservations' => ReservationResource::collection($this->reservations),

        ];
    }
}
