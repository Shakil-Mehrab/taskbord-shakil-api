<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Snippet;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\SnippetResource;

class SnippetController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:sanctum'])
            ->only('store', 'update');
    }

    public function index(Request $request)
    {
        $builder=Snippet::take($request->get('limit', 20))
       ->with(['steps', 'user'])
       ->latest()
       ->public();

        if ($query=request('query')) {
            $builder=$builder->where('title', 'like', "%{$query}%");
        }

        $snippets=$builder->get();

        return SnippetResource::collection($snippets);
    }

    public function show(Snippet $snippet)
    {
        // $this->authorize('show', $snippet);
        $snippet->load(['user','steps']);
        return new SnippetResource($snippet);
    }

    public function store(Request $request)
    {
        $snippet =  auth()->user()->snippets()->create($request->all());
        return new SnippetResource($snippet);
    }

    public function update(Snippet $snippet, Request $request)
    {
        $this->authorize('update', $snippet);

        $this->validate($request, [
            'title' => 'nullable',
            'is_public' => 'nullable|boolean'
        ]);

        return $snippet->update([
            'title'=>$request->title,
            'is_public' => $request->is_public ?? false,
        ]);
    }

    public function destroy(Snippet $snippet)
    {
        $this->authorize('delete', $snippet);

        $snippet->delete();
    }
}
