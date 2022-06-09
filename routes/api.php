<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RssParserController;
use App\Http\Controllers\PostsController;
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

//PARSE
Route::get('parse', [RssParserController::class, 'parseRss']);

//CRUD FOR POSTS
Route::get('posts', [PostsController::class, 'getAllPosts']);
Route::get('posts/{id}', [PostsController::class, 'getOnePost']);

Route::post('posts-create', [PostsController::class, 'createPost']);
Route::put('posts/{id}', [PostsController::class, 'updatePost']);
Route::delete('posts/{id}', [PostsController::class, 'deletePost']);
