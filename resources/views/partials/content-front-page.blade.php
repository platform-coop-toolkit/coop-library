<div class="home__search-bar has-blue-400-background-color">
  @include('partials.search-form')
</div>
{{-- TODO: Add saved searches --}}
<div class="home__browse has-blue-400-background-color">
  <h2>{{ __('Browse by…', 'coop-library') }}</h2>
  <ul class="link-list">
    @foreach([
    'lc_topic' => __('Topics', 'coop-library'),
    'lc_goal' => __('Goals', 'coop-library'),
    'lc_sector' => __('Sectors', 'coop-library'),
    'lc_format' => __('Formats', 'coop-library'),
  ] as $slug => $label)
    <li class="link-list__item"><a href="{{ App::termListUrl($slug) }}">@svg(str_replace('lc_', '', $slug), 'icon--' . str_replace('lc_', '', $slug), ['focusable' => 'false', 'aria-hidden' => 'true']) {{ $label }}</a></li>
  @endforeach
  </ul>
  <div class="wp-block-button"><a href="/en/resources/" class="wp-block-button__link">{{ __('Browse all resources', 'coop-library') }}</a></div>
</div>
