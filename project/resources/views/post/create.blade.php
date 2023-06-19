@extends('adminlte::page')

@section('title', '新規投稿')

@section('content_header')
    <div class="text-center">
        <h1>新規投稿</h1>
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

    {{-- 登録画面 --}}
    <div class="card">
        <form action="{{ route('post.store') }}" method="post" enctype="multipart/form-data">
            @csrf
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
                    <textarea class="form-control" id="body" name="body" rows="10" placeholder="内容">{{ old('body') }}</textarea>
                </div>
                {{-- 材料 --}}
                <div class="form-group">
                    <label for="item">材料</label>
                    @if(old('item'))
                        @foreach(old('item') as $item)
                            <div class="input-group mb-3">
                                <textarea class="form-control" name="item[]" rows="1" placeholder="材料">{{ $item }}</textarea>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary remove-item" type="button"><i class="fa fa-minus"></i></button>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="input-group mb-3">
                            <textarea class="form-control" name="item[]" rows="1" placeholder="材料"></textarea>
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary remove-item" type="button"><i class="fa fa-minus"></i></button>
                            </div>
                        </div>
                    @endif
                    <div id="item-container"></div>
                    <div class="mt-2">
                        <button class="btn btn-outline-secondary add-item" type="button"><i class="fa fa-plus"></i> 材料を追加</button>
                    </div>
                </div>
                {{-- 写真 --}}
                <div class="form-group">
                    <label for="image">画像登録</label>
                    <input type="file" class="form-control-file" id="image" name='image' value="{{ old('image') }}">
                </div>
            </div>
            <div class="card-footer">
                <div class="row">
                    <a class="btn btn-default" href="{{ route('post.index') }}" role="button">戻る</a>
                    <div class="ml-auto">
                        <button type="submit" class="btn btn-primary">登録</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@stop

@section('adminlte_js')
    <script src="{{ asset('js/form.js') }}"></script>
@stop