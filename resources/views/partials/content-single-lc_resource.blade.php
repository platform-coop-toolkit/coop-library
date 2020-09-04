<article @php post_class() @endphp>
  <div class="page-header resource__header">
    <h1 class="resource__title">{!! get_the_title() !!}</h1>
    @if(Single::requiresSubscription())
    <p class="resource__meta resource__subscription">@svg('lock', 'icon--lock', ['focusable' => 'false', 'aria-hidden' => 'true']) <span aria-hidden="true">{{ __('Subscription required', 'coop-library') }}</span><span class="screen-reader-text">{{ __('Subscription required to access this resource', 'coop-library') }}</span></p>
    @endif
    @if(Single::getAuthors())
    <div class="resource__meta resource__byline">@svg('author', 'icon--author', ['focusable' => 'false', 'aria-hidden' => 'true']) {{ sprintf(__('By %s', 'coop-library'), Single::getAuthors()) }}</div>
    @endif
    <div class="resource__meta">
      <div class="resource__meta-group">
          <span class="resource__format">@svg(Single::getFormatIcon(), 'icon--' . Single::getFormatIcon(), ['focusable' => 'false', 'aria-hidden' => 'true']) <span class="screen-reader-text">{{ __('resource format', 'coop-library') }}: </span>{{ Single::getFormat() }}</span>@if(Single::getPublisher())<span class="separator">.</span>
          <span class="resource__publisher">{!! sprintf(__('Published by %s', 'coop-library'), Single::getPublisher()) !!}</span>
          @endif
      </div>
      @if(Single::getRegion())
      <div class="resource__meta-group">
        <span class="resource__locality">@svg('location', 'icon--location', ['focusable' => 'false', 'aria-hidden' => 'true']) <span class="screen-reader-text">{{ __('location of relevance', 'coop-library') }}: </span>{{ Single::getRegion() }}</span>
      </div>
      @endif
      @if($current_language !== Single::getLanguage() || Single::getPublicationDate())
      <div class="resource__meta-group">
        @svg('info', 'icon--info', ['focusable' => 'false', 'aria-hidden' => 'true'])
        @if($current_language !== Single::getLanguage())
        <span class="resource__language"><span class="screen-reader-text">{{ __('language', 'coop-library') }}: </span>{{ $languages[Single::getLanguage()] }}</span>
        @endif
        @if($current_language !== Single::getLanguage() && Single::getPublicationDate())
        <span class="separator">.</span>
        @endif
        @if(Single::getPublicationDate())
        <span class="resource__date"><span class="screen-reader-text">{{ __('date published', 'coop-library') }}: </span>{{ Single::getPublicationDate() }}</span>
        @endif
      </div>
      @endif
    </div>
  </div>
  <div class="resource__abstract">
    <h2>{{ __('Summary', 'coop-library') }}</h2>
    @php the_content() @endphp
  </div>
  @if(Single::getTopics())
  <div class="resource__tags">
    <ul class="tags">
      @foreach(Single::getTopics() as $topic)
      <li class="tag"><a class="tag__link" href="{{ $topic['url'] }}"><span class="screen-reader-text">{{ __('Topic', 'coop-library') }}: </span>{!! $topic['name'] !!}</a></li>
      @endforeach
    </ul>
    {{-- <button id="suggest-edits" type="button" class="button">
      @svg('edit', 'icon--edit', ['focusable' => 'false', 'aria-hidden' => 'true'])
      <span class="button__label">{{ __('Suggest edits', 'coop-library') }}</span>
    </button> --}}
  </div>
  @endif
  <div class="resource__cta">
    <p><a rel="external" class="cta" href="{{ Single::getPermanentLink() }}">@if(Single::requiresSubscription()){{ __('Visit full resource (subscription required)', 'coop-library') }}@else{{ __('Visit full resource', 'coop-library') }}@endif @svg('external', 'icon--external', ['focusable' => 'false', 'aria-hidden' => 'true'])</a></p>
  </div>
  <div class="resource__actions">
    <button id="favorite" type="button" class="button button--borderless" data-id="{{ get_the_id() }}" data-favorite="false">
      @svg('favorite', 'icon--favorite', ['focusable' => 'false', 'aria-hidden' => 'true'])
      <span class="button__label add">{{ __('Add to Favorites', 'coop-library') }}</span>
      @svg('favorite-filled', 'icon--favorite-filled', ['focusable' => 'false', 'aria-hidden' => 'true'])
      <span class="button__label remove">{{ __('Remove from Favorites', 'coop-library') }}</span>
    </button>
    <div class="share menu-button">
      <p class="h3 menu-button__label">
        @svg('share', 'icon--share', ['focusable' => 'false', 'aria-hidden' => 'true'])
        {{ __('Share', 'coop-library') }}
      </p>
      <ul class="link-list">
        <li class="link-list__item">
          <a href="https://twitter.com/intent/tweet/?text={{ urlencode(get_the_title()) }}&url={{ urlencode(get_permalink()) }}">Twitter</a>
        </li>
        <li class="link-list__item">
          <a href="https://facebook.com/sharer/sharer.php?u={{ urlencode(get_permalink()) }}">Facebook</a>
        </li>
        <li class="link-list__item">
          <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(get_permalink()) }}&title={{ urlencode(get_the_title()) }}">LinkedIn</a>
        </li>
        <li class="link-list__item">
          <a href="mailto:?subject={{ get_the_title() }}&body={{ urlencode(get_permalink()) }}">{{ __('Email', 'coop-library') }}</a>
        </li>
      </ul>

    </div>
    {{-- <button id="report-broken-link" type="button" class="button">
      <span class="button__label">{{ __('Report broken link', 'coop-library') }}</span>
    </button> --}}
    @if(Single::getPermaCcLinks() || Single::getWaybackMachineLinks())
    <div class="alternate-links menu-button">
      <h2 class="h3 menu-button__label">{{ __('View alternate links', 'coop-library') }}</h2>
      <ul class="link-list">
        @if(Single::getPermaCcLinks())
        @foreach(Single::getPermaCcLinks() as $link)
        @if($loop->count > 1)
        <li class="link-list__item"><a href="{{ $link }}">{{ sprintf(__('View on Perma.cc (%1$d of %2$d)', 'coop-library'), $loop->iteration, $loop->count) }}</a></li>
        @else
        <li class="link-list__item"><a href="{{ $link }}">{{ __('View on Perma.cc', 'coop-library') }}</a></li>
        @endif
        @endforeach
        @endif
        @if(Single::getWaybackMachineLinks())
        @foreach(Single::getWaybackMachineLinks() as $link)
        @if($loop->count > 1)
        <li class="link-list__item"><a href="{{ $link }}">{{ sprintf(__('View on the Internet Archive (%1$d of %2$d)', 'coop-library'), $loop->iteration, $loop->count) }}</a></li>
        @else
        <li class="link-list__item"><a href="{{ $link }}">{{ __('View on the Internet Archive', 'coop-library') }}</a></li>
        @endif
        @endforeach
        @endif
      </ul>
    </div>
    @endif
  </div>
  <div class="resource__meta">
    <span class="date__added">{{ sprintf(__('Added %s', 'coop-library'), get_the_date()) }}</span>
  </div>
  @php comments_template('/partials/comments.blade.php') @endphp
</article>
