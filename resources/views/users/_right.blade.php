

<div class="card">
  <div class="card-body">
   @include('posts._post_list',['posts'=>$user->posts()->with('category','user')->paginate(10)])

  </div>
</div>
