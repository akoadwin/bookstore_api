<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Book::all();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $book = Book::create($request->all()); // To create a new Book
        // return response()->json(['message' => 'Book Created successfully', $book], 201); // Return the book and 201 status code means Created
        return response()->json([$book], 201); // Return the book and 201 status code means Created

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $book = Book::find($id); // Find the Book by ID
        if (!$book) {
            return response()->json(['message' => 'Book is not found'], 404); // Return 404 if the book is not found
        }
        return $book;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $book = Book::find($id);
        if (!$book) {
            return response()->json(['message' => 'Book is not found'], 404); // Return 404 if the book is not found
        }
        $book->update($request->all()); // Update the Book
        return response()->json($book, 200); // Return the book and 200 code status means Success
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $book = Book::find($id);
        if (!$book) {
            return response()->json(['message' => 'Book is not found'], 404); // Return 404 if the book is not found
        }
        $book->delete();
        return response()->json(['message' => 'Book successfully deleted'], 200);
    }
}
