@extends('layouts.app')

@section('content')

<div class="row">
  <div class="col-md-9">
    <div class="card">
      <div class="card-header">
        <ul class="nav nav-pills">
          <li class="nav-item"><a href="" class="nav-link active">最新回复</a></li>
          <li class="nav-item"><a href="" class="nav-link ">最新发布</a></li>
        </ul>
      </div>

    </div>

    <div class="card-body">
      {{--帖子列表--}}
      @include('posts._post_list',['post'=>$posts])
    </div>
  </div>

  <div class="col-md-3">
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
