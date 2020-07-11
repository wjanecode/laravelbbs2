
<li class="media list">
  <div class="media-left mr-2">
    <a href="{{ route('users.show',$notification->data['reply_user_id'])  }}">
      <img class="media-object list-avatar" src="{{ asset($notification->data['reply_user_avatar']) }}" alt="">
    </a>
  </div>
  <div class="media-body">
    <div class="text-dark text-xl-left mb-3" ><a href="{{ route('users.show',$notification->data['reply_user_id'])  }}">{{ $notification->data['reply_user_name'] }}</a> 在 {{ \Carbon\Carbon::create($notification->data['reply_created_at'])->diffForHumans() }} 留言</div>
    {{-- 回复删除按钮 浮动右边,先检查是否已删除 这里有个n+1问题,还没解决 --}}
    <div class="float-right">
      @if(\App\Models\Reply::find($notification->data['reply_id']))
        <form action="{{ route('replies.destroy', $notification->data['reply_id']) }}"
              method="post"
              style="display: inline-block;"
              onsubmit="return confirm('您确定要删除吗？');">
          {{ csrf_field() }}
          {{ method_field('DELETE') }}
          <button type="submit" class="btn btn-outline-secondary btn-sm">
            <i class="far fa-trash-alt"></i> 删除回复
          </button>
        </form>
      @else
        <button type="submit" class="btn btn-outline-secondary btn-sm">
          <i class="far fa-trash-alt"></i> 该回复已删除
        </button>
      @endif
    </div>

    <h4 class="media-heading ">{{ $notification->data['reply_content'] }}</h4>
    <p><em>文章链接:</em><a href="{{ route('posts.show',[$notification->data['reply_post_id'],'']) }}"><em>{{ $notification->data['reply_post_title'] }}</em></a></p>
  </div>
</li>
