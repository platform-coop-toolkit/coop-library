<div class="page-header">
  @if(App::breadcrumb())
    <p class="breadcrumb">{!! App::breadcrumb() !!}</p>
  @endif
  <h1>{!! App::title() !!}</h1>
  @if(is_front_page())
  <p class="subhead">{{ get_bloginfo('description') }}</p>
  @endif
</div>
