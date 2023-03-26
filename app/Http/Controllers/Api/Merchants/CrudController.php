<?php

namespace App\Http\Controllers\Api\Merchants;

use App\Exceptions\Custom\FrontEndException;
use App\Http\Controllers\Controller;
use App\Http\Data\Api\Merchants\EditData;
use App\Http\Data\Api\Merchants\FilterData;
use App\Http\Data\Api\Merchants\NearestData;
use App\Http\Requests\Merchants\CreateRequest;
use App\Http\Requests\Merchants\EditRequest;
use App\Http\Requests\Merchants\FilterRequest;
use App\Http\Requests\Merchants\NearestRequest;
use App\Http\Resources\Merchants\MerchantDetailsResource;
use App\Http\Resources\Merchants\MerchantDistanceListResource;
use App\Http\Resources\Merchants\MerchantListResource;
use App\Http\Responses\ApiErrorResponse;
use App\Http\Responses\ServerErrorResponse;
use App\Http\Responses\SuccessResponse;
use App\Models\Merchants\Merchant;
use App\ReadCases\MerchantReadCase;
use App\Services\Merchants\CrudService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Throwable;

class CrudController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(FilterRequest $request, MerchantReadCase $readCase): AnonymousResourceCollection|Response
    {
        try {
            $filterData = FilterData::from($request->all());

            $query = $readCase->filter($filterData);
            $readCase->addSort($query, $filterData->sort_field, $filterData->sort_direction);

            return MerchantListResource::collection($query->paginate($filterData->per_page))
                ->additional(['code' => 1]);
        } catch (Throwable $e) {
            report($e);
            return new ServerErrorResponse($e);
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function nearest(NearestRequest $request, MerchantReadCase $readCase): AnonymousResourceCollection|Response
    {
        try {
            $filterData = FilterData::from($request->all());

            $query = $readCase->nearest($filterData->lat, $filterData->lng);
            $readCase->filter($filterData, $query);

            return MerchantDistanceListResource::collection($query->paginate($filterData->per_page))
                ->additional(['code' => 1]);
        } catch (Throwable $e) {
            report($e);
            return new ServerErrorResponse($e);
        }
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
        } catch (Throwable $e) {
            report($e);
            return new ServerErrorResponse($e);
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
