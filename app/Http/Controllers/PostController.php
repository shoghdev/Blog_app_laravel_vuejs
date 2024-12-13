<?php

namespace App\Http\Controllers;

use App\Http\Requests\Post\StoreRequest;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PostController extends Controller
{
    public function index()
    {

    }

    public function create()
    {
        return Inertia::render('Post/Form');
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('posts', 'public');
        }

        $post = auth()->user()->posts()->create($validated);
        if ($post) {
            return redirect()->route('dashboard')->with('message', 'Post Created Successfully');
        }

        return back()->withErrors(['error' => 'Unable to create post. Please try again.']);
    }


    public function show(Post $post): Response
    {
        return Inertia::render('Post/Show', [
            'post' => $post,
            'author' => $post->author
        ]);
    }

    public function edit(Post $post)
    {
        if ($post->author_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        return Inertia::render('Post/Form', [
            'post' => $post,
        ]);
    }

    public function update(StoreRequest $request, Post $post)
    {
        $postValidated = $request->validated();
        if ($request->hasFile('image')) {
            $postValidated['image'] = $request->file('image')->store('posts', 'public');
        }

        $updatePost = $post->update($postValidated);

        if ($updatePost) {
            return redirect()->route('dashboard')->with('message', 'Post Updated Successfully');
        }

        return redirect()->route('dashboard')->with('error', 'Failed to update post');
    }


    public function destroy(Post $post)
    {
        if ($post->author_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        try {
            $post->delete();
            return redirect()->route('posts.index')->with('message', 'Post Deleted Successfully');
        } catch (\Exception $e) {
            return redirect()->route('posts.index')->with('error', 'Failed to delete the post');
        }
    }
}
