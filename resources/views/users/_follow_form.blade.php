<!-- 用户访问的是自己的个人页面时，关注表单不应该被显示出来，因此我们加了@'can('follow', $user)这行代码用于判断 -->
@can('follow', $user)
  <div class="text-center mt-2 mb-4">
    <!-- 通过在用户模型中定义的 isFollowing 方法来判断用户是否已被关注 -->
    @if (Auth::user()->isFollowing($user->id))
      <form action="{{ route('followers.destroy', $user->id) }}" method="post">
        {{ csrf_field() }}
        {{ method_field('DELETE') }}
        <button type="submit" class="btn btn-sm btn-outline-primary">取消关注</button>
      </form>
    @else
      <form action="{{ route('followers.store', $user->id) }}" method="post">
        {{ csrf_field() }}
        <button type="submit" class="btn btn-sm btn-primary">关注</button>
      </form>
    @endif
  </div>
@endcan
