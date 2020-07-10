<div class="card">
  <div class="card-header ">
    <h4 class="text-center">{{ $post->title }}</h4>

      <div class="text-center">
        <div class="fa fa-adn  mr-3" >{{ $post->category->name}}</div>
        <div class="fa fa-adn  mr-3" >发表于{{ $post->created_at->diffForHumans()}}</div>
        <div class="fa fa-amazon mr-3">回复{{ $post->updated_at->diffForHumans()}}</div>
        <div class="fa fa-pills">回复数{{ $post->reply_count }}</div>
      </div>

    @can('update',$post)
      <div class="float-right">
        <button  class="btn mr-3 btn-sm btn-primary"><a href="{{ route('posts.edit',$post->id) }}" class="text-white">编辑</a></button>
        -
        <form action="{{ route('posts.destroy', $post->id) }}"
              method="post"
              style="display: inline-block;"
              onsubmit="return confirm('您确定要删除吗？');">
          {{ csrf_field() }}
          {{ method_field('DELETE') }}
          <button type="submit" class="btn btn-sm btn-primary ml-3">
           删除
          </button>
        </form>

      </div>
    @endcan
  </div>
  <div class="card-body">
    {!! $post->body !!}
  </div>
</div>
