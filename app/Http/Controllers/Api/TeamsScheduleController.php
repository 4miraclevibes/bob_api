<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TeamsSchedule;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class TeamsScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $query = TeamsSchedule::query();

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Filter by date range
        if ($request->has('start_date')) {
            $query->whereDate('start_time', '>=', $request->start_date);
        }
        if ($request->has('end_date')) {
            $query->whereDate('end_time', '<=', $request->end_date);
        }

        // Get schedules for specific date
        if ($request->has('date')) {
            $query->whereDate('start_time', $request->date);
        }

        $schedules = $query->orderBy('start_time', 'asc')->get();

        return response()->json([
            'success' => true,
            'data' => $schedules,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'teams_event_id' => 'required|string|unique:teams_schedules,teams_event_id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'location' => 'nullable|string|max:255',
            'attendees' => 'nullable|array',
            'meeting_link' => 'nullable|url',
            'is_all_day' => 'sometimes|boolean',
            'recurrence' => 'nullable|array',
            'status' => 'required|in:confirmed,tentative,cancelled',
        ]);

        $validated['last_synced_at'] = now();
        $schedule = TeamsSchedule::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Teams schedule created successfully',
            'data' => $schedule,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $schedule = TeamsSchedule::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $schedule,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $schedule = TeamsSchedule::findOrFail($id);

        $validated = $request->validate([
            'teams_event_id' => 'sometimes|string|unique:teams_schedules,teams_event_id,' . $id,
            'title' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'start_time' => 'sometimes|date',
            'end_time' => 'sometimes|date|after:start_time',
            'location' => 'nullable|string|max:255',
            'attendees' => 'nullable|array',
            'meeting_link' => 'nullable|url',
            'is_all_day' => 'sometimes|boolean',
            'recurrence' => 'nullable|array',
            'status' => 'sometimes|in:confirmed,tentative,cancelled',
        ]);

        $validated['last_synced_at'] = now();
        $schedule->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Teams schedule updated successfully',
            'data' => $schedule,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $schedule = TeamsSchedule::findOrFail($id);
        $schedule->delete();

        return response()->json([
            'success' => true,
            'message' => 'Teams schedule deleted successfully',
        ]);
    }
}
