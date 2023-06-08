@extends('adminlte::page')

@section('title', '投稿一覧')

@section('content_header')
    <h1>投稿一覧</h1>
@stop

@section('content')
    {{-- 完了メッセージ --}}
    @if (session('message'))
        <div class="alert alert-info alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                ×
            </button>
            {{ session('message') }}
        </div>
    @endif

    {{-- 新規投稿画面へ --}}
    <a class="btn btn-primary mb-2" href="{{ route('post.create') }}" role="button">新規投稿</a>

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>料理名</th>
                        <th>内容</th>
                        <th>材料</th>
                        <th>写真</th>
                        <th style="width: 70px"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($posts as $post)
                        <tr>
                            <td>{{ $post->name }}</td>
                            <td>{{ $post->body }}</td>
                            <td>{{ $post->item }}</td>
                            <td>{{ $post->image }}</td>
                            <td>
                                <a class="btn btn-primary btn-sm mb-2" href="{{ route('post.edit', $post->id) }}"
                                    role="button">編集</a>
                                <form action="{{ route('post.destroy', $post->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    {{-- 簡易的に確認メッセージを表示 --}}
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('削除してもよろしいですか?');">
                                        削除
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- ページネーション --}}
        @if ($posts->hasPages())
            <div class="card-footer clearfix">
                {{ $posts->links() }}
            </div>
        @endif
    </div>
@stop