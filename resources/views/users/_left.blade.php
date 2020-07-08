{{--个人信息--}}
<div class="card">
  <div class="card-body">
    <img class="card-img-top" src="https://ss1.bdstatic.com/70cFuXSh_Q1YnxGkpoWK1HF6hhy/it/u=2873034231,1191081182&fm=26&gp=0.jpg" alt="">
    <h3 class="card-title text-center">{{ $user->name }}</h3>
    <p class="text-center"><em>{{ $user->email }}</em></p>
    <p>加入时间: {{ $user->created_at->diffForHumans() }}</p>

    @if(Auth::id() === $user->id)
      <a href="{{ route('users.edit',$user->id) }}" class="btn btn-primary">修改信息</a>
    @endif
  </div>
</div>
