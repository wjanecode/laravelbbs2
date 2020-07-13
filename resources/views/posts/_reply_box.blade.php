@section('style')
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/highlight.js/latest/styles/github.min.css">

@stop
@section('js')
  <script src="https://cdn.jsdelivr.net/highlight.js/latest/highlight.min.js"></script>
  <script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
  <script src=""></script>
  <script>
      $(document).ready(function(){
          var editor = new SimpleMDE({
              element: document.getElementById('editor1'),
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

          //editor.toggleSideBySide()//打开实时全屏预览
          editor.value({{ old('content') }})

      })
  </script>
@stop
@include('common.error')

<div>
  <form action="{{ route('replies.store') }}" method="POST">
    {{ csrf_field() }}
    <div class="form-group ">
      <label for=""></label>
      <textarea class="form-control" name="content" id="editor1"  rows="3">{{ old('content') }}</textarea>
    </div>
    <input type="text" hidden name="post_id" value="{{ $post->id }}">
    <input type="text" hidden name="user_id" value="{{ Auth::id() }}">
    <button class="btn btn-primary float-right" type="submit">发表回复</button>
    <div style="clear: both" class=""></div>
  </form>
</div>
