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
    <p class="permalink"><a href="{{ $resource_permanent_link }}">{{ pll__('Visit full resource') }}</a></p>
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
