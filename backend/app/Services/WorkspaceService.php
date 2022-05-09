<?php

namespace App\Services;

use App\Http\Requests\StoreWorkspaceRequest;
use App\Http\Resources\WorkspaceResource;
use App\Models\Workspace;

class WorkspaceService
{

    protected $request;
    protected $workspace;
    protected $zone;
    protected $reservation;

    public function __construct(StoreWorkspaceRequest $request = null, $workspace = null, $reservation = null, $zone = 1)
    {
        $this->request = $request;
        $this->workspace = $workspace;
        $this->reservation = $reservation;
        $this->zone = $zone;
    }

    public function update()
    {
        $this->updateWorkspace();
    }

    public function create()
    {
        $this->storeWorkspace();
    }

    public function delete()
    {
        $this->deleteWorkspace();
    }

    public function workspace()
    {
        return WorkspaceResource::make($this->workspace);
    }

    protected function storeWorkspace()
    {
        $this->workspace = new Workspace();


        $this->workspace->id = $this->request->id;
        $this->workspace->tableNumber = $this->request->tableNumber;
        $this->workspace->monitorsCount = $this->request->monitorsCount;
        $this->workspace->mount = $this->request->mount;
        $this->workspace->dockingStation = $this->request->dockingStation;
        $this->workspace->headPhones = $this->request->headPhones;
        $this->workspace->tableType = $this->request->tableType;
        $this->workspace->zone_id = $this->request->zone_id;

        $this->workspace->save();

    }

    protected function updateWorkspace()
    {
        $this->workspace->update($this->request->all());
        $this->workspace->save();
    }

    protected function deleteWorkspace()
    {
        $this->workspace->zones()->detach();
        $this->workspace->delete($this->request);
    }


}
