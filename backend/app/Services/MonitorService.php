<?php

namespace App\Services;

use App\Http\Requests\StoreMonitorRequest;
use App\Http\Resources\MonitorResource;
use App\Models\Monitor;

class MonitorService
{
    protected $request;
    protected $monitor;
    protected $workspace;

    public function __construct(StoreMonitorRequest $request = null, $monitor = null, $workspace = null)
    {
        $this->request = $request;
        $this->monitor = $monitor;
        $this->workspace = $workspace;
    }

    public function update()
    {
        $this->updateMonitor();
    }
    public function create()
    {
        $this->storeMonitor();
    }
    public function delete()
    {
        $this->deleteMonitor();
    }
    public function monitor()
    {
        return MonitorResource::make($this->monitor);
    }
    public function storeMonitor()
    {
        $this->monitor = new Monitor();

        $this->monitor->id = $this->request->id;
        $this->monitor->manufacturer = $this->request->manufacturer;
        $this->monitor->model = $this->request->model;
        $this->monitor->disp_code = $this->request->disp_code;
        $this->monitor->service_tag = $this->request->service_tag;
        $this->monitor->serial = $this->request->serial;
        $this->monitor->workspace_id = $this->request->workspace_id;

        $this->monitor->save();

    }

    protected function updateMonitor()
    {
        $this->monitor->update($this->request->all());

        $this->monitor->save();
    }

    protected function deleteMonitor()
    {
        $this->monitor->delete($this->request);
    }

}
