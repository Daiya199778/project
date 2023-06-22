<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\VideoController;

/*['except' => []]にすることで、全アクションを使えるようにしている。*/
Route::resource('post', PostsController::class, ['except' => ['show']]);

//マップ画面へ遷移するためのルーティング
Route::get('/map', function () {
    return view('map');
});

//カレンダー画面へ遷移するためのルーティング
Route::get('/calendar', function () {
    return view('calendar');
});

// イベント登録処理
Route::post('/schedule-add', [ScheduleController::class, 'scheduleAdd'])->name('schedule-add');
// イベント取得処理
Route::post('/schedule-get', [ScheduleController::class, 'scheduleGet'])->name('schedule-get');
// イベント削除処理
Route::post('/schedule-delete', [ScheduleController::class, 'scheduleDelete'])->name('schedule-delete');

//動画画面へのルーティング
Route::get('/videos', [VideoController::class, 'index'])->name('videos.index');


Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
