@extends('layouts.default')
@section('title','重置密码')
@section('content')
<div class="contian-fulid">
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <div class="panel panel-default">
        <div class="panel-heading">重置密码</div>
        <div class="panel-body">
          @include('shared.errors')
          <form class="form-group" method="post" action="{{route('password.reset')}}">
            {{csrf_field()}}
            <label class="col-md-4 control-label">邮箱地址</label>
            <div class="col-md-6">
              <input type="email" class="form-control" name="email" value="{{old('email')}}" >
            </div>

            <div class="col-md-8 col-md-offset-4">
              <button type="submit" class="btn btn-primary">重置</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@stop
