@extends('layouts.default')
@section('title', '所有用户')

@section('content')
<div class="offset-md-2 col-md-8">
  <h2 class="mb-4 text-center">所有用户</h2>

  <div class="list-group list-group-flush">
    @foreach ($users as $user)
      <!-- 引入用户局部视图到用户列表上 -->
      @include('users._user')
    @endforeach
  </div>

  <div class="mt-3">
    <!--加上渲染分页视图的代码,必须使用!!}语法-->
    {!! $users->render() !!}
  </div>

</div>
@stop
