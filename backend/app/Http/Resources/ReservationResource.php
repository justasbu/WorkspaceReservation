<?php

namespace App\Http\Resources;

use App\Models\Reservation;
use App\Models\Workspace;
use Illuminate\Http\Resources\Json\JsonResource;
use function Symfony\Component\Translation\t;

class ReservationResource extends JsonResource
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
            'user_id' => $this->user_id,
            'dateFrom' => $this->dateFrom,
            'dateTo' => $this->dateTo,
            'created_at' => $this->created_at,
            'workspace_id' => $this->workspace_id,
        ];
    }

}
