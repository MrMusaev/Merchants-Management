<?php

namespace App\Http\Controllers\Api\Auth;

use App\Exceptions\Custom\FrontEndException;
use App\Http\Controllers\Controller;
use App\Http\Data\Api\Auth\RegisterData;
use App\Http\Requests\Auth\ApiRegisterRequest;
use App\Http\Resources\User\UserDetailsResource;
use App\Http\Responses\Backend\ApiErrorResponse;
use App\Http\Responses\Backend\ServerErrorResponse;
use App\Http\Responses\Backend\SuccessResponse;
use App\Services\Auth\AuthService;
use Illuminate\Http\Response;
use Throwable;

class AuthController extends Controller
{
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

    /**
     * @return Response
     */
    public function logout(): Response
    {
        $user = auth()->user();

        try {
            $user->currentAccessToken()->delete();

            return new SuccessResponse([
                'message' => __("Logged out")
            ]);
        } catch (Throwable $e) {
            report($e);
            return new ServerErrorResponse($e);
        }
    }
}
