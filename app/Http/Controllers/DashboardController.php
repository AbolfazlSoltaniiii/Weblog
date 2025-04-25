<?php

namespace App\Http\Controllers;

use App\Services\Post\PostService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;

class DashboardController extends Controller
{
    public function __construct(
        private readonly PostService $postService
    )
    {
    }

    public function view(): View|Factory|Application
    {
        // get count of posts by status code
        $approvedPosts = $this->postService->getCountForDashboard('approved');
        $pendingPosts = $this->postService->getCountForDashboard('pending');
        $rejectedPosts = $this->postService->getCountForDashboard('rejected');

        return view('dashboard.dashboard', compact('approvedPosts', 'pendingPosts', 'rejectedPosts'));
    }
}
