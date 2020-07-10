

<div class="card">
  <ul class="nav nav-tabs nav-pills">
    <li class="nav item"><a href="{{ request()->url() }}" class="nav-link {{ active_class( ! if_query('tab','reply'))}}">@if(Auth::id() == $user->id) 我 @else Ta @endif的帖子</a></li>
    <li class="nav item"><a href="{{ request()->url() }}?tab=reply" class="nav-link {{ active_class(  if_query('tab','reply'))}}">@if(Auth::id() == $user->id) 我 @else Ta @endif的回复</a></li>

  </ul>
  <div class="card-body">

    @if( ! if_query('tab','reply'))
      @include('posts._post_list',['posts'=>$user->posts()->with('category','user')->paginate(10)])
    @else
      @include('users._reply_list',['replies'=>$user->replies()->with('post','user')->paginate(10)])
    @endif

  </div>
</div>
