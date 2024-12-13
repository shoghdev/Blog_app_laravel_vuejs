<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function index(): Response
    {
        $posts = Post::orderBy('created_at', 'desc')->get();
        $author = auth()->user();
        return Inertia::render('Dashboard', [
            'posts' =>$posts,
            'author' => $author,
            'creator' => $posts->map(function($post) use ($author) {
                return $post->author->id === $author->id;
            })
        ]);
    }

}
