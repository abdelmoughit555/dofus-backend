<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth:api")->only('me');
    }

    public function store(RegisterRequest $request)
    {
        User::create($request->validated());

        return $this->attemptLogin($request);
    }

    public function login(LoginRequest $request)
    {
        return $this->attemptLogin($request);
    }

    public function me()
    {
        return new UserResource(request()->user());
    }


    public function logout()
    {
        auth()->logout();

        return 200;
    }

    private function attemptLogin(Request $request)
    {
        if ($token = auth()->attempt($request->only("email", "password"))) {

            return (new UserResource($request->user()))
                ->additional([
                    'meta' => [
                        'token' => $token
                    ]
                ]);
        } else {
            return response()->json([
                'errors' => [
                    'invalid' => 'login ou mot de passe incorrect'
                ]
            ], 401);
        }
    }
}
