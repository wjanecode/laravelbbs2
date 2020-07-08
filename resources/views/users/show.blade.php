@extends('layouts.app')
@section('content')

  <div class="container">
    <div class="row">
      {{--左边,用户信息--}}
      <div class="col-md-3">
        @include('users._left')
      </div>
      {{--右边,发布的帖子,回复--}}
      <div class="col-md-9">
        @include('users._right')
      </div>
    </div>

  </div>

@stop
