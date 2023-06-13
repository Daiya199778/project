@extends('adminlte::page')

@section('title', '投稿一覧')

@section('content_header')
    <div class="text-center">
        <h1>投稿一覧</h1>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-md-4">
            {{-- 新規投稿画面へ --}}
            <a class="btn btn-primary mb-2" href="{{ route('post.create') }}" role="button">新規投稿</a>
        </div>
        <div class="col-md-8 d-flex justify-content-end">
            <form class="form-inline">
                <div class="form-group">
                    <input type="search" class="form-control mr-2" name="search" value="{{ request('search') }}" placeholder="キーワードを入力" aria-label="検索...">
                </div>
                <input type="submit" value="検索" class="btn btn-info">
            </form>
        </div>
    </div>

    {{-- 完了メッセージ --}}
    @if (session('message'))
        <div class="alert alert-info alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            {{ session('message') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th style="width: 150px">料理名</th>
                        <th>内容</th>
                        <th>材料</th>
                        <th style="width: 150px">写真</th>
                        <th style="width: 70px"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($posts as $post)
                        <tr>
                            <td>{{ $post->name }}</td>
                            <td>{{ $post->body }}</td>
                            <td>{{ $post->item }}</td>
                            <td>
                                @if($post->image)
                                    <img src="{{ asset('storage/' . $post->image) }}" style="max-width: 300px; max-height: auto;">
                                    <!-- AWS_S3に保存するようにするとなぜかうまくいかない。 -->
                                    <!-- <img src="{{ Storage::disk('s3')->url($post->image) }}" style="max-width: 300px; max-height: auto;"> -->
                                @else
                                    <img src="{{ asset('storage/image/no_image.png') }}" style="max-width: 300px; max-height: auto;">
                                @endif
                            </td>
                            <td>
                                <a class="btn btn-primary btn-sm mb-2" href="{{ route('post.edit', $post->id) }}" role="button">編集</a>
                                <form action="{{ route('post.destroy', $post->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    {{-- 簡易的に確認メッセージを表示 --}}
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('削除してもよろしいですか?');">削除</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- ページネーション --}}
        <div class="d-flex justify-content-center ">
            {{ $posts->links() }}
        </div>
    </div>
@stop
