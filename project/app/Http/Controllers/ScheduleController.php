<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schedule;

class ScheduleController extends Controller
{

    /**
     * イベントを登録
     *
     * @param  Request  $request
     */

    //イベントの登録を行うためのアクションメソッド。
    //HTTPリクエストとして$requestオブジェクトを受け取るように設定。
    public function scheduleAdd(Request $request)
    {
        // 受け取ったデータをバリデーションにかける。
        $request->validate([
            //start_dateとend_dateは必須かつ整数であること。event_nameは必須かつ最大50文字までであること。
            'start_date' => 'required|integer',
            'end_date' => 'required|integer',
            'event_name' => 'required|max:50',
        ]);

        // 登録処理のインスタンスの作成
        $schedule = new Schedule;
        // 日付に変換。JavaScriptのタイムスタンプはミリ秒なので、全て秒に変換しておく。
        $schedule->start_date = date('Y-m-d', $request->input('start_date') / 1000);
        $schedule->end_date = date('Y-m-d', $request->input('end_date') / 1000);
        $schedule->event_name = $request->input('event_name');
        //$scheduleオブジェクトをデータベースに保存する。新しいスケジュールがデータベースに登録される。
        $schedule->save();

        return;
    }

    //scheduleGetメソッドは、カレンダーの表示範囲に応じたスケジュールを取得するためのメソッド。
    public function scheduleGet(Request $request)
    {
        // バリデーション
        $request->validate([
            'start_date' => 'required|integer',
            'end_date' => 'required|integer'
        ]);

        // カレンダー表示期間
        $start_date = date('Y-m-d', $request->input('start_date') / 1000);
        $end_date = date('Y-m-d', $request->input('end_date') / 1000);

        // モデルに対してクエリを実行してカレンダーの表示範囲内のスケジュールを取得する。
        return Schedule::query()
            ->select(
                // FullCalendarの形式に合わせる
                'start_date as start',
                'end_date as end',
                'event_name as title'
            )
            // FullCalendarの表示範囲のみ表示
            ->where('end_date', '>', $start_date)
            ->where('start_date', '<', $end_date)
            ->get();
    }
}
