
@include('common.error')

<div>
  <form action="{{ route('replies.store') }}" method="POST">
    {{ csrf_field() }}
    <div class="form-group ">
      <label for=""></label>
      <textarea class="form-control" name="content" id="content" cols="30" rows="3">{{ old('content') }}</textarea>
    </div>
    <input type="text" hidden name="post_id" value="{{ $post->id }}">
    <input type="text" hidden name="user_id" value="{{ Auth::id() }}">
    <button class="btn btn-primary float-right" type="submit">发表回复</button>
    <div style="clear: both" class=""></div>
  </form>
</div>
