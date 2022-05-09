<?php

namespace App\Http\Controllers;

use App\Http\Resources\ReservationResource;
use App\Models\Reservation;
use App\Http\Requests\StoreReservationRequest;
use App\Http\Requests\UpdateReservationRequest;
use App\Services\ReservationService;
use App\Services\WorkspaceService;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $reservations = Reservation::all();

        return ReservationResource::collection($reservations);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreReservationRequest $request
     * @return ReservationResource
     */
    public function store(StoreReservationRequest $request)
    {
        $service = new ReservationService($request);
        $service->create();

        return $service->reservation();
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Reservation $reservation
     * @return ReservationResource
     */
    public function show($id)
    {
        $reservations = Reservation::all();
        $reservation = $reservations->find($id);

        return \App\Http\Resources\ReservationResource::make($reservation);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateReservationRequest $request
     * @param \App\Models\Reservation $reservation
     * @return ReservationResource
     */
    public function update(StoreReservationRequest $request, Reservation $reservation)
    {
        $service = new ReservationService($request, $reservation);
        $service->update();
        return $service->reservation();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Reservation $reservation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reservation $reservation)
    {
        $reservation->delete();
    }


}
