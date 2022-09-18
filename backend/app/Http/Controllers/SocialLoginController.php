<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserSocial;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Two\InvalidStateException;
use Tymon\JWTAuth\JWTAuth;

class SocialLoginController extends Controller
{
    protected $auth;

    public function __construct(JWTAuth $auth)
    {
        $this->auth = $auth;
        $this->middleware(['social', 'web']);
    }

    public function redirect($service)
    {
        return Socialite::driver($service)->stateless()
            ->scopes(['openid', 'offline_access', 'Mail.Read', 'User.Read', 'Mail.Send', 'Mail.Send.Shared', 'Mail.ReadWrite', 'Mail.ReadWrite.Shared'])
            ->redirect()
            ->getTargetUrl();
    }

    public function callback($service)
    {
        $serviceUser = Socialite::driver($service)->stateless()->user();

        $email = $serviceUser->getEmail();

        $user = User::where('email', $email)->first();


        if (!$user) {
            $names = explode(" ", $serviceUser->getName());

            $user = User::create([
                'name' => $serviceUser->getName(),
                'email' => $email,
                'password' => '',
                'role' => 'Regular'
            ]);


            User::where('email', $email)->update(['azure_token' => $serviceUser->token, 'azure_refresh' => $serviceUser->refreshToken]);
            $token = $this->auth->fromUser($user);
            $this->auth->setToken($token);
            $this->auth->authenticate();
            return view('oauth/callback', [
                'token' => $token,
                'token_type' => 'bearer',
                'expires_in' => $this->auth->factory()->getTTL() * 60,
            ]);
        }
        else {
            User::where('email', $email)->update(['azure_token' => $serviceUser->token, 'azure_refresh' => $serviceUser->refreshToken]);
            $token = $this->auth->fromUser($user);
            $this->auth->setToken($token);
            $this->auth->authenticate();
            return view('oauth/callback', [
                'token' => $token,
                'token_type' => 'bearer',
                'expires_in' => $this->auth->factory()->getTTL() * 60,
            ]);
        }


    }

    public function needsToCreateSocial(User $user, $service)
    {
        return !$user->hasSocialLinked($service);
    }

    public function getExistingUser($serviceUser, $email, $service)
    {
        if ((env('RETRIEVE_UNVERIFIED_SOCIAL_EMAIL') == 0) && ($service != 'google')) {
            $userSocial = UserSocial::where('social_id', $serviceUser->getId())->first();
            return $userSocial ? $userSocial->user : null;
        }
        return User::where('email', $email)->orWhereHas('social', function ($q) use ($serviceUser, $service) {
            $q->where('social_id', $serviceUser->getId())->where('service', $service);
        })->first();
    }
}
