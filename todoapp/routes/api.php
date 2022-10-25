<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TodoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



Route::group([
    "prefix" => 'auth'
], function (){
    Route::post('login', [AuthController::class, "login"]);
    Route::post('register', [AuthController::class, "register"]);
    Route::group([
        "middleware" => "auth:api"
    ], function (){
        Route::post('logout', [AuthController::class, "logout"]);
        Route::post('data', [AuthController::class, "data"]);
        Route::post('refresh', [AuthController::class, "refresh"]);
    });
});

 Route::group([
        "middleware" => "auth:api"
    ], function (){
       Route::get("/todo",[ TodoController::class, 'getTodoList'])->name('todo.index');
        Route::post("/todo", [TodoController::class, "createTodo"])->name('todo.create');
        Route::put("/todo/{id}", [TodoController::class, "updateTodo"])->name('todo.update');
        Route::delete("/todo/{id}", [TodoController::class, "deleteTodo"])->name('todo.delete');
    });