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
        $book = new Book($request->except('cover'));

        // If cover is uploaded, add media to book
        if ($request->hasFile('cover')) {
            $book->cover = $request->file('cover');
        }

        return new BookResource($book);
    }

    public function show($id)
    {
        $book = Book::findOrFail($id);

        return new BookResource($book);
    }


    public function update(StoreBookRequest $request, int $id)
    {
        $book = Book::find($id)->update($request->except('cover'));

        // If cover is uploaded, add media to book
        if ($request->hasFile('cover')) {
            $book->cover = $request->file('cover');
        }

        return new BookResource($book);
    }

    public function destroy($id)
    {
        $book = Book::find($id)->delete();

        return response()->json(['message' => 'Book deleted'], 200);
    }
}
