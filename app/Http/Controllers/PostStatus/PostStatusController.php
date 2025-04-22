<?php

namespace App\Http\Controllers\PostStatus;

use App\Http\Controllers\Controller;
use App\Services\PostStatus\PostStatusService;
use Illuminate\Http\Request;

class PostStatusController extends Controller
{
    public function __construct(
        Request                              $request,
        protected readonly PostStatusService $postStatusService
    )
    {
    }

    public function getByCode(string $code)
    {
        return $this->postStatusService->getByCode($code);
    }
}
