<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReservationRequest;
use App\Http\Resources\ReservationResource;
use App\Http\Resources\WorkspaceResource;
use App\Models\Workspace;
use App\Http\Requests\StoreWorkspaceRequest;
use App\Http\Requests\UpdateWorkspaceRequest;
use App\Services\ReservationService;
use App\Services\WorkspaceService;

class WorkspaceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $workspaces = Workspace::all();

        return WorkspaceResource::collection($workspaces);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreWorkspaceRequest $request
     * @return WorkspaceResource
     */
    public function store(StoreWorkspaceRequest $request)
    {
        $service = new WorkspaceService($request);
        $service->create();

        return $service->workspace();
    }

    /**
     * Display the specified resource.
     *
     * @param Workspace $workspace
     * @return WorkspaceResource
     */
    public function show($id)
    {
        $workspaces = Workspace::all();
        $workspace = $workspaces->find($id);

        return \App\Http\Resources\WorkspaceResource::make($workspace);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreReservationRequest $request
     * @return ReservationResource
     */
    public function makeReservation(StoreReservationRequest $request)
    {
        $service = new ReservationService($request);
        $service->create();

        return $service->reservation();
    }


    /**
     * Update the specified resource in storage.
     *
     * @param StoreWorkspaceRequest $request
     * @param Workspace $workspace
     * @return WorkspaceResource
     */
    public function update(StoreWorkspaceRequest $request, Workspace $workspace): WorkspaceResource
    {
        $service = new WorkspaceService($request, $workspace);
        $service->update();
        return $service->workspace();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Workspace $workspace
     * @return \Illuminate\Http\Response
     */
    public function destroy(Workspace $workspace)
    {
        $workspace->delete();
    }


}
