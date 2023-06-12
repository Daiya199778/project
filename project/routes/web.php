<?php

use Illuminate\Support\Facades\Route;
/*['except' => []]にすることで、全アクションを使えるようにしている。*/
use App\Http\Controllers\PostsController;
Route::resource('post', PostsController::class, ['except' => ['show']]);

//マップ画面へ遷移するためのルーティング
Route::get('/map', function () {
    return view('map');
});

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
