<?php

namespace App\Services;

use App\Http\Requests\StoreZoneRequest;
use App\Http\Resources\ZoneResource;
use App\Models\Workspace;
use App\Models\Zone;

class ZoneService
{
    protected $request;
    protected $zone;
    protected $workspace;

    public function __construct(StoreZoneRequest $request = null, Zone $zone = null, Workspace $workspace = null)
    {
        $this->request = $request;
        $this->zone = $zone;
        $this->workspace = $workspace;
    }

    public function update()
    {
        $this->updateZone();

    }

    public function create()
    {
        $this->storeZone();
    }

    public function delete()
    {
        $this->deleteZone();
    }

    public function zone()
    {
        return ZoneResource::make($this->zone);
    }

    public function storeZone()
    {
        $this->zone = new Zone();

        $this->zone->city = $this->request->city;
        $this->zone->name = $this->request->name;
        $this->zone->description = $this->request->description;

        $this->zone->save();
    }

    protected function updateZone()
    {
        $this->zone->update($this->request->all());
        $this->zone->save();
    }

    protected function deleteZone()
    {
        $this->zone->delete($this->request);
    }

}
