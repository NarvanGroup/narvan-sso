<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Contract\StoreContractRequest;
use App\Models\Api\V1\Contract;
use App\Repositories\Api\V1\Contract\ContractRepository;
use App\Services\Api\V1\ContractService;
use App\Traits\Api\V1\ResponderTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ContractController extends Controller
{
    use ResponderTrait;

    public function __construct(
        private readonly ContractRepository $contractRepository,
        private readonly ContractService    $contractService
    )
    {
    }

    public function index(): JsonResponse
    {
        return $this->responseSuccessful($this->contractRepository->all());
    }

    public function store(StoreContractRequest $request): JsonResponse
    {
        $this->contractService->calculateContract($request);
        return $this->responseCreated($this->contractRepository->create($request->all()));
    }

    public function show(Contract $contract): JsonResponse
    {
        return $this->responseShow($this->contractRepository->find($contract->id));
    }

    public function update(Request $request, Contract $contract): JsonResponse
    {
        $this->contractRepository->update($request->all(), $contract->id);
        return $this->responseUpdated();
    }

    public function destroy(Contract $contract): JsonResponse
    {
        $this->contractRepository->delete($contract->id);
        return $this->responseDestroyed();
    }
}
