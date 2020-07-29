<section class="home__search">
  @include('partials.search-form', ['modifier' => 'inverse', 'placeholder' => __('Search resource name, publisher, or topic…', 'coop-library')])
  {{-- TODO: Add saved searches --}}
</section>
<section class="home__browse">
  <h2>{{ __('Browse by…', 'coop-library') }}</h2>
  <ul class="link-list link-list--inverse">
    @foreach([
    'lc_topic' => __('Topics', 'coop-library'),
    'lc_goal' => __('Goals', 'coop-library'),
    'lc_sector' => __('Sectors', 'coop-library'),
    'lc_format' => __('Formats', 'coop-library'),
  ] as $slug => $label)
    <li class="link-list__item"><a href="{{ App::termListUrl($slug) }}">@svg(str_replace('lc_', '', $slug), 'icon--' . str_replace('lc_', '', $slug), ['focusable' => 'false', 'aria-hidden' => 'true']) {{ $label }}</a></li>
  @endforeach
  </ul>
  <p><a href="{{ get_post_type_archive_link('lc_resource') }}" class="link--inverse">{{ __('Browse all resources', 'coop-library') }}</a></p>
</section>
<section class="home__feed">
  <h2>{{ __('My feed', 'coop-library') }}</h2>
  <h3><a href="{{ get_post_type_archive_link('lc_resource') }}?order_by=viewed">{{ __('Most viewed', 'coop-library') }}</a></h3>
  <div class="meta-card-wrapper">
		<div class="card-wrapper">
      @if($most_viewed->have_posts())
			<ul class="cards">
        @while ($most_viewed->have_posts()) @php $most_viewed->the_post() @endphp
          <li class="card__wrapper">@include('partials.content-'.get_post_type())</li>
        @endwhile
      </ul>
      @endif
    </div>
    {{-- TODO: Add info cards --}}
  </div>
  <h3><a href="{{ get_post_type_archive_link('lc_resource') }}?order_by=published">{{ __('Recently published', 'coop-library') }}</a></h3>
  <div class="card-wrapper">
    @if($recently_published->have_posts())
    <ul class="cards">
      @while ($recently_published->have_posts()) @php $recently_published->the_post() @endphp
        @include('partials.content-'.get_post_type())
      @endwhile
    </ul>
    @endif
  </div>
</section>
