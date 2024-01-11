<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Repositories\Api\V1\User\UserRepository;
use App\Services\Api\V1\PriceService;
use App\Traits\Api\V1\ResponderTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Artisan;

class CommandController extends Controller
{
    use ResponderTrait;

    public function __construct(private readonly UserRepository $userRepository)
    {
    }

    public function seedDatabase(): JsonResponse
    {
        try {
            Artisan::call('db:seed');
        } catch (Exception $exception) {
            return $this->responseFailure($exception->getMessage());
        }

        return $this->responseSuccessful();
    }

    public function updatePrice(): JsonResponse
    {
        try {
            $priceService = new PriceService();
            $priceService->getGoldPrice();
        } catch (Exception $exception) {
            return $this->responseFailure($exception->getMessage());
        }

        return $this->responseSuccessful();
    }

    public function migrate(): JsonResponse
    {
        try {
            Artisan::call('migrate:fresh');
        } catch (Exception $exception) {
            return $this->responseFailure($exception->getMessage());
        }

        return $this->responseSuccessful();
    }

    public function init()
    {
        Artisan::call('app:init');
    }

    public function optimize(): JsonResponse
    {
        try {
            Artisan::call('optimize:clear');
        } catch (Exception $exception) {
            return $this->responseFailure($exception->getMessage());
        }

        return $this->responseSuccessful();
    }

    public function importLocations(): JsonResponse
    {
        try {
            Artisan::call('iran:import --target=cities');
        } catch (Exception $exception) {
            return $this->responseFailure($exception->getMessage());
        }

        return $this->responseSuccessful();
    }
}
