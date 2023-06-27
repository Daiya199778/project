<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Http\Requests\PostRequest;
//S3へ接続するために必要
use Illuminate\Support\Facades\Storage;
//日時の取得
use Carbon\Carbon;

class PostsController extends Controller

{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      //検索機能の記述追加（when文へ変更）
      $posts = Post::orderBy('created_at', 'desc')
        ->when(request('search'), function ($query, $search) {
            return $query->where('name', 'LIKE', "%{$search}%")
            ->orWhere('item', 'LIKE', "%{$search}%");
        })
        ->paginate(3);


        return view(
            'post.index',
            ['posts' => $posts]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('post.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request)
{
    // 画像フォームでリクエストした画像を取得
    $image = $request->file('image');

    // 画像情報がセットされていれば、保存処理を実行
    if (isset($image)) {
        // storage > public > img配下に画像が保存される
        $path = $image->store('image', 'public');

        // S3に画像を保存するための記述
        // $path = Storage::disk('s3')->put('images', $image, 'public');

    } else {
        $path = null; // 画像が追加されていない場合は、$path を null に設定
    }

    //carbonライブラリを利用して日付を文字列に変換している
    $date = Carbon::parse($request->input('date'))->toDateString();

    // リクエストデータを使用して新しいPostモデルを作成し、データベースに保存
    $post = new Post();
    $post->user_id = auth()->user()->id; // ログインユーザーのIDを設定
    $post->name = $request->input('name'); // 料理名を設定
    $post->body = $request->input('body'); // 内容を設定
    //implode()関数を使って配列を改行区切りの文字列に変換すること、配列を文字列に変換できるため正常に作成ができる。
    $post->item = implode("\n", $request->input('item'));
    //implode()関数を使って配列を改行区切りの文字列に変換すること、配列を文字列に変換できるため正常に作成ができる。
    $post->seasoning = implode("\n", $request->input('seasoning'));
    $post->image = $path; // 画像パスを設定
    $post->date = $date; // 日時を設定

    $post->save(); // 画像パスが null でも保存されるようになった

    // 一覧画面へ遷移して、バリデーションメッセージを表示する
    return redirect()->route('post.index')->with('message', '登録しました');
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {   
        //編集する投稿を引っ張ってくる
        $post = Post::find($id);
        // 材料の値を改行で分割して配列に変換
        $items = explode("\n", $post->item);

        // 調味料の値を改行で分割して配列に変換
        $seasonings = explode("\n", $post->seasoning);

        // 日時をCarbonオブジェクトに変換
        $post->date = Carbon::parse($post->date);

        //編集画面へ遷移
        return view('post.edit', [
            'post' => $post,
            // 材料の値をビューに渡す
            'items' => $items,
            // 調味料の値をビューに渡す
            'seasonings' => $seasonings,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostRequest $request, Post $post)
    
    {  
        $image = $request->file('image');
        // 現在の画像へのパスをセット
        $path = $post->image;
        if (isset($image)) {
            //投稿データの内imageカラムがnull以外の時には元々の画像データを削除する
            if ($path !== null) {
                \Storage::disk('public')->delete($path);

                // s3の記述方法
                // Storage::disk('s3')->delete($path);
            }
            // 選択された画像ファイルを保存してパスをセット
            $path = $image->store('posts', 'public');
        }

        // 日付のみを取得
        $date = Carbon::parse($request->input('date'))->toDateString();

        // データベースを更新
        $post->update([
            'name' => $request->name,
            'body' => $request->body,
            //implode()関数を使って配列を改行区切りの文字列に変換すること、配列を文字列に変換できるため正常に更新ができる。
            //また配列を更新するためのキーを指定する必要があります。
            'item' => implode("\n", $request->input('item')),
            'seasoning' => implode("\n", $request->input('seasoning')),
            'date' => $date,
            'image' => $path,
        ]);
        $post->save(); // 画像パスが null でも保存されるようになった
        // 一覧画面へ遷移して、フラッシュメッセージを表示する
        return redirect()->route('post.index')->with('message', '編集しました');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)

    {
        // S3の記述方法
        // $post = Post::find($id);

        // if ($post->image !== null) {
        //     // S3から画像を削除
        //     Storage::disk('s3')->delete($post->image);
        // }

        // $post->delete();

        Post::where('id', $id)->delete();

        // フラッシュメッセージを表示
        return redirect()->route('post.index')->with('message', '削除しました');
    }
}
