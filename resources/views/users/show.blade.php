<!-- 个人中心页面视图 -->
@extends('layouts.default')
@section('title', $user->name)

@section('content')
<div class="row">
  <div class="offset-md-2 col-md-8">
    <!-- 局部视图：个人信息 -->
    <section class="user_info">
      @include('shared._user_info', ['user' => $user])
    </section>

    <!-- 为用户个人页面添加关注表单和信息统计视图，通过 Auth::check() 方法来判断用户是否已登录。-->
    @if (Auth::check())
      @include('users._follow_form')
    @endif

    <!-- 局部视图：关注人数、粉丝数、微博发布数 -->
    <section class="stats mt-2">
      @include('shared._stats', ['user' => $user])
    </section>
    <hr>
    <section class="status">
      @if ($statuses->count() > 0)
        <ul class="list-unstyled">
          @foreach ($statuses as $status)
            @include('statuses._status')
          @endforeach
        </ul>
        <div class="mt-5">
          {!! $statuses->render() !!}
        </div>
      @else
        <p>没有数据！</p>
      @endif
    </section>
  </div>
</div>
@stop
