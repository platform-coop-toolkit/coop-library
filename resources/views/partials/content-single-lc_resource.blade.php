<article @php post_class() @endphp>
  <div class="page-header resource__header">
    <p class="resource__format">
      @svg(Single::getFormatSlug(), 'icon--' . Single::getFormatSlug(), ['focusable' => 'false', 'aria-hidden' => 'true']) {{ Single::getFormat() }}
    </p>
    <h1 class="resource__title">{!! get_the_title() !!}</h1>
    @if(Single::getPublisher() || Single::getRegion())
    <p class="resource__meta">
    @if(Single::getPublisher())
      <span class="resource__publisher byline vcard">{{ __('By', 'coop-library') }} {!! Single::getPublisher() !!}</span>
    @endif
    @if(Single::getRegion())
      <span class="resource__locality">@svg('location', 'icon--location', ['focusable' => 'false', 'aria-hidden' => 'true']) {{ Archive::getRegion() }}</span>
    @endif
    </p>
    @endif
  </div>
  <div class="resource__abstract">
    <h2>{{ __('Summary', 'coop-library') }}</h2>
    @php the_content() @endphp
  </div>
  @if(Single::getTopics())
  <div class="resource__tags">
    <ul class="tags">
      @foreach(Single::getTopics() as $topic)
      <li class="tag"><a class="tag__link" href="{{ $topic['url'] }}"><span class="screen-reader-text">{{ __('Topic', 'coop-library') }}: </span>{{ $topic['name'] }}</a></li>
      @endforeach
    </ul>
  </div>
  @endif
  <div class="resource__cta"></div>
  <div class="resource__actions">
    <ul class="permalinks">
      <li><a href="{{ Single::getPermanentLink() }}">{{ __('Visit full resource', 'coop-library') }}</a></li>
      @if(Single::getPermaCcLinks())
        @foreach(Single::getPermaCcLinks() as $link)
          @if($loop->count > 1)
            <li><a href="{{ $link }}">{{ sprintf(__('Visit resource on Perma.cc (%1$d of %2$d)', 'coop-library'), $loop->iteration, $loop->count) }}</a></li>
          @else
            <li><a href="{{ $link }}">{{ __('Visit resource on Perma.cc', 'coop-library') }}</a></li>
          @endif
        @endforeach
      @endif
      @if(Single::getWaybackMachineLinks())
        @foreach(Single::getWaybackMachineLinks() as $link)
          @if($loop->count > 1)
            <li><a href="{{ $link }}">{{ sprintf(__('Visit resource on the Internet Archive (%1$d of %2$d)', 'coop-library'), $loop->iteration, $loop->count) }}</a></li>
          @else
            <li><a href="{{ $link }}">{{ __('Visit resource on the Internet Archive', 'coop-library') }}</a></li>
          @endif
        @endforeach
      @endif
    </ul>
    <nav class="engage">
      <ul>
        <li><a href="#">Favourite</a></li>
        <li><a href="#">Share</a></li>
        <li><a href="#">Recommend</a></li>
      </ul>
    </nav>
  </div>
  @php comments_template('/partials/comments.blade.php') @endphp
</article>
