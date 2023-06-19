$(document).ready(function(){
  $('.add-item').click(function() {
    const itemHtml = '<div class="input-group mb-3">' +
        '<textarea class="form-control" name="item[]" rows="1" placeholder="材料"></textarea>' +
        '<div class="input-group-append">' +
        '<button class="btn btn-outline-secondary remove-item" type="button"><i class="fa fa-minus"></i></button>' +
        '</div>' +
        '</div>';

    $('#item-container').append(itemHtml);
  }); // add-itemのクリックイベントの終了

  $('.add-seasoning').click(function() {
    const seasoningHtml = '<div class="input-group mb-3">' +
        '<textarea class="form-control" name="seasoning[]" rows="1" placeholder="調味料"></textarea>' +
        '<div class="input-group-append">' +
        '<button class="btn btn-outline-secondary remove-seasoning" type="button"><i class="fa fa-minus"></i></button>' +
        '</div>' +
        '</div>';

    $('#seasoning-container').append(seasoningHtml);
  }); // add-seasoningのクリックイベントの終了

  // 材料削除ボタンのクリックイベント
  $(document).on('click', '.remove-item', function() {
    $(this).closest('.input-group').remove();
  });

  // 調味料削除ボタンのクリックイベント
  $(document).on('click', '.remove-seasoning', function() {
    $(this).closest('.input-group').remove();
  });
}); // document.readyの終了
