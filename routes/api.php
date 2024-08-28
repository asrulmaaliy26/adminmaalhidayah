<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\HomepageController;
/*
|--------------------------------------------------------------------------
| APIRoutes
|-------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/articles', [HomepageController::class, 'index']);
Route::get('/articles/{total}/paginasi', [HomepageController::class, 'getArticlesPaginasi']);
Route::get('/article/{slug}', [HomepageController::class, 'getOneArticle']);

Route::get('/categories', [HomepageController::class, 'getCategory']);
Route::get('/jenises', [HomepageController::class, 'getJenis']);
Route::get('/pendidikans', [HomepageController::class, 'getPendidikan']);
Route::get('/tingkats', [HomepageController::class, 'getTingkat']);

// Route untuk mendapatkan artikel berdasarkan 2 tipe tertentu
Route::get('/articles/{type}/{typeSlug}', [HomepageController::class, 'getArticleByOneTypes']);

// Route untuk mendapatkan artikel berdasarkan 2 tipe tertentu
Route::get('/articles/{type1}/{type1Slug}/{type2}/{type2Slug}', [HomepageController::class, 'getArticleByTwoTypes']);

// Route untuk mendapatkan artikel berdasarkan 3 tipe tertentu
Route::get('/articles/{type1}/{type1Slug}/{type2}/{type2Slug}/{type3}/{type3Slug}', [HomepageController::class, 'getArticleByThreeTypes']);

// Route untuk mendapatkan artikel berdasarkan 4 tipe tertentu
Route::get('/articles/{type1}/{type1Slug}/{type2}/{type2Slug}/{type3}/{type3Slug}/{type4}/{type4Slug}', [HomepageController::class, 'getArticleByFourTypes']);

Route::get('/page/{slug}', [HomepageController::class, 'page']);
Route::get('/contact', [HomepageController::class, 'getContact']);
Route::post('/contact', [HomepageController::class, 'postContact']);
