<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Socialite;
use App\Models\User;

class SocialLoginController extends Controller
{
    public function redirect($service)
    {
        return Socialite::driver($service)->stateless()->redirect();
    }

    public function callback($service)
    {
        $serviceUser = Socialite::driver($service)
            ->stateless()->user();

        $user = $this->getExsitingUser($serviceUser);

        if (!$user) {
            $user = User::create([
                'name' =>  $serviceUser->getName(),
                'email' => $serviceUser->getEmail(),
            ]);
            $user->markEmailAsVerified();
        }

        if ($this->needsToCreateSocial($user, $service)) {
            $user->social()->create([
                'social_id' => $serviceUser->getId(),
                'service' => $service
            ]);
        }

        $token = $user->createToken('Token')->accessToken;

        return redirect(config('app.front') . '?token=' . $token);
    }

    protected function needsToCreateSocial(User $user, $service)
    {
        return !$user->hasSocialLinked($service);
    }

    protected function getExsitingUser($userService)
    {
        return User::whereEmail($userService->getEmail())->first();
    }
}
