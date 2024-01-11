<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Order\StoreOrderRequest;
use App\Http\Resources\Api\V1\Invoice\InvoiceResource;
use App\Http\Resources\Api\V1\Order\OrderResource;
use App\Models\Api\V1\Order;
use App\Repositories\Api\V1\Order\OrderRepository;
use App\Services\Api\V1\OrderService;
use App\Traits\Api\V1\ResponderTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    use ResponderTrait;

    public function __construct(private readonly OrderRepository $orderRepository, private readonly OrderService $orderService)
    {
    }

    public function index(): JsonResponse
    {

        return $this->responseIndex(OrderResource::collection(Order::with('products.product')->get()));
    }

    public function store(StoreOrderRequest $request): JsonResponse
    {
        $order = $this->orderService->createNewOrder($request->validated());
        return $this->responseCreated(new OrderResource($order->with('products.product')->first()));
    }

    public function show(Order $order): JsonResponse
    {
        return $this->responseShow(new OrderResource($this->orderRepository->find($order->id)->with('products.product')->first()));
    }

    public function update(Request $request, Order $order): JsonResponse
    {
        $this->orderRepository->update($request->all(), $order->id);
        return $this->responseUpdated();
    }

    public function destroy(Order $order): JsonResponse
    {
        $this->orderRepository->delete($order->id);
        return $this->responseDestroyed();
    }

    public function invoice(Order $order): JsonResponse
    {
        return $this->responseShow(new InvoiceResource($order->with(['products.product','address','user'])->first()));
    }
}
