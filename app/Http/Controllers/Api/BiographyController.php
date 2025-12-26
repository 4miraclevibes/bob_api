<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Biography;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class BiographyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $query = Biography::query();

        // Filter by category
        if ($request->has('category')) {
            $query->where('category', $request->category);
        }

        // Filter by public only
        if ($request->has('public_only')) {
            $query->where('is_public', true);
        }

        // Search by tags
        if ($request->has('tag')) {
            $query->whereJsonContains('tags', $request->tag);
        }

        // Search by title or content
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $biographies = $query->orderBy('priority', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $biographies,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'category' => 'required|in:personal_info,education,daily_story,preference,lainnya',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'tags' => 'nullable|array',
            'is_public' => 'sometimes|boolean',
            'priority' => 'sometimes|integer',
        ]);

        $biography = Biography::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Biography created successfully',
            'data' => $biography,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $biography = Biography::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $biography,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $biography = Biography::findOrFail($id);

        $validated = $request->validate([
            'category' => 'sometimes|in:personal_info,education,daily_story,preference,lainnya',
            'title' => 'sometimes|string|max:255',
            'content' => 'sometimes|string',
            'tags' => 'nullable|array',
            'is_public' => 'sometimes|boolean',
            'priority' => 'sometimes|integer',
        ]);

        $biography->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Biography updated successfully',
            'data' => $biography,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $biography = Biography::findOrFail($id);
        $biography->delete();

        return response()->json([
            'success' => true,
            'message' => 'Biography deleted successfully',
        ]);
    }
}
