<li @php post_class('card card--resource') @endphp>
  <header>
    <span class="card__format">@svg(Archive::getFormatIcon(), 'icon--' . Archive::getFormatIcon(), ['focusable' => 'false', 'aria-hidden' => 'true']) <span class="screen-reader-text">{{ __('resource format', 'coop-library') }}: </span>{{ Archive::getFormat() }}</span>
    @if($current_language !== Archive::getLanguage())
    <span class="card__sep"> &middot; </span>
    <span class="card__language">{{ $languages[Archive::getLanguage()] }}</span>
    @endif
    <h2 class="card__title"><a href="{{ get_permalink() }}">{!! Archive::getShortTitle() !!}</a></h2>
  </header>
  @if(Archive::getPublisher())
      <p class="card__byline">{{ sprintf(__('By %s', 'coop-library'), Archive::getPublisher()) }}</p>
  @endif
  @if(Archive::getRegion())
    <p class="card__locality">@svg('location', 'icon--location', ['focusable' => 'false', 'aria-hidden' => 'true']) {{ Archive::getRegion() }}</p>
  @endif
  @if(Archive::getTopics())
  <div class="card__tags">
    <ul class="badges">
      @foreach(Archive::getTopics(2) as $topic)
      <li class="badge"><span class="screen-reader-text">Topic: </span>{!! $topic['name'] !!}</li>
      @endforeach
    </ul>
    @if(Archive::getOverflowTopics())
    <p>{{ sprintf(__('+%d more', 'coop-library'), Archive::getOverflowTopics()), }}
    @endif
  </div>
  @endif
</li>
