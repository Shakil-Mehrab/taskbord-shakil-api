<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Snippet;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\SnippetResource;

class MySnippetController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:sanctum']);
    }

    public function index(Request $request)
    {
        $snippets=auth()->user()->snippets;

        return SnippetResource::collection($snippets);
    }
}
