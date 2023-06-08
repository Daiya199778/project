@extends('adminlte::page')

@section('title', '投稿編集')

@section('content_header')
    <h1>投稿編集</h1>
@stop

@section('content')
    @if ($errors->any())
        <div class="alert alert-warning alert-dismissible">
            {{-- エラーの表示 --}}
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- 編集画面 --}}
    <div class="card">
        <form action="{{ route('post.update', $post->id) }}" method="post">
            @csrf @method('PUT')
            <div class="card-body">
              {{-- 料理名 --}}
              <div class="form-group">
                <label for="name">料理名</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}"
                    placeholder="料理名" />
              </div>
              {{-- 料理詳細 --}}
              <div class="form-group">
                <label for="body">内容</label>
                <input type="text" class="form-control" id="body" name="body" value="{{ old('body') }}"
                    placeholder="内容" />
              </div>
              {{-- 材料 --}}
              <div class="form-group">
                <label for="item">材料</label>
                <input type="text" class="form-control" id="item" name="item" value="{{ old('item') }}"
                    placeholder="材料" />
              </div>
              {{-- 写真 --}}
              <div class="form-group">
                <label for="image">写真</label>
                <input type="text" class="form-control" id="image" name="image" value="{{ old('image') }}"
                    placeholder="写真" />
              </div>
            </div>
            <div class="card-footer">
                <div class="row">
                    <a class="btn btn-default" href="{{ route('post.index') }}" role="button">戻る</a>
                    <div class="ml-auto">
                        <button type="submit" class="btn btn-primary">編集</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@stop