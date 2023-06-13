@extends('adminlte::page')

@section('title', '投稿編集')

@section('content_header')
    <div class="text-center">
        <h1>投稿編集</h1>
    </div>
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
        <form action="{{ route('post.update', $post->id) }}" method="post" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="card-body">
              {{-- 料理名 --}}
              <div class="form-group">
                <label for="name">料理名</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') ?? $post->name}}"
                    placeholder="料理名" />
              </div>
              {{-- 料理詳細 --}}
                <div class="form-group">
                    <label for="body">内容</label>
                    <textarea class="form-control" id="body" name="body" rows="10"
                        placeholder="内容">{{ old('body') ?? $post->body}}
                    </textarea>
                </div>
                {{-- 材料 --}}
                <div class="form-group">
                    <label for="item">材料</label>
                    <textarea class="form-control" id="item" name="item" rows="8"
                        placeholder="材料">{{ old('item') ?? $post->item}}
                    </textarea>
                </div>
              {{-- 写真 --}}
              <div class="form-group">
                    <label for="image">画像登録</label>
                    <input type="file" class="form-control-file" id="image" name='image' value="{{ old('image') ?? $post->image}}">
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