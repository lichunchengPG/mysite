@if(Auth::user()->id !== $user->id)
<div id="follow_form">
  @if(Auth::user()->isfollowing($user->id))
    <form action="{{route('followers.destroy',$user->id)}}" method="post">
      {{method_field('DELETE')}}
      {{csrf_field()}}
      <button type="submit" class="btn btn-sm">取消关注</button>
    </form>
  @else
  <form action="{{route('followers.store',$user->id)}}" method="post">
    {{csrf_field()}}
    <button type="submit" class="btn btn-sm">关注</button>
  </form>
  @endif
</div>
@endif
