<?php

namespace App\Services;

use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;

class UserService
{

    protected $request;
    protected $user;

    public function __construct(StoreUserRequest $request = null, $user = null)
    {
        $this->request = $request;
        $this->user = $user;
    }

    public function update()
    {
        $this->updateUser();
    }

    public function create()
    {
        $this->storeUser();
    }

    public function delete()
    {
        $this->deleteUser();
    }

    public function user(): UserResource
    {
        return UserResource::make($this->user);
    }

    /**
     * @return void
     * Method which stores user to database
     */
    protected function storeUser()
    {
        $this->user = new User();


        $this->user->id = $this->request->id;
        $this->user->name = $this->request->name;
        $this->user->email = $this->request->email;
        $this->user->role = $this->request->role;
        $this->user->save();

    }

    protected function updateUser()
    {
        $this->user->update($this->request->all());
        $this->user->save();
    }

    protected function deleteUser()
    {
        $this->user->reservations()->detach();
        $this->user->delete($this->request);
    }
}
