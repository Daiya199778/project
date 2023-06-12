<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>
    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        body {
            font-family: 'Nunito', sans-serif;
            /* padding: 20px; */
            background-color: #f1f1f1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            /* min-height: 100vh; */
        }

        #map {
            height: 650px;
            width: 100%;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            margin-bottom: 40px;
            align-items: center;
        }

        form input[type="text"],
        form button {
            margin-right: 10px;
            padding: 10px;
            font-size: 20px;
        }

        ul {
            list-style: none;
            padding-left: 0;
        }

        ul li {
            margin-bottom: 5px;
        }

        button {
            padding: 10px 20px;
            font-size: 23px;
        }
    </style>
</head>
<body class="antialiased">
    <div id="map"></div>

    <form>
        <input type="text" name="address" value="大阪市" id="address">
        <button type="button" id="button">検索</button>
    </form>

    <!-- <ul>
        <li>lat: <span id="lat"></span></li>
        <li>lng: <span id="lng"></span></li>
    </ul> -->

    <button onclick="window.location.href='/post'" style="margin-bottom: 20px;">　　投稿一覧に戻る　　</button>

    <script src="{{ asset('js/map.js') }}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?language=ja&region=JP&key=AIzaSyBAQDf8slF_4FDX5Wadz8kB-MMP2ucsLTI&callback=initMap" async defer></script>
</body>
</html>



