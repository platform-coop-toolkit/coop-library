@if(function_exists('pll_the_languages'))
<li class="menu-item menu-item--languages menu__submenu-wrapper">
  <a class="menu__item" href="{{ get_permalink(get_page_by_path('settings/language')) }}">
    <span class="menu__label">{{ __('Language', 'coop-library') }}</span>
    @svg('language', 'icon--language icon--lg', ['focusable' => 'false', 'aria-hidden' => 'true'])
  </a>
  <ul class="menu__submenu">
    @if(function_exists('pll_the_languages'))
      @foreach(pll_the_languages(['raw' => 1]) as $translation)
    <li class="menu-item"><a {!! $translation['current_lang'] ? 'aria-current="true"' : '' !!}href="{{ $translation['url'] }}" class="menu__item">{{ $translation['name'] }}</a></li>
      @endforeach
    @endif
  </ul>
</li>
@endif
