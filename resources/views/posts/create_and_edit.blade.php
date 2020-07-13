@extends('layouts.app')
@section('style')
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/highlight.js/latest/styles/github.min.css">

@stop
@section('js')
  <script src="https://cdn.jsdelivr.net/highlight.js/latest/highlight.min.js"></script>
  <script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
  <script src=""></script>
  <script>
      var inlineAttachmentConfig = {
          uploadUrl: 'upload_image',               //后端上传图片地址
          uploadFieldName: 'upload_file',          //上传的文件名
          jsonFieldName: 'file_path',              //返回结果中图片地址对应的字段名称
          progressText: '![图片上传中...]()',    //上传过程中用户看到的文案
          errorText: '图片上传失败',
          urlText:'![图片描述]({filename})',    //上传成功后插入编辑器中的文案，{filename} 会被替换成图片地址
          extraHeaders: {
              'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
          }
      };

      $(document).ready(function(){
      var editor = new SimpleMDE({
        element: document.getElementById('editor'),
        spellChecker: false,
        autofocus: true,
        autoDownloadFontAwesome: false,
        placeholder: "支持Markdown语法",
        // autosave: {
        //     //自动保存
        //     enabled: true,
        //     uniqueId: "demo",
        //     delay: 1000,//每10秒
        // },
        tabSize: 4,
        status: false,
        lineWrapping: false,
        renderingConfig: {
            //代码高亮,需要引入样式库和js
            codeSyntaxHighlighting: true
          },
      })
      //这里是 inlineAttachment 的调用配置
      inlineAttachment.editors.codemirror4.attach(editor.codemirror,
        inlineAttachmentConfig);

      //editor.toggleSideBySide()//打开实时全屏预览
        editor.value({{ old('body', $post->body) }})
    })
  </script>
@stop
@section('content')


<div class="">
  <div class="col-md-12 ">
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
              <label class="col-md-1 ol-form-label text-md-right">标题</label>
              <div class="col-md-10">
                <input class="form-control" type="text" name="title" id="title-field" value="{{ old('title', $post->title ) }}" />
              </div>
            </div>
            <div class="form-group row">
              <label class="col-md-1 ol-form-label text-md-right">分类</label>
              <div class="col-md-10">
                <select name="category_id" id="category_id">
                  @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                  @endforeach
                </select>
              </div>
            </div>
              <div class="form-group row">
                <label class="col-md-1 ol-form-label text-md-right">内容</label>
                <div class="col-md-10">
                  <textarea name="body" id="editor" class="form-control" rows="10">{!! old('body', $post->body) !!}</textarea>

                </div>
              </div>
          <div class="well well-sm row">
            <label class="col-md-1 ol-form-label text-md-right"></label>
            <div class="col-md-10">
              <button type="submit" class="btn btn-primary">保存</button>
              <a class="float-right"href="javascript:history.back(-1)"><--返回上一页</a>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

@stop
