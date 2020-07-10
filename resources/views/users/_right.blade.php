

<div class="card">
  <div class="card-body">
    <ul class="nav nav-tabs">
      <li class="nav item"><a href="" class="nav-link active">@if(Auth::check()) 我 @else Ta @endif的回复</a></li>
      <li class="nav item"></li>
    </ul>
    @include('posts._post_list',['posts'=>$user->posts()->with('category','user')->paginate(10)])


  </div>
</div>
