<?php

namespace App\Services;

use App\Http\Requests\StoreReservationRequest;
use App\Http\Resources\ReservationResource;
use App\Models\Reservation;
use function Symfony\Component\Translation\t;

class ReservationService
{
    protected $request;
    protected $reservation;
    protected $workspace;

    public function __construct(StoreReservationRequest $request = null, $reservation = null, $workspace = null)
    {
        $this->request = $request;
        $this->reservation = $reservation;
        $this->workspace = $workspace;
    }

    public function update()
    {
        $this->updateReservation();
    }

    public function create()
    {
        $this->storeReservation();

    }

    public function delete()
    {
        $this->deleteReservation();
    }

    public function reservation()
    {
        return ReservationResource::make($this->reservation);
    }

    public function storeReservation()
    {
        $this->reservation = new Reservation();

        $this->reservation->id = $this->request->id;
        $this->reservation->user_id = $this->request->user_id;
        $this->reservation->dateFrom = $this->request->dateFrom;
        $this->reservation->dateTo = $this->request->dateTo;
        $this->reservation->workspace_id = $this->request->workspace_id;


        $this->reservation->save();
    }

    protected function updateReservation()
    {
        $this->reservation->update($this->request->all());
        $this->reservation->save();
    }

    protected function deleteReservation()
    {
        $this->reservation->delete($this->request);
    }


}
