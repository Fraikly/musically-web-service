<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController as Controller;
use App\Http\Requests\LoginAuthRequest;
use App\Http\Requests\RegisterAuthRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;

class AuthController extends Controller
{
    /**
     * Register user.
     *
     * @param RegisterAuthRequest $request
     * @param AuthService $service
     * @return array
     */
    public function register(RegisterAuthRequest $request, AuthService $service)
    {
        $result = $service->register($request->validated());

        $token = $result->createToken('token')->plainTextToken;

        return ['token' => $token];
    }

    /**
     * Login user.
     *
     * @param LoginAuthRequest $request
     * @param AuthService $service
     * @return Response
     */
    public function login(LoginAuthRequest $request, AuthService $service)
    {
        $token = $service->login($request->validated());

        if ($token === false) {
            return $this->sendErrorResponse([], 401);
        } else {
            return $this->sendResponse($token);
        }
    }

    /**
     * Logout user.
     *
     * @return Response
     */
    public function logout()
    {
        $token = PersonalAccessToken::findToken(request()->bearerToken());
        $token->delete();

        return $this->sendResponse();
    }
}
