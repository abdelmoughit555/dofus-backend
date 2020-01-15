<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;

class AdminLoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(LoginRequest $request)
    {
        $user = (bool) in_array($request->email, explode(',', config('services.dofus.admins')));

        return $user ? $this->attemptLogin($request) : $this->abortLogin();
    }

    private function attemptLogin($request)
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

    private function abortLogin()
    {
        return abort(404);
    }
}
