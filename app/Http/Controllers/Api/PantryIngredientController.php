<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PantryIngredient;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PantryIngredientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $query = PantryIngredient::query();

        // Filter by category
        if ($request->has('category')) {
            $query->where('category', $request->category);
        }

        // Filter active only
        if ($request->has('active_only')) {
            $query->where('is_active', true);
        }

        // Filter low stock
        if ($request->has('low_stock')) {
            $query->whereColumn('quantity', '<=', 'min_quantity');
        }

        $ingredients = $query->orderBy('ingredient_name')->get();

        return response()->json([
            'success' => true,
            'data' => $ingredients,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'ingredient_name' => 'required|string|max:255',
            'category' => 'required|in:grain,spice,vegetable,meat,dairy,oil,sauce,lainnya',
            'unit' => 'required|string|max:50',
            'quantity' => 'required|numeric|min:0',
            'min_quantity' => 'nullable|numeric|min:0',
            'expiry_date' => 'nullable|date',
            'purchase_date' => 'nullable|date',
            'purchase_price' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
            'is_active' => 'sometimes|boolean',
        ]);

        $ingredient = PantryIngredient::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Pantry ingredient created successfully',
            'data' => $ingredient,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $ingredient = PantryIngredient::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $ingredient,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $ingredient = PantryIngredient::findOrFail($id);

        $validated = $request->validate([
            'ingredient_name' => 'sometimes|string|max:255',
            'category' => 'sometimes|in:grain,spice,vegetable,meat,dairy,oil,sauce,lainnya',
            'unit' => 'sometimes|string|max:50',
            'quantity' => 'sometimes|numeric|min:0',
            'min_quantity' => 'nullable|numeric|min:0',
            'expiry_date' => 'nullable|date',
            'purchase_date' => 'nullable|date',
            'purchase_price' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
            'is_active' => 'sometimes|boolean',
        ]);

        $ingredient->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Pantry ingredient updated successfully',
            'data' => $ingredient,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $ingredient = PantryIngredient::findOrFail($id);
        $ingredient->delete();

        return response()->json([
            'success' => true,
            'message' => 'Pantry ingredient deleted successfully',
        ]);
    }
}
