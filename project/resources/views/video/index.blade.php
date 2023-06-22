<html>
<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Nunito', sans-serif;
            padding: 20px;
            background-color: #f1f1f1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }
        
        .video-title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }
        
        .video-search {
            margin-bottom: 20px;
        }
        
        .video-list {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            list-style-type: none;
            padding: 0;
        }
        
        .video-item {
            width: calc(33.33% - 20px);
            margin-bottom: 20px;
        }
        
        .video-item iframe {
            width: 100%;
            height: 300px;
        }
        
        button {
            padding: 10px 25px;
            font-size: 23px;
            background-color: #808080;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
    </style>
</head>
<body class="antialiased">
    <h1 class="video-title" style="font-size: 30px;">料理動画一覧</h1>

    <div class="video-search">
        <input type="text" id="searchInput" placeholder="動画を検索" style="width: 400px; height: 45px; font-size: 17px; vertical-align: middle;">
        <button onclick="searchVideos()" style="width: 100px; font-size: 17px; vertical-align: middle;">検索</button>
    </div>


    <ul class="video-list">
        @foreach ($videos as $video)
            <li class="video-item">
                <div>
                    <iframe width="560" height="315" src="https://www.youtube.com/embed/{{ $video->id->videoId }}" frameborder="0" allowfullscreen></iframe>
                </div>
                <div>
                    <a href="https://www.youtube.com/watch?v={{ $video->id->videoId }}">{{ $video->snippet->title }}</a>
                </div>
            </li>
        @endforeach
    </ul>
    
    <button onclick="window.location.href='/post'">投稿一覧に戻る</button>
    
    <script>
        function searchVideos() {
            var input = document.getElementById("searchInput");
            var searchQuery = input.value;
            window.location.href = "/videos?q=" + searchQuery;
        }
    </script>
</body>
</html>
