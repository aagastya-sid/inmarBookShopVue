<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use function Pest\Laravel\get;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::all();

        $books = $books->map(function ($book) {
            return [
                'id' => $book->id,
                'title' => $book->title,
                'author' => $book->author,
                'price' => $book->price,
                'priceString' => getPriceString($book->price),
                'image' => $book->image,
                'cart_id' => $book->cart_id,
            ];
        });

        if (auth()->user()->type === 'admin') {
            return inertia('Admin/Books/Index', [
                'books' => $books,
            ]);
        }

        return inertia('Books/Index', [
            'books' => $books,
        ]);

    }

    public function create()
    {
        return inertia('Admin/Books/Form');
    }

    public function store(Request $request)
    {
        Book::create([
            'title' => $request->book_title,
            'author' => $request->book_author,
            'price' => $request->book_price,
        ]);

        return back()->with('message', 'Book created successfully');
    }

    public function show(Book $book)
    {
    }

    public function edit(Book $book)
    {
        return inertia('Admin/Books/Form',
            [
                'book' => $book,
            ]);
    }

    public function update(Request $request, Book $book)
    {
        $book->update([
            'title' => $request->book_title,
            'author' => $request->book_author,
            'price' => $request->book_price,
        ]);

        $message = 'Book updated successfully';
        if (!$book->wasChanged()) {
            $message = 'No changes made';
        }

        return back()->with('message', $message);
    }

    public function destroy(Book $book)
    {
    }
}
