@extends('layouts.app')

@section('title',Auth::user()->name.'的通知')
@section('content')


  <div class="row">
    <div class="col-md-8 offset-md-2">
      {{--所有未读,按类型来加载不同的消息--}}
      <div class="card">
        <div class="card-header">未读消息</div>
        <div class="card-body">
          @if($unreadNotifications->count())
            @foreach($unreadNotifications as $notification)
              {{ $notification->markAsRead() }}
              @include('notifications._' . \Illuminate\Support\Str::snake(basename($notification->type)),['notification' => $notification])
            @endforeach
            {{ $unreadNotifications->render() }}
          @else
            <p>没有未读消息</p>
          @endif
        </div>
      </div>


      {{--所有消息--}}
      <div class="card">
        <div class="card-header">所有消息</div>
        <div class="card-body">
          @if($notifications->count())
            @foreach($notifications as $notification)
              @include('notifications._' . \Illuminate\Support\Str::snake(basename($notification->type)),['notification' => $notification])
            @endforeach
            {{ $notifications->render() }}
          @endif
        </div>
      </div>
    </div>
  </div>

@stop
