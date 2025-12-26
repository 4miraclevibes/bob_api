<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CigaretteController;
use App\Http\Controllers\Api\FoodController;
use App\Http\Controllers\Api\ActivityController;
use App\Http\Controllers\Api\TransportController;
use App\Http\Controllers\Api\BiographyController;
use App\Http\Controllers\Api\LocationStateController;
use App\Http\Controllers\Api\PantryIngredientController;
use App\Http\Controllers\Api\RecipeController;
use App\Http\Controllers\Api\TeamsScheduleController;
use App\Http\Controllers\Api\PersonalScheduleController;
use App\Http\Controllers\Api\DailyLearningQuestionController;

/*
|--------------------------------------------------------------------------
| API Routes - Bob Personal Assistant API
|--------------------------------------------------------------------------
|
| Base URL: /api
|
*/

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Cigarettes Routes
Route::apiResource('cigarettes', CigaretteController::class);

// Foods Routes
Route::apiResource('foods', FoodController::class);

// Activities Routes
Route::apiResource('activities', ActivityController::class);
Route::post('activities/return-home', [ActivityController::class, 'returnHome']);

// Transport Routes
Route::apiResource('transport', TransportController::class);

// Biography Routes
Route::apiResource('biography', BiographyController::class);

// Location State Routes
Route::get('location-state', [LocationStateController::class, 'index']);
Route::post('location-state', [LocationStateController::class, 'store']);
Route::put('location-state', [LocationStateController::class, 'update']);

// Pantry Ingredients Routes
Route::apiResource('pantry-ingredients', PantryIngredientController::class);

// Recipes Routes
Route::apiResource('recipes', RecipeController::class);
Route::get('recipes/recommendations', [RecipeController::class, 'recommendations']);

// Teams Schedules Routes
Route::apiResource('teams-schedules', TeamsScheduleController::class);

// Personal Schedules Routes
Route::apiResource('personal-schedules', PersonalScheduleController::class);
Route::get('schedules/by-date', [PersonalScheduleController::class, 'getByDate']);

// Daily Learning Questions Routes
Route::apiResource('daily-learning-questions', DailyLearningQuestionController::class);
Route::get('daily-learning-questions/today', [DailyLearningQuestionController::class, 'today']);
Route::get('daily-learning-questions/search-topic', [DailyLearningQuestionController::class, 'searchTopic']);
