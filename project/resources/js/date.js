// date.js

document.addEventListener("DOMContentLoaded", function () {
  const dateField = document.getElementById("date");

  dateField.addEventListener("change", function () {
      const selectedDate = dateField.value;

      if (selectedDate) {
          const calendarEl = document.getElementById("calendar");

          const calendar = new FullCalendar.Calendar(calendarEl, {
              // カレンダーの設定オプション
              // ...
              events: [
                  {
                      title: "イベント",
                      start: selectedDate,
                  },
              ],
          });

          calendar.render();
      }
  });
});
