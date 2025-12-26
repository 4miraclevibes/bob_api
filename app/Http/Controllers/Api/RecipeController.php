<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Recipe;
use App\Models\PantryIngredient;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class RecipeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $query = Recipe::query();

        // Filter by category
        if ($request->has('category')) {
            $query->where('category', $request->category);
        }

        // Filter by difficulty
        if ($request->has('difficulty')) {
            $query->where('difficulty', $request->difficulty);
        }

        // Filter favorites
        if ($request->has('favorite_only')) {
            $query->where('is_favorite', true);
        }

        // Search by tags
        if ($request->has('tag')) {
            $query->whereJsonContains('tags', $request->tag);
        }

        $recipes = $query->orderBy('is_favorite', 'desc')
            ->orderBy('cook_count', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $recipes,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'recipe_name' => 'required|string|max:255',
            'category' => 'required|in:rice,noodle,soup,fried,boiled,lainnya',
            'difficulty' => 'required|in:easy,medium,hard',
            'cooking_time' => 'nullable|integer|min:1',
            'servings' => 'nullable|integer|min:1',
            'ingredients' => 'required|array',
            'ingredients.*.ingredient_name' => 'required|string',
            'ingredients.*.quantity' => 'required|numeric|min:0',
            'ingredients.*.unit' => 'required|string',
            'instructions' => 'nullable|string',
            'tags' => 'nullable|array',
            'is_favorite' => 'sometimes|boolean',
            'notes' => 'nullable|string',
        ]);

        $recipe = Recipe::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Recipe created successfully',
            'data' => $recipe,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $recipe = Recipe::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $recipe,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $recipe = Recipe::findOrFail($id);

        $validated = $request->validate([
            'recipe_name' => 'sometimes|string|max:255',
            'category' => 'sometimes|in:rice,noodle,soup,fried,boiled,lainnya',
            'difficulty' => 'sometimes|in:easy,medium,hard',
            'cooking_time' => 'nullable|integer|min:1',
            'servings' => 'nullable|integer|min:1',
            'ingredients' => 'sometimes|array',
            'ingredients.*.ingredient_name' => 'required_with:ingredients|string',
            'ingredients.*.quantity' => 'required_with:ingredients|numeric|min:0',
            'ingredients.*.unit' => 'required_with:ingredients|string',
            'instructions' => 'nullable|string',
            'tags' => 'nullable|array',
            'is_favorite' => 'sometimes|boolean',
            'notes' => 'nullable|string',
        ]);

        $recipe->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Recipe updated successfully',
            'data' => $recipe,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $recipe = Recipe::findOrFail($id);
        $recipe->delete();

        return response()->json([
            'success' => true,
            'message' => 'Recipe deleted successfully',
        ]);
    }

    /**
     * Get recipe recommendations based on available ingredients
     */
    public function recommendations(): JsonResponse
    {
        // Get all active ingredients with quantity > 0
        $availableIngredients = PantryIngredient::where('is_active', true)
            ->where('quantity', '>', 0)
            ->get()
            ->keyBy('ingredient_name');

        // Get all recipes
        $recipes = Recipe::all();
        $recommendations = [];

        foreach ($recipes as $recipe) {
            $canMake = true;
            $missingIngredients = [];

            foreach ($recipe->ingredients as $requiredIngredient) {
                $ingredientName = $requiredIngredient['ingredient_name'];
                $requiredQuantity = $requiredIngredient['quantity'];

                if (!isset($availableIngredients[$ingredientName])) {
                    $canMake = false;
                    $missingIngredients[] = $ingredientName;
                    break;
                }

                $availableQuantity = $availableIngredients[$ingredientName]->quantity;
                if ($availableQuantity < $requiredQuantity) {
                    $canMake = false;
                    $missingIngredients[] = $ingredientName;
                    break;
                }
            }

            if ($canMake) {
                $recommendations[] = $recipe;
            }
        }

        // Shuffle recommendations for random selection
        shuffle($recommendations);

        return response()->json([
            'success' => true,
            'data' => $recommendations,
            'count' => count($recommendations),
        ]);
    }
}
