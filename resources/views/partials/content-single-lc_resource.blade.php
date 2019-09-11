<article @php post_class() @endphp>
  <header>
    <p class="before-title">
      <span class="type">{{ pll__('Resource') }}</span><span class="format">{{ $resource_format }}</span><time class="published" datetime="{{ strftime( $resource_publication_iso_date) }}">{{ $resource_publication_date }}</time>
    </p>
    <h1 class="entry-title">{!! get_the_title() !!}</h1>
    @include('partials/resource-meta')
  </header>
  <div class="entry-content">
    @php the_content() @endphp
  </div>
  <h2>{{ pll__('Goals') }}</h2>
  @if($resource_goals)
  <ul class="goals">
    @foreach($resource_goals as $goal)
    <li><a href="{{ $goal['url'] }}">{{ $goal['name'] }}</a></li>
    @endforeach
  </ul>
  @else
  <p class="no-goals">{{ pll__('This resource does not have any associated goals.') }}</p>
  @endif
  <h2>{{ pll__('Topics') }}</h2>
  @if($resource_topics)
  <ul class="topics">
    @foreach($resource_topics as $topic)
    <li><a href="{{ $topic['url'] }}">{{ $topic['name'] }}</a></li>
    @endforeach
  </ul>
  @else
  <p class="no-topics">{{ pll__('This resource does not have any associated topics.') }}</p>
  @endif
  <footer>
    <ul class="permalinks">
      <li><a href="{{ $resource_permanent_link }}">{{ pll__('Visit full resource') }}</a></li>
      @if($resource_perma_cc_links)
        @foreach($resource_perma_cc_links as $link)
          @if($loop->count > 1)
            <li><a href="{{ $link }}">{{ sprintf(pll__('Visit resource on Perma.cc (%1$d of %2$d)'), $loop->iteration, $loop->count) }}</a></li>
          @else
            <li><a href="{{ $link }}">{{ pll__('Visit resource on Perma.cc') }}</a></li>
          @endif
        @endforeach
      @endif
      @if($resource_wayback_machine_links)
        @foreach($resource_wayback_machine_links as $link)
          @if($loop->count > 1)
            <li><a href="{{ $link }}">{{ sprintf(pll__('Visit resource on the Internet Archive (%1$d of %2$d)'), $loop->iteration, $loop->count) }}</a></li>
          @else
            <li><a href="{{ $link }}">{{ pll__('Visit resource on the Internet Archive') }}</a></li>
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
