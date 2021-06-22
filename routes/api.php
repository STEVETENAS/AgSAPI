<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\UserController;
use \App\Http\Controllers\ArchiveController;
use \App\Http\Controllers\CategoryController;
use \App\Http\Controllers\CourseController;
use \App\Http\Controllers\EventController;

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

//Protected Routes
Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::middleware(['auth','CheckRole'])->group( function () {
        Route::delete('user/{id}', [UserController::class,'destroy']);
        Route::get('users', [UserController::class,'index']);
    });
    Route::get('user/userId/{studId}', [UserController::class, 'getByStudId']);
    Route::post('user/logout', [UserController::class,'logout']);
    Route::get('user/fname/{name}', [UserController::class,'getByFName']);
    Route::get('user/lname/{name}', [UserController::class,'getByLName']);
    Route::get('user/{id}', [UserController::class,'show']);
    Route::put('user/{id}', [UserController::class,'update']);

    Route::get('event/Title/{title}', [EventController::class, 'getByTitle']);
    Route::get('event/StartDate/{dateDebut}', [EventController::class, 'getByStartDate']);
    Route::get('event/EndDate/{dateFin}', [EventController::class, 'getByEndDate']);
    Route::apiResource("events",EventController::class);

    Route::get('category/Name/{name}', [CategoryController::class, 'getByName']);
    Route::apiResource("categories",CategoryController::class);

    Route::get('archive/Name/{name}', [ArchiveController::class, 'getByName']);
    Route::get('archive/Date/{registeredDate}', [ArchiveController::class, 'getByDate']);
    Route::apiResource("archives",ArchiveController::class);

    Route::get('course/name/{name}', [CourseController::class, 'getByName']);
    Route::apiResource("courses",CourseController::class);
});

Route::post('register', [UserController::class,'register']);
Route::post('user/login', [UserController::class,'login']);




