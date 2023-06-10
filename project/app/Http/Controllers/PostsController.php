<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Http\Requests\PostRequest;

class PostsController extends Controller

{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      // 投稿の一覧を表示させる
    //   $posts = Post::all();

      // ページネーション
      $posts = Post::paginate(3);

      $posts = Post::orderBy('created_at', 'desc')->where(function ($query) {

        // 検索機能の記述の追加
        if ($search = request('search')) {
            $query->where('name', 'LIKE', "%{$search}%")->orWhere('body','LIKE',"%{$search}%")
            ;
        }
      })->paginate(3);

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
    } else {
        $path = null; // 画像が追加されていない場合は、$path を null に設定
    }

    // リクエストデータを使用して新しいPostモデルを作成し、データベースに保存
    $post = new Post();
    $post->name = $request->input('name');
    $post->body = $request->input('body');
    $post->item = $request->input('item');
    $post->image = $path; // 画像パスを保存

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
        //編集する投稿を引っ張ってくる
    {   $post = Post::find($id);

        //編集画面へ遷移
        return view('post.edit', [
            'post' => $post
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostRequest $request, Post $post)
    
    {  // 画像ファイルインスタンス取得
        $image = $request->file('image');
        // 現在の画像へのパスをセット
        $path = $post->image;
        if (isset($image)) {
            //投稿データの内imageカラムがnull以外の時には元々の画像データを削除する
            if ($path !== null) {
                \Storage::disk('public')->delete($path);
            }
            // 選択された画像ファイルを保存してパスをセット
            $path = $image->store('posts', 'public');
        }
        // データベースを更新
        $post->update([
            'name' => $request->name,
            'body' => $request->body,
            'item' => $request->item,
            'image' => $path,
        ]);
        // 一覧画面へ遷移して、フラッシュメッセージを表示する
        return redirect()->route('post.index')->with('message', '編集しました');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)

    {
        Post::where('id', $id)->delete();

        // フラッシュメッセージを表示
        return redirect()->route('post.index')->with('message', '削除しました');
    }
}
