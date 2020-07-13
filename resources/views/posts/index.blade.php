@extends('layouts.app')

@section('title',isset($category) ? $category->name : '帖子列表')

@section('content')

<div class="row">
  <div class="col-md-9">
    <div class="card">
      <div class="card-header">
        <ul class="nav nav-pills">
          <li class="nav-item"><a href="{{ request()->url() }}" class="nav-link {{ active_class( ! if_query('order','recentPublish')) }}">最新回复</a></li>
          <li class="nav-item"><a href="{{ request()->url() }}?order=recentPublish" class="nav-link {{  active_class( if_query('order','recentPublish')) }} ">最新发布</a></li>
        </ul>
      </div>

    </div>

    <div class="card-body">
      {{--帖子列表--}}
      @include('posts._post_list',['post'=>$posts])


    </div>

  </div>

  <div class="col-md-3">
    <div class="card text-center mb-5">
      <div class="card-header">
        <a href="{{ route('posts.create') }}" class=" nav-pills"><button class="btn btn-primary " style="width: 100%">发帖</button></a>
      </div>
    </div>

    @if (count($active_users))
      <div class="card ">
        <div class="card-body active-users pt-2">
          <div class="text-center mt-1 mb-0 text-muted">活跃用户</div>
          <hr class="mt-2">
          @foreach ($active_users as $active_user)
            <a class="media mt-2" href="{{ route('users.show', $active_user->id) }}">
              <div class="media-left media-middle mr-2 ml-1">
                <img src="{{ $active_user->avatar }}" width="24px" height="24px" class="media-object">
              </div>
              <div class="media-body">
                <small class="media-heading text-secondary">{{ $active_user->name }}</small>
              </div>
            </a>
          @endforeach
        </div>
      </div>
    @endif


  </div>
</div>




@stop
