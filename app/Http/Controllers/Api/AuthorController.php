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

        return new AuthorResource($author);
    }

    public function show($id)
    {
        $author = Author::findOrFail($id);

        return new AuthorResource($author);
    }

    public function update(StoreAuthorRequest $request, $id)
    {
        $author = Author::find($id)->update($request->validated());

        return new AuthorResource($author);
    }

    public function destroy($id)
    {
        $author = Author::find($id)->delete();

        return response()->json(['message' => 'Author deleted'], 200);
    }
}
