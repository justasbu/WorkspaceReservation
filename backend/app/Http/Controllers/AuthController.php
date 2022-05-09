<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Microsoft\Graph\Graph;
use Microsoft\Graph\Model;
use App\TokenStore\TokenCache;
use Nette\Schema\ValidationException;
use function Symfony\Component\String\s;


class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    /**
     * Get a JWT via given credentials.
     */
    public function login(Request $request)
    {
        $validator = Validator::make(
            $request->all(), [
            'email' => 'required|email|regex:/(.*)@uc\.group/i|',
            'password' => 'required|string|min:6',
            ]
        );
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        if (!$token = auth()->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        //        return $this->createNewToken($token);
        return (new \App\Http\Resources\UserResource($request->user()))->additional(
            [
                'meta' => ['token' => $token]
            ]
        );
    }

    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $validator = Validator::make(
            $request->all(), [
            'name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|regex:/(.*)@uc\.group/i|unique:users',
            'role' => 'required|string',
            'password' => 'required|string|confirmed|min:8',
            ]
        );
        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }
        $user = User::create(
            array_merge(
                $validator->validated(),
                ['password' => bcrypt($request->password)]
            )
        );
        return response()->json(
            [
            'message' => 'User successfully registered',
            'user' => $user
            ], 201
        );
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'User successfully signed out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->createNewToken(auth()->refresh());
    }

    /**
     * Get the authenticated User.
     */
    public function userProfile(Request $request)
    {
        return new \App\Http\Resources\UserResource($request->user());
    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token)
    {
        return response()->json(
            [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()
            ]
        );
    }

    public function forgotPassword(Request $request)
    {
        $request->validate(
            [
            'email' => 'required|email'
            ]
        );
        $userData = \App\Models\User::where('email', $request->email)->first();

        //Create Password Reset Token
        DB::table('password_resets')->insert(
            [
            'email' => $request->email,
            'token' => Str::random(60),
            'created_at' => Carbon::now()
            ]
        );
        //Get the token just created above
        $tokenData = DB::table('password_resets')
            ->where('email', $request->email)->first();

        $link = env('APP_URL') . 'password/reset/' . $tokenData->token . '?email=' . $userData->email;

        Mail::send(new \App\Mail\ResetPassword($link, $tokenData, $userData));


    }

    public function reset(Request $request)
    {
        $request->validate(
            [
            'token' => 'required',
            'email' => 'required|email',
            'password' => ['required', 'confirmed', \Illuminate\Validation\Rules\Password::defaults()],
            ]
        );

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill(
                    [
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                    ]
                )->save();

                $user->tokens()->delete();

            }
        );

        if ($status == Password::PASSWORD_RESET) {
            return response(
                [
                'message' => 'Password reset successfully'
                ]
            );
        }

        return response(
            [
            'message' => __($status)
            ], 500
        );

    }


}
