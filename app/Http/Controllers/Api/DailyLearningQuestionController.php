<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DailyLearningQuestion;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;

class DailyLearningQuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $query = DailyLearningQuestion::query();

        // Filter by category
        if ($request->has('category')) {
            $query->where('category', $request->category);
        }

        // Filter by difficulty
        if ($request->has('difficulty')) {
            $query->where('difficulty', $request->difficulty);
        }

        // Filter answered/unanswered
        if ($request->has('is_answered')) {
            $query->where('is_answered', filter_var($request->is_answered, FILTER_VALIDATE_BOOLEAN));
        }

        // Search by keywords or tags
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('question', 'like', "%{$search}%")
                  ->orWhere('answer', 'like', "%{$search}%")
                  ->orWhereJsonContains('tags', $search)
                  ->orWhereJsonContains('keywords', $search);
            });
        }

        $questions = $query->orderBy('given_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $questions,
        ]);
    }

    /**
     * Get today's question
     */
    public function today(): JsonResponse
    {
        $today = Carbon::today();
        
        // Check if there's already a question for today
        $todayQuestion = DailyLearningQuestion::whereDate('given_date', $today)->first();

        if ($todayQuestion) {
            return response()->json([
                'success' => true,
                'data' => $todayQuestion,
            ]);
        }

        // Get questions that haven't been given in the last 30 days
        $thirtyDaysAgo = Carbon::today()->subDays(30);
        $availableQuestions = DailyLearningQuestion::where(function($query) use ($thirtyDaysAgo) {
            $query->whereNull('given_date')
                  ->orWhere('given_date', '<', $thirtyDaysAgo);
        })->get();

        if ($availableQuestions->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No available questions. All questions have been given in the last 30 days.',
            ], 404);
        }

        // Select random question
        $selectedQuestion = $availableQuestions->random();
        $selectedQuestion->update([
            'given_date' => $today,
            'is_answered' => false,
        ]);

        return response()->json([
            'success' => true,
            'data' => $selectedQuestion->fresh(),
        ]);
    }

    /**
     * Search if topic has been discussed before
     */
    public function searchTopic(Request $request): JsonResponse
    {
        $request->validate([
            'topic' => 'required|string',
        ]);

        $topic = strtolower($request->topic);
        
        $questions = DailyLearningQuestion::where(function($query) use ($topic) {
            $query->where('question', 'like', "%{$topic}%")
                  ->orWhere('answer', 'like', "%{$topic}%")
                  ->orWhereJsonContains('tags', $topic)
                  ->orWhereJsonContains('keywords', $topic);
        })->whereNotNull('given_date')
          ->orderBy('given_date', 'desc')
          ->get();

        if ($questions->isEmpty()) {
            return response()->json([
                'success' => true,
                'found' => false,
                'message' => "Belum pernah bahas tentang {$request->topic}",
                'data' => [],
            ]);
        }

        return response()->json([
            'success' => true,
            'found' => true,
            'message' => "Pernah bahas tentang {$request->topic}",
            'data' => $questions,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'question' => 'required|string',
            'answer' => 'nullable|string',
            'category' => 'required|in:algorithm,data_structure,design_pattern,architecture,database,security,performance,testing,best_practice,lainnya',
            'difficulty' => 'required|in:beginner,intermediate,advanced',
            'tags' => 'required|array',
            'keywords' => 'nullable|array',
            'source' => 'nullable|string|max:255',
            'related_resources' => 'nullable|array',
            'notes' => 'nullable|string',
        ]);

        $question = DailyLearningQuestion::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Daily learning question created successfully',
            'data' => $question,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $question = DailyLearningQuestion::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $question,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $question = DailyLearningQuestion::findOrFail($id);

        $validated = $request->validate([
            'question' => 'sometimes|string',
            'answer' => 'nullable|string',
            'category' => 'sometimes|in:algorithm,data_structure,design_pattern,architecture,database,security,performance,testing,best_practice,lainnya',
            'difficulty' => 'sometimes|in:beginner,intermediate,advanced',
            'tags' => 'sometimes|array',
            'keywords' => 'nullable|array',
            'given_date' => 'nullable|date',
            'discussed_at' => 'nullable|date',
            'is_answered' => 'sometimes|boolean',
            'source' => 'nullable|string|max:255',
            'related_resources' => 'nullable|array',
            'content_shared' => 'sometimes|boolean',
            'notes' => 'nullable|string',
        ]);

        if (isset($validated['answer']) && !$question->is_answered) {
            $validated['is_answered'] = true;
            $validated['discussed_at'] = now();
        }

        $question->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Daily learning question updated successfully',
            'data' => $question,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $question = DailyLearningQuestion::findOrFail($id);
        $question->delete();

        return response()->json([
            'success' => true,
            'message' => 'Daily learning question deleted successfully',
        ]);
    }
}
