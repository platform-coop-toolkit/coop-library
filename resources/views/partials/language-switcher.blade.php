@if(function_exists('pll_the_languages') && get_field('enabled_languages', 'option'))
<li class="menu-item menu-item--languages menu__submenu-wrapper">
  <a class="menu__item" href="#">
    <span class="menu__label">{{ __('Language', 'coop-library') }}</span>
    @svg('language', 'icon--language icon--lg', ['focusable' => 'false', 'aria-hidden' => 'true'])
  </a>
  <ul class="menu__submenu">
    @if(function_exists('pll_the_languages'))
      @foreach(pll_the_languages(['raw' => 1]) as $translation)
        @if(in_array($translation['slug'], get_field('enabled_languages', 'option')))
    <li class="menu-item"><a {!! $translation['current_lang'] ? 'aria-current="true"' : '' !!}href="{{ $translation['url'] }}" class="menu__item">{{ $translation['name'] }}</a></li>
        @endif
      @endforeach
    @endif
  </ul>
</li>
@endif
