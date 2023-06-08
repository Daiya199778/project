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
      $posts = Post::all();

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
        /*インスタンスの作成*/
        $post = new Post;

        // fillを使用し、必ずモデルのfillableも指定する
        $post->fill($request->all())->save();

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
    public function edit(string $id)
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
    public function update(PostRequest $request, string $id)
    {   //編集する投稿を引っ張ってくる
        $post = Post::find($id);
        // fillを使用し、必ずモデルのfillableも指定する
        $post->fill($request->all())->save();
        // 一覧画面へ遷移して、バリデーションメッセージを表示する
        return redirect()->route('post.index')->with('message', '編集しました');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
