<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Author\StoreAuthorRequest;
use App\Http\Resources\AuthorResource;
use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function index()
    {
        $authors = Author::all();

        return AuthorResource::collection($authors);
    }

    public function store(StoreAuthorRequest $request)
    {
        $author = new Author($request->validated());

        // ! save author
        $author->save();

        return new AuthorResource($author);
    }

    public function show($slug)
    {
        $author = Author::where('slug', $slug)->firstOrFail();

        return new AuthorResource($author);
    }

    public function update(StoreAuthorRequest $request, $slug)
    {
        $author = Author::where('slug', $slug)
            ->firstOrFail()
            ->update($request->validated());

        return new AuthorResource($author);
    }

    public function destroy($slug)
    {
        $author = Author::where('slug', $slug)->firstOrFail()->delete();

        return response()->json(['message' => 'Author deleted'], 200);
    }
}
