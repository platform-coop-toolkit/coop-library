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
  <footer>
    <a href="{{ $resource_permanent_link }}">{{ pll__('Visit full resource') }}</a>
  </footer>
  @php comments_template('/partials/comments.blade.php') @endphp
</article>
