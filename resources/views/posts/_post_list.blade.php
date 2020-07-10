<div>
  @foreach($posts as $post)
  <li class="media list">
    <div class="media-left">
      <a href="{{ route('users.show',$post->user->id) }}">
        <img class="media-object list-avatar" src="{{ asset($post->user->avatar) }}"  alt="">
      </a>
    </div>
    <div class="media-body">
      <h4 class="media-heading">
        <a href="{{ route('posts.show',$post->id) }}" class="ml-1">{{ $post->title }}</a>
        <a href="{{ route('posts.show',$post->id) }}" class="float-right"><span class="badge badge-pill">0</span></a>
      </h4>
      <p>
        <a href="xx" class="mr-3 ml-3 fa-link ">{{ $post->category->name }}</a> -
        <a href="xx" class="mr-3 ml-3 fa-link ">最后活跃于:{{ $post->updated_at->diffForHumans() }}</a> -
      </p>

    </div>
  </li>
  @endforeach

</div>


