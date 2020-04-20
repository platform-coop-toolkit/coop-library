@if(App::getGlobalNavigationLinks())
<nav class="global-nav" aria-labelledby="global-nav-label">
  <span id="global-nav-label" class="screen-reader-text">global navigation</span>
  <ul class="global-nav__list">
    @foreach (App::getGlobalNavigationLinks() as $link)
      @if($loop->first) <li class="global-nav__list-item global-nav__list-item--first">
      @else <li class="global-nav__list-item">
      @endif
      <a {!! $link['properties'] !!} href="{!! $link['url'] !!}" class="global-nav__link">
        @if($loop->first)
          @svg('pcc', 'icon icon--pcc', ['focusable' => 'false', 'aria-hidden' => 'true'])
        @endif
        {!! $link['label'] !!}
      </a>
      </li>
    @endforeach
  </ul class="global-nav__list">
</nav>
@endif
