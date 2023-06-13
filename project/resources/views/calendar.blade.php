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
            
            #calendar {
                width: 80%; 
                margin-bottom: 40px;
            }

            button {
                padding: 10px 25px;
                font-size: 23px;
            }
            
        </style>
    </head>
    <body class="antialiased">
        <div id='calendar'></div>
        <button onclick="window.location.href='/post'" style="margin-bottom: 20px; background-color: #808080; color: white; border: none; padding: 10px 20px; border-radius: 4px; cursor: pointer;">　投稿一覧に戻る　</button>
    </body>
</html>