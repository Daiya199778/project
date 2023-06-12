const inputAddress = document.getElementById("address");
const button = document.getElementById("button");
button.onclick = initMap;

function initMap() {
  const map = new google.maps.Map(document.getElementById("map"), {
    zoom: 15, // 地図の尺度
    mapTypeId: google.maps.MapTypeId.ROADMAP, // マップタイプ（ROADMAPはデフォルトのもの）
  });

  const geocoder = new google.maps.Geocoder(); // Googlgのサーバーと通信するためのインスタンスを生成
  geocoder.geocode(
    {
      address: inputAddress.value, // フォームに入力された値を渡す
      region: "jp",
    },
    function (result, status) {
      // ↑の検索結果に対しての処理
      if (status == google.maps.GeocoderStatus.OK) {
        const location = result[0].geometry.location;
        const marker = new google.maps.Marker({
          position: location, // 検索結果の緯度・経度を設定
          map: map, // マップの描画設定
          title: location.toString(), // アイコンにカーソルが重なった際に表示されるテキスト
          draggable: true, // trueにすることでアイコンを自由に移動できる
        });

        map.setCenter(location); // マップ中央にアイコンが表示される
        document.getElementById("lat").textContent = location.lat();
        document.getElementById("lng").textContent = location.lng();

        google.maps.event.addListener(
          // アイコンが移動した際に発火するイベントを登録
          marker,
          "dragend",
          function (event) {
            const latLng = event.latLng; // 移動したアイコンの座標を取得
            marker.setTitle(latLng.toString());
            document.getElementById("lat").textContent = latLng.lat();
            document.getElementById("lng").textContent = latLng.lng();

            const geocoder = new google.maps.Geocoder();
            geocoder.geocode(
              // 取得した座標で再描画
              { location: latLng },
              function (result, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                  // 住所を取得してフォームに値を入れる
                  let address = "";
                  const addressComponents = result[0].address_components;
                  for (let i = 0; i < addressComponents.length - 2; i++) {
                    address = addressComponents[i].long_name + address;
                  }
                  inputAddress.value = address;
                }
              }
            );
          }
        );
      } else {
        alert("住所を確認してください"); // フォームに入力された住所から、座標が取得できなかった場合のアラート
      }
    }
  );
}

