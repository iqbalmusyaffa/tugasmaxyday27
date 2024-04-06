<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use App\Models\Tag;
use App\Http\Requests\Tags\StoreRequest;
use App\Http\Requests\Tags\UpdateRequest;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        return response()->view('tags.index', [
            'tags' => Tag::orderBy('updated_at', 'desc')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return response()->view('tags.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $create = Tag::create($validated);

        if ($create) {
            session()->flash('notif.success', 'Tag created successfully!');
            return redirect()->route('tags.index');
        }

        return abort(500);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): Response
    {
        return response()->view('tags.show', [
            'tag' => Tag::findOrFail($id),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): Response
    {
        return response()->view('tags.form', [
            'tag' => Tag::findOrFail($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, string $id): RedirectResponse
    {
        $tag = Tag::findOrFail($id);
        $validated = $request->validated();

        $update = $tag->update($validated);

        if ($update) {
            session()->flash('notif.success', 'Tag updated successfully!');
            return redirect()->route('tags.index');
        }

        return abort(500);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $tag = Tag::findOrFail($id);

        $delete = $tag->delete();

        if ($delete) {
            session()->flash('notif.success', 'Tag deleted successfully!');
            return redirect()->route('tags.index');
        }

        return abort(500);
    }
}
