<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
// Use the Post Model
use App\Models\Post;
// We will use Form Request to validate incoming requests from our store and update method
use App\Http\Requests\Post\StoreRequest;
use App\Http\Requests\Post\UpdateRequest;
use App\Models\Category;
use App\Models\Tag;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        return response()->view('posts.index', [
            'posts' => Post::orderBy('updated_at', 'desc')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        $categories = Category::all();
        $tags = Tag::all();

        return response()->view('posts.form', compact('categories', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        // Check if the request has a featured image and store it
        if ($request->hasFile('featured_image')) {
            $filePath = Storage::disk('public')->put('images/posts/featured-images', request()->file('featured_image'));
            $validated['featured_image'] = $filePath;
        }

        // Create a new post instance
        $post = Post::create($validated);

        // If post creation is successful
        if ($post) {
            // Attach categories to the post

            if ($request->has('category')) {
                $post->categories()->attach($request->input('category'));
            }

            // Attach tags to the post
            if ($request->has('tags')) {
                $post->tags()->attach($request->input('tags'));
            }
            $commentContent = $request->input('comment');
            if ($commentContent) {
                $post->comments()->create([
                    'content' => $commentContent,
                ]);
            }
            // Flash success notification
            session()->flash('notif.success', 'Post created successfully!');
            return redirect()->route('posts.index');
        }

        // If post creation fails
        return abort(500);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): Response
    {
        return response()->view('posts.show', [
            'post' => Post::findOrFail($id),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): Response
    {
        $post = Post::findOrFail($id);
        $categories = Category::all();
        $tags = Tag::all();

        return response()->view('posts.form', compact('post', 'categories', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, string $id): RedirectResponse
    {
       // Find the post to update
       $post = Post::findOrFail($id);

       // Validate the incoming request
       $validated = $request->validated();

       // Check if the request has a featured image and update it
       if ($request->hasFile('featured_image')) {
           Storage::disk('public')->delete($post->featured_image);
           $filePath = Storage::disk('public')->put('images/posts/featured-images', $request->file('featured_image'));
           $validated['featured_image'] = $filePath;
       }

       // Update the post
       $update = $post->update($validated);

       // If post update is successful
       if ($update) {
           // Sync categories with the post
           if ($request->has('category')) {
               $post->categories()->sync($request->input('category'));
           }

           // Sync tags with the post
           if ($request->has('tags')) {
               $post->tags()->sync($request->input('tags'));
           }

           $commentContent = $request->input('comment');
    if ($commentContent) {
        $post->comments()->create([
            'content' => $commentContent,
        ]);
    }
           // Flash success notification
           session()->flash('notif.success', 'Post updated successfully!');
           return redirect()->route('posts.index');
       }

       // If post update fails
       return abort(500);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $post = Post::findOrFail($id);

        // Delete featured image
        Storage::disk('public')->delete($post->featured_image);

        // Detach categories and tags
        $post->categories()->detach();
        $post->tags()->detach();

        // Delete post
        $delete = $post->delete();

        if ($delete) {
            // Flash success notification
            session()->flash('notif.success', 'Post deleted successfully!');
            return redirect()->route('posts.index');
        }

        return abort(500);
    }
}
