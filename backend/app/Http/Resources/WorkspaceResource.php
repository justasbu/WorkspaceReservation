<?php

namespace App\Http\Resources;

use App\Models\Reservation;
use App\Models\Zone;
use Illuminate\Http\Resources\Json\JsonResource;

class WorkspaceResource extends JsonResource
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
            'tableNumber' => $this->tableNumber,
            'monitorsCount' => $this->monitorsCount,
            'mount' => $this->mount,
            'dockingStation' => $this->dockingStation,
            'headPhones' => $this->headPhones,
            'status' => $this->status,
            'tableType' => $this->tableType,
            'zone_id' => $this->zone_id,
            'reservations' => ReservationResource::collection($this->reservations)
        ];
    }
}
