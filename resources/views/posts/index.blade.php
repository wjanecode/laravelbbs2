@extends('layouts.app')

@section('content')
<div class="container">
  <div class="col-md-10 offset-md-1">
    <div class="card ">
      <div class="card-header">
        <ul class="nav nav-pills">
          <li class="nav-item"><a href="" class="nav-link active">最新回复</a></li>
          <li class="nav-item"><a href="" class="nav-link ">最新发布</a></li>
        </ul>
      </div>

      <div class="card-body">
        {{--帖子列表--}}
        @include('posts._post_list',['post'=>$posts->with('user')->get()])
      </div>
    </div>
  </div>
</div>

@stop
