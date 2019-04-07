@extends('layouts.default')
@section('title','更新个人资料')

@section('content')
<div class="offset-md-2 col-md-8">
  <div class="card ">
    <div class="card-header">
      <h5>更新个人资料</h5>
    </div>
      <div class="card-body">

        @include('shared._errors')

        <div class="gravatar_edit">
          <a href="http://gravatar.com/emails" target="_blank">
            <img src="{{ $user->gravatar('200') }}" alt="{{ $user->name }}" class="gravatar"/>
          </a>
        </div>
        <!--下面这句相当于：<form method="POST" action="http://weibo.test/users/1">
         -->
         <form method="POST" action="{{ route('users.update', $user->id )}}">
            <!--RESTful 架构中，我们使用 PATCH 动作来更新资源，但由于浏览器不支持发送 PATCH 动作，因此我们需要在表单中添加一个隐藏域来伪造 PATCH 请求，转换为 HTML 代码如下所示：<input type="hidden" name="_method" value="PATCH">
 -->            {{ method_field('PATCH') }}
            {{ csrf_field() }}

            <div class="form-group">
              <label for="name">名称：</label>
              <input type="text" name="name" class="form-control" value="{{ $user->name }}">
            </div>

            <div class="form-group">
              <label for="email">邮箱：</label>
              <!-- 邮箱输入框加上 disabled 属性来禁止用户输入 -->
              <input type="text" name="email" class="form-control" value="{{ $user->email }}" disabled>
            </div>

            <div class="form-group">
              <label for="password">密码：</label>
              <input type="password" name="password" class="form-control" value="{{ old('password') }}">
            </div>

            <div class="form-group">
              <label for="password_confirmation">确认密码：</label>
              <input type="password" name="password_confirmation" class="form-control" value="{{ old('password_confirmation') }}">
            </div>

            <button type="submit" class="btn btn-primary">更新</button>
        </form>
    </div>
  </div>
</div>
@stop
