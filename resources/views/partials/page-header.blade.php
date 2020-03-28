<div class="page-header">
  <div class="inside">
    @if(App::breadcrumb())
      <p>{!! App::breadcrumb() !!}</p>
    @endif
    <h1>{!! App::title() !!}</h1>
    @if(is_front_page())
    <p class="subhead">{{ get_bloginfo('description') }}</p>
    @endif
  </div>
</div>
@if($notifications)
@foreach($notifications as $notification)
  @component('components.notification', ['type' => $notification['type'], 'title' => $notification['title']])
    {!! $notification['content'] !!}
  @endcomponent
@endforeach
@endif
