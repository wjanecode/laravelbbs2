
@extends('layouts.app')
@section('title','编辑/新建 用户')
@section('content')

  <div class="container">
    <div class="row justify-content-center">

      <div class="card col-md-8">
          <div class="card-header">
            <h4>编辑信息</h4>
          </div>

        <div class="card-body">

            <form action="{{ route('users.update',$user->id) }} "method="POST" enctype="multipart/form-data">
              {{ method_field('PUT') }}
              {{ csrf_field() }}
              <div class="form-group row">
                <label for="email" class="col-md-4 col-form-label text-md-right">用户名</label>

                <div class="col-md-6">
                  <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name',$user->name) }}" required autocomplete="name" autofocus>

                  @error('name')
                  <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                  @enderror
                </div>
              </div>

              <div class="form-group row">
                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>
                <div class="col-md-6">
                  <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email',$user->email) }}" required autocomplete="email" autofocus>

                  @error('email')
                  <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                  @enderror
                </div>
              </div>


              <div class="form-group row">
                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>
                <div class="col-md-6">
                  <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="不填默认不更改" autocomplete="current-password">

                  @error('password')
                  <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                  @enderror
                </div>
              </div>

              <div class="form-group row">
                <label for="introduction" class="col-md-4 col-form-label text-md-right">头像</label>
                <div class="col-md-6">
                  <img id="showPic" src="{{ asset($user->avatar) }}" alt=""  style="padding-left: 0;max-height: 100px" >
                  <input type="file" id="addPic" name="avatar"  class="@error('introduction') is-invalid @enderror">

                  @error('avatar')
                  <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                  @enderror
                </div>
              </div>

              <div class="form-group row">
                <label for="introduction" class="col-md-4 col-form-label text-md-right">简介</label>
                <div class="col-md-6">
                  <textarea class="form-control @error('introduction') is-invalid @enderror" name="introduction" id="introduction" rows="3">{{ old('introduction',$user->introduction) }}</textarea>


                  @error('introduction')
                  <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                  @enderror
                </div>
              </div>

              <div class="form-group row mb-0 ">
                <div class="col-md-6 offset-md-4 ">
                  <button type="submit" class="btn btn-primary">
                   确认提交
                  </button>
                  <a class="float-right "href="javascript:history.back(-1)" >
                    返回上一页
                  </a>
                </div>
              </div>
            </form>
        </div>
      </div>
    </div>
  </div>

@stop

@section('js')
  <script>
    $(document).ready(function () {
        //点击图片,触发input的点击事件,
        $('#showPic').click(function () {
            $('#addPic').click()
        })

        //监听file类的input,有改变就把第一个文件的路径取出来
        //把取出的图片显示出来
        //这里可以执行上传
        $('#addPic').change(function () {

            $filePath = URL.createObjectURL(this.files[0])
            $('#showPic').attr('src',$filePath)
        })
    })
  </script>
@stop
