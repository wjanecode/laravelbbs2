
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

            <form action="{{ route('users.update',$user->id) }} "method="POST">
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

              <div class="form-group row mb-0">
                <div class="col-md-8 offset-md-4">
                  <button type="submit" class="btn btn-primary">
                   确认提交
                  </button>
                </div>
              </div>
            </form>
        </div>
      </div>
    </div>
  </div>

@stop
