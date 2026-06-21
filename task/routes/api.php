<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


// user register

Route::post("register",[UserController::class,'register']);
Route::post("login",[UserController::class,'login']);



Route::middleware('auth:sanctum')->group(function(){
    Route::get("userInfo",[UserController::class,'getUser']);


    Route::post("logout",[UserController::class,'logout']);

    Route::apiResource("tasks",TaskController::class);
    Route::apiResource("profiles",ProfileController::class);

    Route::prefix('users')->group(function(){
        Route::get("/{id}/profile",[UserController::class,'getProfile']);
        Route::get("/{id}/tasks",[UserController::class,'getTasks']);
        });

        Route::get('task/ordered',[TaskController::class,'getTasksByPriority']);
        Route::prefix('tasks')->group(function(){
            Route::get('/getTasks',[TaskController::class,'getAllTasks'])->middleware('isAdmin');
            Route::post('/{id}/categories',[TaskController::class,'addCategoryTask']);

            Route::get('/{id}/favorites',[TaskController::class,'getFavorite']);
            Route::post('/{id}/favorites',[TaskController::class,'addFavorite']);
            Route::delete('/{id}/favorites',[TaskController::class,'deleteFavorite']);
    });

    Route::get('categories/{id}/tasks',[TaskController::class,'getTasksCat']);
});





