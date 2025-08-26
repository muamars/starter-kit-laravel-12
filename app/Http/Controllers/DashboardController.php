<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Project;
use App\Models\User;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = auth()->user();

        $stats = [
            'blogs' => $user->can('view blogs') ? Blog::count() : 0,
            'projects' => $user->can('view projects') ? Project::count() : 0,
            'users' => $user->can('view users') ? User::count() : 0,
        ];

        return view('dashboard', compact('stats'));
    }
}
