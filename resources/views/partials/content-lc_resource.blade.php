<article @php post_class('card card--resource') @endphp>
  <header>
    <h3 class="card__title"><a class="card__link" href="{{ get_permalink() }}">{!! Archive::getShortTitle() !!}</a></h3>
    @if(Archive::getAuthors())
    <p class="card__byline">
      @svg('author', 'icon--author', ['focusable' => 'false', 'aria-hidden' => 'true'])
      {{ sprintf(__('By %s', 'coop-library'), Archive::getAuthors()) }}
    </p>
    @endif
  </header>
  <aside class="card__aside">
    <div class="card__meta">
      <span class="card__format">@svg(Archive::getFormatIcon(), 'icon--' . Archive::getFormatIcon(), ['focusable' => 'false', 'aria-hidden' => 'true']) <span class="screen-reader-text">{{ __('resource format', 'coop-library') }}: </span>{{ Archive::getFormat() }}</span>@if(Archive::getPublisher())<span class="separator">.</span>
      <span class="card__publisher"><span class="screen-reader-text">{{ __('publisher', 'coop-library' ) }}: </span>{!! Archive::getPublisher() !!}</span>
      @endif
    </div>
    @if(Archive::getRegion())
    <div class="card__meta">
      @svg('location', 'icon--location', ['focusable' => 'false', 'aria-hidden' => 'true'])
      <span class="screen-reader-text">{{ __('location of relevance', 'coop-library') }}: </span>{{ Archive::getRegion() }}
    </div>
    @endif
    @if($current_language !== Archive::getLanguage() || Archive::getPublicationDate())
    <div class="card__meta">
      @svg('info', 'icon--info', ['focusable' => 'false', 'aria-hidden' => 'true'])
      @if($current_language !== Archive::getLanguage())
      <span class="card__language"><span class="screen-reader-text">{{ __('language', 'coop-library') }}: </span>{{ $languages[Archive::getLanguage()] }}</span>
      <span class="separator">.</span>
      @endif
      @if(Archive::getPublicationDate())
      <span class="card__date"><span class="screen-reader-text">{{ __('date published', 'coop-library') }}: </span>{{ Archive::getPublicationDate('Y') }}</span>
      @endif
    </div>
    @endif
  </aside>
  @if(Archive::getTopics())
  <div class="card__tags tags">
    @foreach(Archive::getTopics(2) as $topic)
    <div class="badge"><span class="screen-reader-text">topic: </span>{!! $topic['name'] !!}</div>
    @endforeach
    @if(Archive::getOverflowTopics())
    <span class="overflow">{{ sprintf(__('+%d more', 'coop-library'), Archive::getOverflowTopics()), }}</span>
    @endif
  </div>
  @endif
  @if(Archive::isFavorited())
  <div class="card__favorite">
    @svg('favorite-filled', 'icon--favorite-filled', ['focusable' => 'false', 'aria-hidden' => 'true'])
    {{ __('Favorited', 'coop-library') }}
  </div>
  @endif
</article>
