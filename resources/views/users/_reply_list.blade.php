<div>

  @foreach($replies as $reply)
    <li class="media list">
      <div class="media-left">
        <a href="{{ route('users.show',[$reply->user->id,'tab'=>'reply']) }}">
          <img class="media-object list-avatar" src="{{ asset($reply->user->avatar) }}"  alt="">
        </a>
      </div>
      <div class="media-body">
        <h5 class="media-heading ml-2">
          <a href="{{ route('users.show',[$reply->user->id,'tab'=>'reply']) }}">@if(Auth::id() == $user->id) 我 @else {{ $reply->user->name }} @endif</a> 于{{ $reply->created_at->diffForHumans() }}回复帖子:
        </h5>
        <h4><a href="{{ route('posts.show',$reply->post_id) }}">{{ $reply->post->title }}</a></h4>
        {{--删除回复,判断权限--}}
        @can('destroy',$reply)
          <form action="{{ route('replies.destroy',$reply->id) }}"method="POST" onsubmit="return confirm('确认要删除吗?')">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}
            <button  type="submit" class="btn btn-light float-right">删除</button>
          </form>
        @endcan

        <p class="ml-2">

          {!! $reply->content !!}
        </p>
      </div>
    </li>
  @endforeach

  {{ $replies->appends(request()->except('page'))->render() }}
</div>
