<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Food;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class FoodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $query = Food::query();

        // Filter by category
        if ($request->has('category')) {
            $query->where('category', $request->category);
        }

        // Filter by date range
        if ($request->has('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->has('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $foods = $query->orderBy('created_at', 'desc')->get();

        return response()->json([
            'success' => true,
            'data' => $foods,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'category' => 'required|in:food,drink,snack',
            'item_name' => 'required|string|max:255',
            'cost' => 'required|numeric|min:0',
            'quantity' => 'sometimes|integer|min:1',
            'location' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $food = Food::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Food record created successfully',
            'data' => $food,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $food = Food::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $food,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $food = Food::findOrFail($id);

        $validated = $request->validate([
            'category' => 'sometimes|in:food,drink,snack',
            'item_name' => 'sometimes|string|max:255',
            'cost' => 'sometimes|numeric|min:0',
            'quantity' => 'sometimes|integer|min:1',
            'location' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $food->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Food record updated successfully',
            'data' => $food,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $food = Food::findOrFail($id);
        $food->delete();

        return response()->json([
            'success' => true,
            'message' => 'Food record deleted successfully',
        ]);
    }
}
