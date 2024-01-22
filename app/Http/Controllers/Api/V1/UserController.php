<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\User\ResetPasswordRequest;
use App\Http\Resources\Api\V1\User\UserResource;
use App\Models\Api\V1\User;
use App\Repositories\Api\V1\User\UserRepository;
use App\Services\Api\V1\BankService;
use App\Traits\Api\V1\ResponderTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    use ResponderTrait;

    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly BankService    $bankService,
    )
    {
    }

    public function index(): JsonResponse
    {
        return $this->responseIndex($this->userRepository->all());
    }

    public function store(Request $request): JsonResponse
    {
        return $this->responseCreated($this->userRepository->create($request->all()));
    }

    public function show(User $user): JsonResponse
    {
        return $this->responseShow($this->userRepository->find($user->id));
    }

    public function update(Request $request, User $user): JsonResponse
    {
        $this->userRepository->update($request->all(), $user->id);
        return $this->responseUpdated();
    }

    public function destroy(User $user): JsonResponse
    {
        $this->userRepository->delete($user->id);
        return $this->responseDestroyed();
    }

    public function profile(): JsonResponse
    {
        return $this->response(new UserResource(auth()->user()->with('addresses', 'cards', 'wallets')->first()));
    }

    public function logout(): JsonResponse
    {
        auth()->user()->currentAccessToken()->delete();
        return $this->responseSuccessful('Longed out successfully');
    }

    public function resetPassword(ResetPasswordRequest $request): JsonResponse
    {
        auth()->user()->update(['password' => Hash::make($request->new_password)]);
        return $this->responseSuccessful('کلمه عبور با موفقیت آپدیت شد');
    }

    public function forgotPassword(): JsonResponse
    {
        return $this->response(new UserResource(auth()->user()->with('addresses', 'cards', 'wallets')->first()));
    }
}
