<div class="home__search-bar">
  @php(get_search_form())
</div>
{{-- TODO: Add saved searches --}}
<h2>{{ __('Browse by…', 'coop-library') }}</h2>
<ul class="link-list">
  @foreach([
  'lc_topic' => __('Topics', 'coop-library'),
  'lc_goal' => __('Goals', 'coop-library'),
  'lc_sector' => __('Sectors', 'coop-library'),
  'lc_format' => __('Formats', 'coop-library'),
] as $slug => $label)
  <li class="link-list__item"><a href="{{ App::termListUrl($slug) }}">{{ $label }}</a></li>
@endforeach
</ul>
