<article @php post_class() @endphp>
  <header>
    <p class="before-title">
      <span class="type">{{ __('Resource', 'learning-commons') }}</span><span class="format">{{ $resource_format }}</span><time class="published" datetime="{{ strftime(Single::getPublicationIsoDate()) }}">{{ Single::getPublicationDate() }}</time>
    </p>
    <h1 class="entry-title">{!! get_the_title() !!}</h1>
    <p class="publication-data">
    @if(Single::getPublisher())
    <span class="byline publisher vcard">
      {{ __('By', 'learning-commons') }} {!! Single::getPublisher() !!}
    </span>
    @endif
    @if($resource_regions)
      @foreach($resource_regions as $region)
        <a href="{{ $region['url'] }}">{{ $region['name'] }}</a>
      @endforeach
    @endif
    </p>
  </header>
  <div class="entry-content">
    @php the_content() @endphp
  </div>
  <h2>{{ __('Goals', 'learning-commons') }}</h2>
  @if($resource_goals)
  <ul class="goals">
    @foreach($resource_goals as $goal)
    <li><a href="{{ $goal['url'] }}">{{ $goal['name'] }}</a></li>
    @endforeach
  </ul>
  @else
  <p class="no-goals">{{ __('This resource does not have any associated goals.', 'learning-commons') }}</p>
  @endif
  <h2>{{ __('Topics', 'learning-commons') }}</h2>
  @if($resource_topics)
  <ul class="topics">
    @foreach($resource_topics as $topic)
    <li><a href="{{ $topic['url'] }}">{{ $topic['name'] }}</a></li>
    @endforeach
  </ul>
  @else
  <p class="no-topics">{{ __('This resource does not have any associated topics.', 'learning-commons') }}</p>
  @endif
  <footer>
    <ul class="permalinks">
      <li><a href="{{ Single::getPermanentLink() }}">{{ __('Visit full resource', 'learning-commons') }}</a></li>
      @if(Single::getPermaCcLinks())
        @foreach(Single::getPermaCcLinks() as $link)
          @if($loop->count > 1)
            <li><a href="{{ $link }}">{{ sprintf(__('Visit resource on Perma.cc (%1$d of %2$d)', 'learning-commons'), $loop->iteration, $loop->count) }}</a></li>
          @else
            <li><a href="{{ $link }}">{{ __('Visit resource on Perma.cc', 'learning-commons') }}</a></li>
          @endif
        @endforeach
      @endif
      @if(Single::getWaybackMachineLinks())
        @foreach(Single::getWaybackMachineLinks() as $link)
          @if($loop->count > 1)
            <li><a href="{{ $link }}">{{ sprintf(__('Visit resource on the Internet Archive (%1$d of %2$d)', 'learning-commons'), $loop->iteration, $loop->count) }}</a></li>
          @else
            <li><a href="{{ $link }}">{{ __('Visit resource on the Internet Archive', 'learning-commons') }}</a></li>
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
  </footer>
  @php comments_template('/partials/comments.blade.php') @endphp
</article>
