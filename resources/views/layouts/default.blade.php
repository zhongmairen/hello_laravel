<!DOCTYPE html>
<html>
<head>
<!--第一个参数是该区块的变量名称，第二个参数是默认值
 -->
  <title>@yield('title', '微能') - 微能科技 - www.zwn.fun</title>
  <!-- <link rel="stylesheet" href="/css/app.css"> -->
  <link rel="stylesheet" href="{{ mix('css/app.css') }}">
</head>
<body>

  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
      <a class="navbar-brand" href="/">微能科技</a>
      <ul class="navbar-nav justify-content-end">
          <li class="nav-item"><a class="nav-link" href="/help">帮助</a></li>
          <li class="nav-item" ><a class="nav-link" href="#">登录</a></li>
           </ul>
          </div>
        </nav>

        <div class="container">
          @yield('content')
        </div>
</body>
</html>
