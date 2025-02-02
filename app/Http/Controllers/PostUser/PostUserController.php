<?php

namespace App\Http\Controllers\PostUser;

use App\Http\Controllers\Controller;
use App\PostUser;

class PostUserController extends Controller
{
    public function __construct(
        private readonly PostUser $postUser
    )
    {
    }

    public function store($attributes)
    {
        return $this->postUser->create($attributes);
    }
}
