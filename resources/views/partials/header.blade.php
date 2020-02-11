<header role="banner">
  <div class="container">
    <a class="link link--brand"@if(is_front_page()) aria-current="page"@endif href="{{ home_url('/') }}">@svg('pcc', 'icon--pcc', ['focusable' => 'false', 'aria-hidden' => 'true'])<span class="brand__title screen-reader-text">{{ get_bloginfo('name', 'display') }}</span></a>
    <div class="inner">
      @if(!is_front_page())
        <button class="button search-toggle" aria-expanded="false"><span class="screen-reader-text">{{ __('Search', 'coop-library') }} </span>@svg('search', 'icon--search', ['focusable' => 'false', 'aria-hidden' => 'true'])</button>
        @include('partials.search-form')
      @endif
      <nav aria-labelledby="menu-primary-label">
        @if (has_nav_menu('primary_navigation'))
          <button class="button menu-toggle" aria-expanded="false">
            @svg('menu', 'icon--open', ['focusable' => 'false', 'aria-hidden' => 'true'])
            @svg('close', 'icon--close', ['focusable' => 'false', 'aria-hidden' => 'true'])
            <span id="menu-primary-label" class="menu-toggle__label">Menu</span>
          </button>
          {!! wp_nav_menu([
            'theme_location' => 'primary_navigation',
            'menu_class' => (is_front_page()) ? 'menu menu--home' : 'menu',
            'container' => false,
            'before' => '<li class="%s">',
            'after' => '</li>',
            'before_submenu' => '<ul class="%s">',
            'after_submenu' => '</ul>',
            'walker' => new App\Walker()
          ]) !!}
        @endif
      </nav>
    </div>
  </div>
</header>
