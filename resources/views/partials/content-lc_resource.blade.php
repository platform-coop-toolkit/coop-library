<article @php post_class() @endphp>
  {{ $resource_format }}
  <header>
    <h2 class="entry-title"><a href="{{ get_permalink() }}">{!! get_the_title() !!}</a></h2>
  </header>
</article>
