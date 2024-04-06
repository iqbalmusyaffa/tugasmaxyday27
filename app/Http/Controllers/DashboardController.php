<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Fetch posts from the database
        $posts = Post::all();

        // Pass the posts data to the dashboard view
        return view('dashboard', compact('posts'));
    }
}
