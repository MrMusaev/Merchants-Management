<?php

namespace App\Http\Controllers\Api\Auth;

use App\Exceptions\Custom\FrontEndException;
use App\Http\Controllers\Controller;
use App\Http\Data\Api\Auth\RegisterData;
use App\Http\Requests\Auth\ApiLoginRequest;
use App\Http\Requests\Auth\ApiRegisterRequest;
use App\Http\Resources\User\UserDetailsResource;
use App\Http\Responses\ApiErrorResponse;
use App\Http\Responses\ServerErrorResponse;
use App\Http\Responses\SuccessResponse;
use App\Services\Auth\AuthService;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Throwable;

class AuthController extends Controller
{
    /**
     * @param ApiLoginRequest $request
     * @param AuthService $service
     *
     * @return Response
     */
    public function login(ApiLoginRequest $request, AuthService $service): Response
    {
        try {
            $user = $service->authenticate($request);
            return new SuccessResponse([
                'user' => new UserDetailsResource($user),
                'token' => $user->createToken('api')->plainTextToken,
            ]);
        } catch (ValidationException|FrontEndException $e) {
            report($e);
            return new ApiErrorResponse($e, 401);
        } catch (Throwable $e) {
            report($e);
            return new ServerErrorResponse($e);
        }
    }

    public function register(ApiRegisterRequest $request, AuthService $service): Response
    {
        try {
            $registerData = RegisterData::from($request->all());
            $user = $service->registerUser($registerData);

            return new SuccessResponse([
                'user' => new UserDetailsResource($user),
                'token' => $user->createToken('api')->plainTextToken,
            ]);
        } catch (FrontEndException $e) {
            report($e);
            return new ApiErrorResponse($e);
        }
    }
}
