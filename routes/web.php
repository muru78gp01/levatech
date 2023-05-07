<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;    //外部にあるPostController
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', [PostController::class, 'index']);
Route::get('/posts/create', [PostController::class, 'create']);
//ブログ投稿作成画面表示用のルーティング
Route::post('/posts', [PostController::class, 'store']);
//ブログ投稿作成実行用のルーティング
Route::get('/posts/{post}', [PostController::class , 'show']);
// 'posts/{対象データのID}'にGetリクエストが来たら、PostControllerのshowメソッドを実行する