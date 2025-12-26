<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LocationState;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class LocationStateController extends Controller
{
    /**
     * Get current location state
     */
    public function index(): JsonResponse
    {
        $locationState = LocationState::first();

        if (!$locationState) {
            return response()->json([
                'success' => false,
                'message' => 'Location state not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $locationState,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:inside,outside',
            'last_activity' => 'nullable|string|max:255',
            'current_location' => 'nullable|string|max:255',
        ]);

        // Update existing or create new
        $locationState = LocationState::first();
        
        if ($locationState) {
            $locationState->update($validated);
            $locationState->touch();
        } else {
            $validated['updated_at'] = now();
            $locationState = LocationState::create($validated);
        }

        return response()->json([
            'success' => true,
            'message' => 'Location state updated successfully',
            'data' => $locationState,
        ], 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request): JsonResponse
    {
        $locationState = LocationState::firstOrFail();

        $validated = $request->validate([
            'status' => 'sometimes|in:inside,outside',
            'last_activity' => 'nullable|string|max:255',
            'current_location' => 'nullable|string|max:255',
        ]);

        $locationState->update($validated);
        $locationState->touch();

        return response()->json([
            'success' => true,
            'message' => 'Location state updated successfully',
            'data' => $locationState,
        ]);
    }
}
