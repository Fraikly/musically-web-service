<?php

namespace App\Services;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthService extends BaseService
{
    /**
     * Register user.
     *
     * @param array $attributes
     * @return array
     */
    public function register(array $attributes)
    {
        $validated = collect($attributes);
        $validated->put('password', Hash::make($validated->get('password')));
        $user = new User($validated->toArray());
        $user->save();

        return $user;
    }

    /**
     * Login user.
     *
     * @param array $attributes
     * @return mixed
     */
    public function login(array $attributes)
    {
        $user = User::where('email', $attributes['email'])->first();

        if (!$user || !Hash::check($attributes['password'], $user->password)) {
            return false;
        }

        $token = $user->createToken('token')->plainTextToken;

        return [
            'token' => $token,
        ];
    }
}
