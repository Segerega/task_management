<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


// Project Routes
Route::middleware('auth:api')->group(function () {

    // Project routes
    Route::prefix('projects')->group(function () {

        // Project statistics
        Route::get('/statistics/{userId?}', [ProjectController::class, 'statistics']);

        Route::get('/', [ProjectController::class, 'index'])->name('projects.index');
        Route::get('/{projectId}', [ProjectController::class, 'show'])->name('projects.show');

        Route::middleware('checkProjectDeadline')->group(function () {
            Route::post('/', [ProjectController::class, 'store'])->name('projects.store');
            Route::put('/{projectId}', [ProjectController::class, 'update'])->name('projects.update');
            Route::delete('/{projectId}', [ProjectController::class, 'destroy'])->name('projects.destroy');
            // Restoring soft-deleted projects
            Route::post('/{projectId}/restore', [ProjectController::class, 'restore']);
        });
    });

    Route::prefix('tasks')->group(function () {

        // TaskController CRUD

        Route::get('/', [TaskController::class, 'index'])->name('task.index');
        Route::post('/', [TaskController::class, 'store'])->name('task.store');
        Route::put('/{taskId}', [TaskController::class, 'update'])->name('task.update');
        Route::get('/{taskId}', [TaskController::class, 'show'])->name('task.show');
        Route::delete('/{taskId}', [TaskController::class, 'destroy'])->name('task.destroy');

        // Assigning tasks
        Route::post('/{task}/assign/{userId?}', [TaskController::class, 'assign']);
    });
});
