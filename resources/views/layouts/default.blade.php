<!DOCTYPE html>
<html>
<head>
<!--第一个参数是该区块的变量名称，第二个参数是默认值
 -->
  <title>@yield('title', '微能科技') - 为智慧商业赋能 - www.zwn.fun</title>
  <!-- <link rel="stylesheet" href="/css/app.css"> -->
  <link rel="stylesheet" href="{{ mix('css/app.css') }}">
</head>
<body>
  @include('layouts._header')

  <div class="container">
    <div class="offset-md-1 col-md-10">
      @include('shared._messages')
      @yield('content')
      @include('layouts._footer')
   </div>
  </div>
  <!--   在全局默认视图中引用编译后的 app.js 文件
 -->
 <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
