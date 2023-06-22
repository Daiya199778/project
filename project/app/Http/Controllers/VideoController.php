<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Google_Client;
use Google_Service_YouTube;

class VideoController extends Controller
{
    public function index(Request $request)
    {
        // Google Clientの設定
        $client = new Google_Client();
        // .envファイルからAPIキーを読み込む
        $client->setDeveloperKey(env('YOUTUBE_API_KEY')); 
        // YouTubeサービスの作成
        $youtube = new Google_Service_YouTube($client);

        // 検索キーワードをリクエストから取得
        $searchQuery = $request->input('q', '料理レシピ');

        // 動画の検索クエリを設定
        $searchResponse = $youtube->search->listSearch('snippet', [
            'q' => $searchQuery,
            'maxResults' => 9 // 取得する動画の最大数
        ]);

        // 動画一覧をビューに渡す
        return view('video.index', ['videos' => $searchResponse->getItems()]);
    }
}

