@extends('layouts.app')
@section('content')

  <div class="container">
    <div class="row">
      {{--左边,用户信息--}}
      <div class="col-md-3">
        @include('users._left',['user'=>$post->user])
      </div>
      {{--右边,发布的帖子,回复--}}
      <div class="col-md-9">
        @include('posts._right_post_content',['post'=>$post])

        {{--回复框--}}
        @include('posts._reply_box')

        {{--回复列表--}}
        @include('posts._reply_list',['replies'=>$post->replies()->with('user','post')->recent()->paginate(10)])
      </div>


    </div>

  </div>

@stop
