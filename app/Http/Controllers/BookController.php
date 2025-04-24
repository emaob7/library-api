<?php

namespace App\Http\Controllers;

use App\Http\Resources\BookResource;
use App\Models\Book;
use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class BookController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $books = Book::with('author')->paginate(10);
        return BookResource::collection($books);
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'isbn' => 'required|string|unique:books,isbn|max:20',
            'published_date' => 'required|date|before_or_equal:today',
            'author_id' => 'required|exists:authors,id'
        ], [
            'title.required' => 'El título del libro es obligatorio.',
            'isbn.unique' => 'El ISBN ya está registrado.',
            'published_date.before_or_equal' => 'La fecha de publicación no puede ser futura.',
            'author_id.exists' => 'El autor seleccionado no existe.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $book = Book::create($validator->validated());

        return response()->json([
            'message' => 'Book created successfully',
            'data' => new BookResource($book->load('author'))
        ], 201);
    }

    public function show(Book $book): BookResource
    {
        return new BookResource($book->load('author'));
    }

    public function update(Request $request, Book $book): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|string|max:255',
            'isbn' => 'sometimes|string|unique:books,isbn,'.$book->id.'|max:20',
            'published_date' => 'sometimes|date|before_or_equal:today',
            'author_id' => 'sometimes|exists:authors,id'
        ], [
            'isbn.unique' => 'El ISBN ya está registrado.',
            'published_date.before_or_equal' => 'La fecha de publicación no puede ser futura.',
            'author_id.exists' => 'El autor seleccionado no existe.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $book->update($validator->validated());

        return response()->json([
            'message' => 'Book updated successfully',
            'data' => new BookResource($book->load('author'))
        ]);
    }

    public function destroy(Book $book): JsonResponse
    {
        $book->delete();
        return response()->json(null, 204);
    }
}