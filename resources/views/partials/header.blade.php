<header role="banner">
  <div class="container">
    <a class="brand" href="{{ home_url('/') }}">{{ get_bloginfo('name', 'display') }}</a>
    <nav aria-labelledby="menu-primary-label">
      @if (has_nav_menu('primary_navigation'))
        <button class="menu-toggle" aria-expanded="false">
          <svg class="icon icon--open" aria-hidden="true">
            <use xlink:href="/images/hamburger.svg"/>
          </svg>
          <svg class="icon icon--close" aria-hidden="true">
            <use xlink:href="/images/close.svg"/>
          </svg>
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
</header>
