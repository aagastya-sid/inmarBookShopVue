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

        return inertia('Books/Index', [
            'books' => $books,
        ]);

    }

    public function create()
    {
    }

    public function store(Request $request)
    {
    }

    public function show(Book $book)
    {
    }

    public function edit(Book $book)
    {
    }

    public function update(Request $request, Book $book)
    {
    }

    public function destroy(Book $book)
    {
    }
}
