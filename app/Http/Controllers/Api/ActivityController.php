<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $query = Activity::query();

        // Filter by activity type
        if ($request->has('activity_type')) {
            $query->where('activity_type', $request->activity_type);
        }

        // Filter by location status
        if ($request->has('location_status')) {
            $query->where('location_status', $request->location_status);
        }

        // Filter active activities
        if ($request->has('is_active')) {
            $query->where('is_active', filter_var($request->is_active, FILTER_VALIDATE_BOOLEAN));
        }

        // Get current location
        if ($request->has('current')) {
            $activity = Activity::where('is_active', true)
                ->orderBy('started_at', 'desc')
                ->first();

            return response()->json([
                'success' => true,
                'data' => $activity,
            ]);
        }

        $activities = $query->orderBy('started_at', 'desc')->get();

        return response()->json([
            'success' => true,
            'data' => $activities,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'activity_type' => 'required|in:beli_makan,nongkrong,futsal,tidur,lainnya',
            'description' => 'nullable|string',
            'location_status' => 'required|in:outside,inside',
            'started_at' => 'required|date',
            'ended_at' => 'nullable|date',
            'is_active' => 'sometimes|boolean',
            'notes' => 'nullable|string',
        ]);

        $activity = Activity::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Activity created successfully',
            'data' => $activity,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $activity = Activity::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $activity,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $activity = Activity::findOrFail($id);

        $validated = $request->validate([
            'activity_type' => 'sometimes|in:beli_makan,nongkrong,futsal,tidur,lainnya',
            'description' => 'nullable|string',
            'location_status' => 'sometimes|in:outside,inside',
            'started_at' => 'sometimes|date',
            'ended_at' => 'nullable|date',
            'is_active' => 'sometimes|boolean',
            'notes' => 'nullable|string',
        ]);

        $activity->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Activity updated successfully',
            'data' => $activity,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $activity = Activity::findOrFail($id);
        $activity->delete();

        return response()->json([
            'success' => true,
            'message' => 'Activity deleted successfully',
        ]);
    }

    /**
     * Mark activity as returned home
     */
    public function returnHome(): JsonResponse
    {
        $activeActivity = Activity::where('is_active', true)
            ->orderBy('started_at', 'desc')
            ->first();

        if (!$activeActivity) {
            return response()->json([
                'success' => false,
                'message' => 'No active activity found',
            ], 404);
        }

        $activeActivity->update([
            'location_status' => 'inside',
            'is_active' => false,
            'ended_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Activity marked as returned home',
            'data' => $activeActivity,
        ]);
    }
}
