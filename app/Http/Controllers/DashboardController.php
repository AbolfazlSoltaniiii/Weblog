<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Post\PostController;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;

class DashboardController extends Controller
{
    public function __construct(
        private readonly PostController $postController
    )
    {
    }

    public function view(): View|Factory|Application
    {
        $approvedPosts = $this->postController->getCountForDashboard('approved');
        $pendingPosts = $this->postController->getCountForDashboard('pending');
        $rejectedPosts = $this->postController->getCountForDashboard('rejected');

        return view('dashboard.dashboard', compact('approvedPosts', 'pendingPosts', 'rejectedPosts'));
    }
}
