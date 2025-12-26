<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PersonalSchedule;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PersonalScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $query = PersonalSchedule::query();

        // Filter by activity type
        if ($request->has('activity_type')) {
            $query->where('activity_type', $request->activity_type);
        }

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Filter by date range
        if ($request->has('start_date')) {
            $query->whereDate('schedule_date', '>=', $request->start_date);
        }
        if ($request->has('end_date')) {
            $query->whereDate('schedule_date', '<=', $request->end_date);
        }

        // Get schedules for specific date
        if ($request->has('date')) {
            $query->whereDate('schedule_date', $request->date);
        }

        $schedules = $query->orderBy('schedule_date', 'asc')
            ->orderBy('start_time', 'asc')
            ->get();

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
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'schedule_date' => 'required|date',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after:start_time',
            'location' => 'nullable|string|max:255',
            'activity_type' => 'required|in:minisoccer,futsal,nongkrong,belanja,lainnya',
            'is_all_day' => 'sometimes|boolean',
            'reminder_before' => 'nullable|integer|min:0',
            'status' => 'sometimes|in:scheduled,completed,cancelled',
            'notes' => 'nullable|string',
        ]);

        $schedule = PersonalSchedule::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Personal schedule created successfully',
            'data' => $schedule,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $schedule = PersonalSchedule::findOrFail($id);

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
        $schedule = PersonalSchedule::findOrFail($id);

        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'schedule_date' => 'sometimes|date',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after:start_time',
            'location' => 'nullable|string|max:255',
            'activity_type' => 'sometimes|in:minisoccer,futsal,nongkrong,belanja,lainnya',
            'is_all_day' => 'sometimes|boolean',
            'reminder_before' => 'nullable|integer|min:0',
            'status' => 'sometimes|in:scheduled,completed,cancelled',
            'notes' => 'nullable|string',
        ]);

        $schedule->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Personal schedule updated successfully',
            'data' => $schedule,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $schedule = PersonalSchedule::findOrFail($id);
        $schedule->delete();

        return response()->json([
            'success' => true,
            'message' => 'Personal schedule deleted successfully',
        ]);
    }

    /**
     * Get schedules for a specific date (combines Teams and Personal)
     */
    public function getByDate(Request $request): JsonResponse
    {
        $request->validate([
            'date' => 'required|date',
        ]);

        $teamsSchedules = \App\Models\TeamsSchedule::whereDate('start_time', $request->date)
            ->where('status', '!=', 'cancelled')
            ->get();

        $personalSchedules = PersonalSchedule::whereDate('schedule_date', $request->date)
            ->where('status', '!=', 'cancelled')
            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'teams_schedules' => $teamsSchedules,
                'personal_schedules' => $personalSchedules,
                'total' => $teamsSchedules->count() + $personalSchedules->count(),
                'is_free' => ($teamsSchedules->count() + $personalSchedules->count()) === 0,
            ],
        ]);
    }
}
