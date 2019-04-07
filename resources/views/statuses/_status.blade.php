<!-- $status 实例代表的是单条微博的数据，$user 实例代表的是该微博发布者的数据 -->
<li class="media mt-4 mb-4">
  <a href="{{ route('users.show', $user->id )}}">
    <img src="{{ $user->gravatar() }}" alt="{{ $user->name }}" class="mr-3 gravatar"/>
  </a>
  <div class="media-body">
    <h5 class="mt-0 mb-1">{{ $user->name }} <small> / {{ $status->created_at->diffForHumans() }}</small></h5>
    {{ $status->content }}
  </div>
<!-- 把删除按钮加到渲染单条微博的局部视图上,在用户发布过的每一条微博旁边加上一个删除按钮,利用 Laravel 授权策略提供的 @'can Blade 命令，在 Blade 模板中做授权判断 -->
  @can('destroy', $status)
    <form action="{{ route('statuses.destroy', $status->id) }}" method="POST" onsubmit="return confirm('您确定要删除本条微博吗？');">
      {{ csrf_field() }}
      {{ method_field('DELETE') }}
      <button type="submit" class="btn btn-sm btn-danger">删除</button>
    </form>
  @endcan
</li>
