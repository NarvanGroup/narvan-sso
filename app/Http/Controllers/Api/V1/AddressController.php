<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Address\StoreAddressRequest;
use App\Http\Resources\Api\V1\Address\AddressResource;
use App\Models\Api\V1\Address;
use App\Repositories\Api\V1\Address\AddressRepository;
use App\Services\Api\V1\AddressService;
use App\Traits\Api\V1\ResponderTrait;
use Illuminate\Http\JsonResponse;

class AddressController extends Controller
{
    use ResponderTrait;

    public function __construct(
        private readonly AddressRepository $addressRepository,
        private readonly AddressService    $addressService
    )
    {
    }

    public function index(): JsonResponse
    {
        return $this->responseIndex(AddressResource::collection($this->addressRepository->all()));
    }

    public function store(StoreAddressRequest $request): JsonResponse
    {
        return $this->responseCreated(new AddressResource($this->addressRepository->create($request->validated())));
    }

    public function show(Address $address): JsonResponse
    {
        $this->authorize('show', $address);
        return $this->responseShow($this->addressRepository->find($address->id));
    }

    public function update(StoreAddressRequest $request, Address $address): JsonResponse
    {
        $this->authorize('update', $address);
        $this->addressRepository->update($request->validated(), $address->id);
        return $this->responseUpdated();
    }

    public function destroy(Address $address): JsonResponse
    {
        $this->authorize('destroy', $address);
        $this->addressRepository->delete($address->id);
        return $this->responseDestroyed();
    }

    public function getProvinces()
    {
        return $this->addressService->getAllProvinces();
    }

    public function getCities(int $provinceId)
    {
        return $this->addressService->getCities($provinceId);
    }

}
