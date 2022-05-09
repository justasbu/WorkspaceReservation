<?php

namespace App\Http\Controllers;

use App\Http\Resources\WorkspaceResource;
use App\Http\Resources\ZoneResource;
use App\Models\Workspace;
use App\Models\Zone;
use App\Http\Requests\StoreZoneRequest;
use App\Http\Requests\UpdateZoneRequest;
use App\Services\ZoneService;

class ZoneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $zones = Zone::all();

        return ZoneResource::collection($zones);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreZoneRequest $request
     * @return ZoneResource
     */
    public function store(StoreZoneRequest $request)
    {
        $service = new ZoneService($request);
        $service->create();

        return $service->zone();
    }

    /**
     * Display the specified resource.
     *
     * @return ZoneResource
     */
    public function show($id)
    {
        $zones = Zone::all();
        $zone = $zones->find($id);

        return ZoneResource::make($zone);
    }

    /**
     * @param $id
     */
    public function showWorkspaces($id)
    {
        $zones = Zone::all();
        $zone = $zones->find($id)->workspaces;

        return WorkspaceResource::collection($zone);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  StoreZoneRequest $request
     * @param  Zone             $zone
     * @return ZoneResource
     */
    public function update(StoreZoneRequest $request, Zone $zone): ZoneResource
    {
        $service = new ZoneService($request, $zone);
        $service->update();

        return $service->zone();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Zone $zone
     * @return \Illuminate\Http\Response
     */
    public function destroy(Zone $zone)
    {
        $zone->delete();
    }
}
