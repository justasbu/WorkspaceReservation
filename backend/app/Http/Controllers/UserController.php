<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\UserService;

class UserController extends Controller
{
    /**
     * Display a listing of the user.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $users = User::all();

        return UserResource::collection($users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreUserRequest $request
     * @return UserResource
     */
    public function store(StoreUserRequest $request)
    {
        $service = new UserService($request);
        $service->create();

        return $service->user();
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Reservation $reservation
     * @return UserResource
     */
    public function show($id)
    {
        $users = User::all();
        $user = $users->find($id);

        return \App\Http\Resources\UserResource::make($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreUserRequest $request
     * @param User $user
     * @return UserResource
     */
    public function update(StoreUserRequest $request, User $user)
    {
        $service = new UserService($request, $user);
        $service->update();
        return $service->user();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
    }

}
