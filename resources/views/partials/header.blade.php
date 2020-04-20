<header role="banner">
  <div class="container">
    @include('partials.global-navigation')
    <a class="link link--brand"@if(is_front_page()) aria-current="page"@endif href="{{ ($current_language !== 'en') ? home_url("/$current_language/") : home_url('/') }}">@svg('resources', 'icon--resources', ['focusable' => 'false', 'aria-hidden' => 'true'])<span class="brand__title screen-reader-text">{{ get_bloginfo('name', 'display') }}</span></a>
    <div class="inner">
      @if(!is_front_page())
        <button class="button button--borderless search-toggle" aria-expanded="false"><span class="screen-reader-text">{{ __('Search', 'coop-library') }} </span>@svg('search', 'icon--search', ['focusable' => 'false', 'aria-hidden' => 'true'])</button>
        @include('partials.search-form')
      @endif
      <nav class="nav" aria-labelledby="menu-primary-label">
        <button class="button button--borderless menu-toggle" aria-expanded="false">
          @svg('menu', 'icon--open', ['focusable' => 'false', 'aria-hidden' => 'true'])
          @svg('close', 'icon--close', ['focusable' => 'false', 'aria-hidden' => 'true'])
          <span id="menu-primary-label" class="menu-toggle__label">Menu</span>
        </button>
        @if (has_nav_menu('primary_navigation'))
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
        @else
          <ul class="{{ (is_front_page()) ? 'menu menu--home' : 'menu' }}">
            <li class="menu-item"><a class="menu__item" @if(is_post_type_archive('lc_resource')) aria-current="page" @endif href="{{ get_post_type_archive_link('lc_resource') }}">{{ __('Explore', 'coop-library') }}</a></li>
            @include('partials.language-switcher')
          </ul>
        @endif
      </nav>
    </div>
  </div>
</header>
