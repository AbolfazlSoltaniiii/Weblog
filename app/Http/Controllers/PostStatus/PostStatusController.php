<?php

namespace App\Http\Controllers\PostStatus;

use App\Http\Controllers\Controller;
use App\PostStatus;
use Illuminate\Http\Request;

class PostStatusController extends Controller
{
    public function __construct(
        Request                     $request,
        private readonly PostStatus $postStatus
    )
    {
    }

    public function getByCode($code)
    {
        return $this->postStatus->query()
            ->where('code', $code)
            ->sole();
    }
}
