import { Calendar } from "@fullcalendar/core";
import interactionPlugin from "@fullcalendar/interaction";
import dayGridPlugin from "@fullcalendar/daygrid";
import timeGridPlugin from "@fullcalendar/timegrid";
import listPlugin from "@fullcalendar/list";
import axios from 'axios';

const calendarEl = document.getElementById("calendar");

let calendar = new Calendar(calendarEl, {
    plugins: [interactionPlugin, dayGridPlugin, timeGridPlugin, listPlugin],
    initialView: "dayGridMonth",
    //カレンダーのヘッダーツールバーのコンテンツと配置を指定
    headerToolbar: {
        left: "prev,next today",
        center: "title",
        right: "dayGridMonth,timeGridWeek,listWeek",
    },
    locale: "ja",

    // カレンダー上で日付をクリックしたり範囲を選択したりできるように設定
    selectable: true,
    select: function (info) {
        //alert("selected " + info.startStr + " to " + info.endStr);

        // 入力ダイアログ
        const eventName = prompt("イベントを入力してください");

        if (eventName) {
            // axiosを使用して、カレンダー登録が成功した場合にカレンダー上にイベントを追加する
            axios
                .post("/schedule-add", {
                    start_date: info.start.valueOf(),
                    end_date: info.end.valueOf(),
                    event_name: eventName,
                    //URL（"/schedule-get"）に対してPOSTリクエストを送信する
                    //このリクエストはサーバーに対して３つのデータを送信する
                })
                .then(() => {
                    // イベントの追加
                    calendar.addEvent({
                        title: eventName,
                        start: info.start,
                        end: info.end,
                        allDay: true,
                    });
                })
                .catch(() => {
                    // バリデーションエラーなど
                    alert("登録に失敗しました");
                });
        }
    },
    events: function (info, successCallback, failureCallback) {
        // axiosを使用して、カレンダーが表示された際に表示期間内のイベントをサーバーから取得し、その取得したイベントをカレンダーに表示する
        axios
            .post("/schedule-get", {
                start_date: info.start.valueOf(),
                end_date: info.end.valueOf(),
                //URL（"/schedule-get"）に対してPOSTリクエストを送信する
                //このリクエストはサーバーに対してstart_dateとend_dateという2つのデータを送信する
            })
            //サーバーからのレスポンスが成功した場合に実行されるコールバック関数を下記に定義
            .then((response) => {
                // 追加したイベントを削除
                // calendar.removeAllEvents();
                // カレンダーに読み込み
                successCallback(response.data);
            })
            //もしリクエストが失敗した時の処理
            .catch(() => {
                // バリデーションエラーなど
                alert("登録に失敗しました");
            });
    },
    eventClick: function (info) {
        const deleteEvent = confirm("イベントを削除しますか？");
        if (deleteEvent) {
            const scheduleId = info.event.id;
            axios
                .post("/schedule-delete", {
                    schedule_id: scheduleId,
                })
                .then(() => {
                    info.event.remove();
                })
                .catch(() => {
                    alert("削除に失敗しました");
                });
        }
    },
    
});
calendar.render();