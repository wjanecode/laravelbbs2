@extends('layouts.app')

@section('content')

<div class="container">
  <div class="col-md-10 offset-md-1">
    <div class="card ">

      <div class="card-header">
        <h1>
          帖子 /
          @if($post->id)
            编辑 #{{ $post->id }}
          @else
            新建
          @endif
        </h1>
      </div>

      <div class="card-body">
        @if($post->id)
          <form action="{{ route('posts.update', $post->id) }}" method="POST" accept-charset="UTF-8">
          <input type="hidden" name="_method" value="PUT">
        @else
          <form action="{{ route('posts.store') }}" method="POST" accept-charset="UTF-8">
        @endif

          @include('common.error')

          <input type="hidden" name="_token" value="{{ csrf_token() }}">


                <div class="form-group row">
                	<label class="col-md-3 ol-form-label text-md-right">标题</label>
                  <div class="col-md-8">
                    <input class="form-control" type="text" name="title" id="title-field" value="{{ old('title', $post->title ) }}" />
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-md-3 ol-form-label text-md-right">分类</label>
                  <div class="col-md-9">
                    <select name="category_id" id="category_id">
                      @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                      @endforeach
                    </select>
                  </div>

                </div>
                <div class="form-group row">
                	<label class="col-md-3 ol-form-label text-md-right">内容</label>
                  <div class="col-md-9">
                    <textarea name="body" id="body-field" class="form-control" rows="10">{!! old('body', $post->body) !!}</textarea>

                  </div>
                </div>


          <div class="well well-sm row">
            <label class="col-md-3 ol-form-label text-md-right"></label>
            <div class="col-md-9">
              <button type="submit" class="btn btn-primary">保存</button>
              <a class="float-right"href="javascript:history.back(-1)"><--返回上一页</a>
            </div>


          </div>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection
