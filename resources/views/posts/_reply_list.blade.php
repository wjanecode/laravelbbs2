<div>

  @foreach($replies as $reply)
    <li class="media list">
      <div class="media-left mr-2">
        <a href="{{ route('users.show',[$reply->user->id,'tab'=>'reply']) }}">
          <img class="media-object list-avatar" src="{{ asset($reply->user->avatar) }}"  alt="">
        </a>
      </div>
      <div class="media-body">
        <h5 class="media-heading">
          <a href="{{ route('users.show',[$reply->user->id,'tab'=>'reply']) }}">{{ $reply->user->name }}</a> 于{{ $reply->created_at->diffForHumans() }}说:
        </h5>
        {{--删除回复,判断权限--}}
        @can('destroy',$reply)
          <form action="{{ route('replies.destroy',$reply->id) }}"method="POST" onsubmit="return confirm('确认要删除吗?')">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}
            <button  type="submit" class="btn btn-light float-right">删除</button>
          </form>
        @endcan

        <p class="">

          {!! $reply->content !!}
        </p>
      </div>
    </li>
  @endforeach

  {{ $replies->appends(request()->except('page'))->render() }}
</div>
