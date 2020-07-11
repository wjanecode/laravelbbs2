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

    <div class="card">
      <div class="card-header">
        <h4>活跃用户</h4>
      </div>
      <div class="card-body">

      </div>
    </div>
  </div>
</div>




@stop
