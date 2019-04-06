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
      @yield('content')
      @include('layouts._footer')
   </div>
  </div>
</body>
</html>
