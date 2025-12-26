<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transport;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class TransportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $query = Transport::query();

        // Filter by type
        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        // Filter by vehicle type
        if ($request->has('vehicle_type')) {
            $query->where('vehicle_type', $request->vehicle_type);
        }

        // Filter by date range
        if ($request->has('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->has('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $transports = $query->orderBy('created_at', 'desc')->get();

        return response()->json([
            'success' => true,
            'data' => $transports,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'type' => 'required|in:fuel,service,maintenance,lainnya',
            'vehicle_type' => 'nullable|string|max:255',
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'service_items' => 'nullable|array',
            'service_items.*.item' => 'required_with:service_items|string',
            'service_items.*.price' => 'required_with:service_items|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        $transport = Transport::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Transport record created successfully',
            'data' => $transport,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $transport = Transport::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $transport,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $transport = Transport::findOrFail($id);

        $validated = $request->validate([
            'type' => 'sometimes|in:fuel,service,maintenance,lainnya',
            'vehicle_type' => 'nullable|string|max:255',
            'amount' => 'sometimes|numeric|min:0',
            'description' => 'nullable|string',
            'service_items' => 'nullable|array',
            'service_items.*.item' => 'required_with:service_items|string',
            'service_items.*.price' => 'required_with:service_items|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        $transport->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Transport record updated successfully',
            'data' => $transport,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $transport = Transport::findOrFail($id);
        $transport->delete();

        return response()->json([
            'success' => true,
            'message' => 'Transport record deleted successfully',
        ]);
    }
}
