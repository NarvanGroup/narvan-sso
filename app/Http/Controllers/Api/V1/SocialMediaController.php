<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\SocialMedia\StoreSocialMediaRequest;
use App\Http\Resources\Api\V1\SocialMedia\SocialMediaResource;
use App\Models\Api\V1\SocialMedia;
use App\Repositories\Api\V1\SocialMedia\SocialMediaRepository;
use App\Traits\Api\V1\ResponderTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SocialMediaController extends Controller
{
    use ResponderTrait;

    public function __construct(private readonly SocialMediaRepository $socialMediaRepository)
    {
    }

    public function index(): JsonResponse
    {
        return $this->responseIndex(SocialMediaResource::collection($this->socialMediaRepository->all()));
    }

    public function store(StoreSocialMediaRequest $request): JsonResponse
    {
        return $this->responseCreated(new SocialMediaResource($this->socialMediaRepository->create($request->validated())));
    }

    public function show(SocialMedia $socialMedia): JsonResponse
    {
        $this->authorize('show', $socialMedia);
        return $this->responseShow($this->socialMediaRepository->find($socialMedia->id));
    }

    public function update(StoreSocialMediaRequest $request, SocialMedia $socialMedia): JsonResponse
    {
        $this->authorize('update', $socialMedia);
        $this->socialMediaRepository->update($request->validated(), $socialMedia->id);
        return $this->responseUpdated();
    }

    public function destroy(SocialMedia $socialMedia): JsonResponse
    {
        $this->authorize('destroy', $socialMedia);
        $this->socialMediaRepository->delete($socialMedia->id);
        return $this->responseDestroyed();
    }
}
