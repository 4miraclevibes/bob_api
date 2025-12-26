<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cigarette;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CigaretteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $query = Cigarette::query();

        // Filter by type
        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        // Filter by date range
        if ($request->has('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->has('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $cigarettes = $query->orderBy('created_at', 'desc')->get();

        return response()->json([
            'success' => true,
            'data' => $cigarettes,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'type' => 'required|in:purchase,consume',
            'brand' => 'nullable|string|max:255',
            'quantity' => 'required|integer|min:1',
            'price' => 'nullable|numeric|min:0',
            'total_price' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        $cigarette = Cigarette::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Cigarette record created successfully',
            'data' => $cigarette,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $cigarette = Cigarette::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $cigarette,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $cigarette = Cigarette::findOrFail($id);

        $validated = $request->validate([
            'type' => 'sometimes|in:purchase,consume',
            'brand' => 'nullable|string|max:255',
            'quantity' => 'sometimes|integer|min:1',
            'price' => 'nullable|numeric|min:0',
            'total_price' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        $cigarette->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Cigarette record updated successfully',
            'data' => $cigarette,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $cigarette = Cigarette::findOrFail($id);
        $cigarette->delete();

        return response()->json([
            'success' => true,
            'message' => 'Cigarette record deleted successfully',
        ]);
    }
}
