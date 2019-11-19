<article @php post_class('resource') @endphp>
  <span class="resource__format">{{ $resource_format }}</a>
  <header>
    <h2 class="resource__title"><a href="{{ get_permalink() }}">{!! Archive::getShortTitle() !!}</a></h2>
  </header>
  @if(Archive::getPublisher())
      <p class="resource__publisher">{{ sprintf(__('By %s', 'learning-commons'), Archive::getPublisher()) }}</p>
  @endif
  @if($resource_goals||$resource_topics)
  <ul class="resource__tags">
    @if($resource_goals)
      @foreach($resource_goals as $goal)
      <li><a href="{{ $goal['url'] }}">{{ $goal['name'] }}</a></li>
      @endforeach
    @endif
    @if($resource_topics)
      @foreach($resource_topics as $topic)
      <li><a href="{{ $topic['url'] }}">{{ $topic['name'] }}</a></li>
      @endforeach
    @endif
  </ul>
  @endif
</article>
