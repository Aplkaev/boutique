<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Book\StoreBookRequest;
use App\Http\Resources\BookResource;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::all();

        return BookResource::collection($books);
    }

    public function store(StoreBookRequest $request)
    {
        $book = Book::create($request->except('cover'));


        // ! if cover is uploaded, add media to book
        if ($request->hasFile('cover')) {
            $book->cover = 'cover';
        }

        return new BookResource($book);
    }

    public function show(string $slug)
    {
        $book = Book::findOrFail($slug);

        return new BookResource($book);
    }


    public function update(StoreBookRequest $request, string $slug)
    {
        $book = Book::where('slug', $slug)->firstOrFail();

        $book->update($request->except('cover'));

        // ! if cover is uploaded, add media to book
        if ($request->hasFile('cover')) {
            $book->cover = $request->file('cover');
        }

        return new BookResource($book);
    }

    public function destroy(string $slug)
    {
        $book = Book::where('slug', $slug)->firstOrFail();

        // ! delete book
        $book->delete();

        return response()->json(['message' => 'Book deleted'], 200);
    }
}
