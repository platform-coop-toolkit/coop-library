<li @php post_class('card card--resource') @endphp>
  <header>
    <span class="card__format">{{ Archive::getFormat() }}</span>
    @if($current_language !== Archive::getLanguage())
    <span class="sep"> &middot; </span>
    <span class="card__language">{{ $languages[Archive::getLanguage()] }}</span>
    @endif
    <h2 class="card__title"><a href="{{ get_permalink() }}">{!! Archive::getShortTitle() !!}</a></h2>
  </header>
  @if(Archive::getPublisher())
      <p class="card__byline">{{ sprintf(__('By %s', 'learning-commons'), Archive::getPublisher()) }}</p>
  @endif
  @if(Archive::getRegion())
    <p class="card__locality"><svg aria-hidden="true" class="icon icon--location"><use xlink:href="/images/location.svg"/></svg>{{ Archive::getRegion() }}</p>
  @endif
  @if(Archive::getTopics())
  <div class="card__tags">
    <ul class="badges">
      @foreach(Archive::getTopics() as $topic)
      <li class="badge"><span class="screen-reader-text">Topic: </span>{{ $topic['name'] }}</li>
      @endforeach
    </ul>
  </div>
  @endif
</li>
