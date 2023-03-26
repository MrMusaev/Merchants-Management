<?php

namespace App\Http\Controllers\Api\Merchants;

use App\Exceptions\Custom\FrontEndException;
use App\Http\Controllers\Controller;
use App\Http\Data\Api\Merchants\EditData;
use App\Http\Requests\Merchants\CreateRequest;
use App\Http\Requests\Merchants\EditRequest;
use App\Http\Resources\Merchants\MerchantDetailsResource;
use App\Http\Responses\ApiErrorResponse;
use App\Http\Responses\ServerErrorResponse;
use App\Http\Responses\SuccessResponse;
use App\Models\Merchants\Merchant;
use App\Services\Merchants\CrudService;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Throwable;

class CrudController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateRequest $request, CrudService $service): Response
    {
        try {
            $data = EditData::from($request);
            $creator = Auth::user();

            $merchant = $service->create($data, $creator);

            return new SuccessResponse(
                new MerchantDetailsResource($merchant)
            );
        } catch (FrontEndException $e) {
            report($e);
            return new ApiErrorResponse($e);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Merchant $merchant): Response
    {
        return new SuccessResponse(
            new MerchantDetailsResource($merchant)
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EditRequest $request, CrudService $service, Merchant $merchant): Response
    {
        try {
            $data = EditData::from($request);
            $user = Auth::user();

            $merchant = $service->edit($data, $merchant, $user);

            return new SuccessResponse(
                new MerchantDetailsResource($merchant)
            );
        } catch (FrontEndException $e) {
            report($e);
            return new ApiErrorResponse($e);
        } catch (Throwable $e) {
            report($e);
            return new ServerErrorResponse($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CrudService $service, Merchant $merchant): Response
    {
        try {
            $service->destroy($merchant);

            return new SuccessResponse([
                "message" => __("Record successfully deleted")
            ]);
        } catch (FrontEndException $e) {
            report($e);
            return new ApiErrorResponse($e);
        } catch (Throwable $e) {
            report($e);
            return new ServerErrorResponse($e);
        }
    }
}
