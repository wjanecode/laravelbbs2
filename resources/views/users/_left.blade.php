{{--个人信息--}}
<div class="card">
  <div class="card-body">
    <img class="card-img-top" src="{{ asset($user->avatar) }}" alt="">
    <h3 class="card-title ">{{ $user->name }}</h3>
    <p class=""><em>{{ $user->email }}</em></p>
    <h5>个人简介</h5>
    <p>{{ $user->introduction }}</p>
    <p>加入时间: {{ $user->created_at->diffForHumans() }}</p>
    <div class="text-left">
      @if( ! if_route('users.show'))
      <a href="{{ route('users.show',$user->id) }}" class="btn btn-primary">个人中心</a>
      @endif
      <p></p>

      @if(Auth::id() === $user->id)
        <a href="{{ route('users.edit',$user->id) }}" class="btn btn-primary">修改信息</a>
      @endif
    </div>
  </div>
</div>
