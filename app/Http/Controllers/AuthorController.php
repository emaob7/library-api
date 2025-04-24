<?php

namespace App\Http\Controllers;

use App\Http\Resources\AuthorResource;
use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class AuthorController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $authors = Author::with('books')->paginate(10);
        return AuthorResource::collection($authors);
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'birthdate' => 'required|date|before_or_equal:today',
            'nationality' => 'required|string|max:100'
        ], [
            'name.required' => 'El nombre del autor es obligatorio.',
            'birthdate.before_or_equal' => 'La fecha de nacimiento no puede ser futura.',
            'nationality.required' => 'La nacionalidad es obligatoria.'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $author = Author::create($validator->validated());

        return response()->json([
            'message' => 'Author created successfully',
            'data' => new AuthorResource($author)
        ], 201);
    }

    public function show(Author $author): AuthorResource
    {
        return new AuthorResource($author->load('books'));
    }

    public function update(Request $request, Author $author): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:255',
            'birthdate' => 'sometimes|date|before_or_equal:today',
            'nationality' => 'sometimes|string|max:100'
        ], [
            'birthdate.before_or_equal' => 'La fecha de nacimiento no puede ser futura.'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $author->update($validator->validated());

        return response()->json([
            'message' => 'Author updated successfully',
            'data' => new AuthorResource($author->load('books'))
        ]);
    }

    public function destroy(Author $author): JsonResponse
    {
        $author->delete();
        return response()->json(null, 204);
    }
}